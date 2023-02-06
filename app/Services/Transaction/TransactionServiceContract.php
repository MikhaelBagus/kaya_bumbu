<?php

namespace App\Services\Transaction;

interface TransactionServiceContract
{
    public function get(int $id);

    public function store($request);

    public function datatable($request);

    public function destroy(int $id);
}
