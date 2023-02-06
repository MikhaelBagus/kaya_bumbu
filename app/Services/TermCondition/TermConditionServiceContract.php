<?php

namespace App\Services\TermCondition;

interface TermConditionServiceContract
{
    public function get(int $id);

    public function store($request);

    public function update(int $id, $request);

    public function datatable($request);

    public function destroy(int $id);

    public function destroyBulk(array $id);

    public function select2($request);
}
