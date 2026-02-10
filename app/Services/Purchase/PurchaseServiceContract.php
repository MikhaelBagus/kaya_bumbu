<?php

namespace App\Services\Purchase;

interface PurchaseServiceContract
{
    public function get(int $id);

    public function store($request);

    public function update(int $id, $request);

    public function datatable($request);

    public function destroy(int $id);

    public function select2($request);

    public function generatePurchaseCode();

    public function download($request);

    public function approve(int $id);
}
