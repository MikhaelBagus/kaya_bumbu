<?php

namespace App\Services\Media;

interface MediaServiceContract
{
    public function get(int $id);

    public function store($request);

    public function update(int $id, $request);

    public function datatable($request);

    public function destroy(int $id);
}
