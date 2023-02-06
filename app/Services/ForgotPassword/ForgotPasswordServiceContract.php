<?php

namespace App\Services\ForgotPassword;

interface ForgotPasswordServiceContract
{
    public function ForgotPasswordAPI($request);

    public function SetPasswordAPI($request);
}
