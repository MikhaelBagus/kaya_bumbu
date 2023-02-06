<?php

namespace App\Services\Product;

interface ProductServiceContract
{
    public function get(int $id);

    public function store($request);

    public function update(int $id, $request);

    public function datatable($request);

    public function destroy(int $id);

    public function select2($request);
}
