<?php

namespace App\Models\Concerns;

use Illuminate\Validation\ValidationException;

trait HasUniqueIngredientName
{
    public static function bootHasUniqueIngredientName(): void
    {
        static::saving(function ($model) {
            if (! $model->isDirty('name')) {
                return;
            }

            $duplicate = static::withTrashed()
                ->where('name', $model->name)
                ->when($model->exists, function ($query) use ($model) {
                    $query->where($model->getKeyName(), '!=', $model->getKey());
                })
                ->exists();

            if ($duplicate) {
                throw ValidationException::withMessages([
                    'name' => ['Nama sudah digunakan. Nama harus unik.'],
                ]);
            }
        });
    }
}
