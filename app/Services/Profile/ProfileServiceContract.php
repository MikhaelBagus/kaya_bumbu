<?php

namespace App\Services\Profile;

interface ProfileServiceContract
{
    public function ProfileAPI($request);

    public function ChangeProfileAPI($request);

    public function ChangePasswordAPI($request);
}
