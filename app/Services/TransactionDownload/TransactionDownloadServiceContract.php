<?php

namespace App\Services\TransactionDownload;

interface TransactionDownloadServiceContract
{
    public function download($request);
    public function downloadRecipe($request);
}
