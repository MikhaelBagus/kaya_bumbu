<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Requests\PrivacyPolicy\privacyPolicyRequest;
use App\Services\PrivacyPolicy\PrivacyPolicyServiceContract;
use App\Traits\redirectTo;
use App\Models\PrivacyPolicy;

class PrivacyPolicyController extends Controller
{
    use redirectTo;

    public function index()
    {
        $privacyPolicy = PrivacyPolicy::first();
        if($privacyPolicy){
            $create = false;
        }
        else{
            $create = true;
        }
        return view('backend.privacy_policy.index', compact('create'));
    }

    public function show($id, PrivacyPolicyServiceContract $privacyPolicyServiceContract)
    {
        return view('backend.privacy_policy.detail', ['privacy_policy' => $privacyPolicyServiceContract->get($id)]);
    }

    public function create()
    {
        $privacyPolicy = PrivacyPolicy::first();
        if($privacyPolicy){
            return redirect()->route('privacy_policy.index');
        }
        else{
            return view('backend.privacy_policy.create');
        }
    }

    public function store(privacyPolicyRequest $request, PrivacyPolicyServiceContract $privacyPolicyServiceContract)
    {
        #Save Privacy Policy Data
        if (is_object($privacyPolicyServiceContract->store($request))) {

            #Bump....
            return $this->redirectSuccessCreate(route('privacy_policy.index'), 'Privacy Policy');
        } else {

            #Bump....
            return $this->redirectFailed(route('privacy_policy.index'), 'Failed To Save Privacy Policy');
        }
    }

    public function edit($id, PrivacyPolicyServiceContract $privacyPolicyServiceContract)
    {
        $privacy_policy = $privacyPolicyServiceContract->get($id);
        return view('backend.privacy_policy.update', compact('privacy_policy'));
    }

    public function update(privacyPolicyRequest $request, $id, PrivacyPolicyServiceContract $privacyPolicyServiceContract)
    {
        #Save Privacy Policy Data
        if (is_object($privacyPolicyServiceContract->update($id, $request))) {

            #Bump....
            return $this->redirectSuccessUpdate(route('privacy_policy.index'), 'Privacy Policy');
        } else {

            #Bump....
            return $this->redirectFailed(route('privacy_policy.index'), 'Failed To Save Privacy Policy');
        }
    }

    public function destroy($id, PrivacyPolicyServiceContract $privacyPolicyServiceContract)
    {
        #Get services for bulk delete
        $privacyPolicyServiceContract->destroy($id);

        #Bump....
        return $this->redirectSuccessDelete(route('privacy_policy.index'), 'Privacy Policy');
    }

    public function datatable(Request $request, PrivacyPolicyServiceContract $privacyPolicyServiceContract)
    {
        if(Sentinel::getUser()){
            if ($request->ajax()) {
                # Return The JSON datatables Data
                return $privacyPolicyServiceContract->datatable($request);
            }

            abort('404', 'uups');
        }
        else{
            abort('404', 'uups');
        }
    }
}
