<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\redirectTo;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    use redirectTo;

    public function activation($userId, $code)
    {
        try {
            $userDb = Sentinel::findById($userId);
            if($userDb){
                if(Activation::exists($userDb, $code)){
                    $activation = Activation::where('code',$code)->first();

                    if($activation->completed == 0){
                        $activation->completed    = 1;
                        $activation->completed_at = date('Y-m-d H:i:s');
                        $activation->save();

                        $userDb->email_verified_at = date('Y-m-d H:i:s');
                        $userDb->save();

                        return $this->redirectSuccess(route('status.form'), 'Activation account success.');
                    }
                    else{
                        return $this->redirectFailed(route('status.form'), 'Invalid or expired activation code.');
                    }
                    
                }
                else{
                    return $this->redirectFailed(route('status.form'), 'Invalid or expired activation code.');
                }
            }
            else{
                return $this->redirectFailed(route('status.form'), 'Invalid or expired activation code.');
            }
        } catch (Exception $e) {
            return $this->redirectFailed(route('status.form'), 'Invalid or expired activation code.');
        }
    }
}
