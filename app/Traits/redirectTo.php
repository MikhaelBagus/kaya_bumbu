<?php

namespace App\Traits;

trait redirectTo
{

    public function redirectSuccessCreate($url, $message)
    {
        session()->flash('success', __('global.creation_successful', ['name' => $message]));
        return redirect()->to($url);
    }

    public function redirectSuccessUpdate($url, $message)
    {
        session()->flash('success', __('global.update_successful', ['name' => $message]));
        return redirect()->to($url);
    }

    public function redirectSuccessDelete($url, $message)
    {
        session()->flash('success', __('global.delete_successful', ['name' => $message]));
        return redirect()->to($url);
    }

    public function redirectSuccessBlast($url, $message)
    {
        session()->flash('success', __('global.blast_successful', ['name' => $message]));
        return redirect()->to($url);
    }

    public function redirectSuccessSend($url, $message)
    {
        session()->flash('success', __('global.send_successful', ['name' => $message]));
        return redirect()->to($url);
    }

    public function redirectFailed($url, $message)
    {
        session()->flash('failed', $message);
        return redirect()->to($url);
    }

    public function redirectSuccess($url, $message)
    {
        session()->flash('success', $message);
        return redirect()->to($url);
    }

    public function redirectSuccessAdd($url, $message)
    {
        session()->flash('success', __('global.add_successful', ['name' => $message]));
        return redirect()->to($url);
    }

    public function redirectSuccessRemove($url, $message)
    {
        session()->flash('success', __('global.remove_successful', ['name' => $message]));
        return redirect()->to($url);
    }
}