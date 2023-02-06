<?php

namespace App\Services\Profile;

interface ProfileServiceContract
{
    public function ProfileAPI($request);

    public function ChangeProfileAPI($request);

    public function ChangePasswordAPI($request);

    public function UserAddressAPI($request);

    public function UserAddressDetailAPI($id, $request);

    public function UserAddressCreateAPI($request);

    public function UserAddressUpdateAPI($id, $request);

    public function UserAddressDeleteAPI($id);

    public function UserRekeningAPI($request);

    public function UserRekeningDetailAPI($id, $request);

    public function UserRekeningCreateAPI($request);

    public function UserRekeningUpdateAPI($id, $request);

    public function UserRekeningDeleteAPI($id);
}
