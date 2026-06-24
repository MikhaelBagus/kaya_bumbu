<?php

namespace App\Imports;

use App\Models\IngredientMaster;
use App\Models\IngredientMasterCategory;
use App\Models\IngredientMasterGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class IngredientMasterImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();

        try {
            foreach ($rows as $index => $row) {
                $data = [
                    'nama_item'    => trim($row['nama_item'] ?? ''),
                    'sub_category' => trim($row['sub_category'] ?? ''),
                    'category'     => trim($row['category'] ?? ''),
                    'unit'         => trim($row['unit'] ?? ''),
                    'harga'        => $this->parseNumber($row['harga'] ?? 0),
                ];

                $validator = Validator::make($data, [
                    'nama_item'    => 'required',
                    'sub_category' => 'required',
                    'category'     => 'required',
                    'unit'         => 'required',
                    'harga'        => 'required|numeric|min:0',
                ]);

                if ($validator->fails()) {
                    throw ValidationException::withMessages([
                        'row_' . ($index + 2) => $validator->errors()->all(),
                    ]);
                }

                $group = IngredientMasterGroup::firstOrCreate(
                    [
                        'name' => $data['category'],
                    ],
                    [
                        'created_by' => auth()->user()->email ?? null,
                    ]
                );

                $category = IngredientMasterCategory::firstOrCreate(
                    [
                        'name' => $data['sub_category'],
                        'ingredient_group_id' => $group->id,
                    ],
                    [
                        'created_by' => auth()->user()->email ?? null,
                    ]
                );

                IngredientMaster::updateOrCreate(
                    [
                        'name' => $data['nama_item'],
                    ],
                    [
                        'ingredient_category_id' => $category->id,
                        'unit' => $data['unit'],
                        'price' => $data['harga'],
                        'updated_by' => auth()->user()->email ?? null,
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function parseNumber($value)
    {
        if ($value === null || $value === '') {
            return 0;
        }

        if (is_numeric($value)) {
            return $value;
        }

        $value = trim((string) $value);

        // Format Indonesia: 35.000,50
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }
}