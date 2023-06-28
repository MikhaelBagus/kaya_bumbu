<?php

namespace App\Services\Transaction;

interface TransactionServiceContract
{
    public function get(int $id);

    public function store($request);

    public function datatable($request);

    public function destroy(int $id);

    public function updatePaymentStatus(int $id, $request);

    public function updateActualOngkirPrice(int $id, $request);

    public function updateStartCooking(int $id);

    public function updateStartDelivery(int $id);

    public function updateEndDelivery(int $id, $request);

    public function updateSuspend(int $id);
}
