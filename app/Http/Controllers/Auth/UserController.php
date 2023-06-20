<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\createRequest;
use App\Http\Requests\Auth\User\updateRequest;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		return view('auth.users.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$roleDb = Role::select('id','name')->get();

		return view('auth.users.create', array(
			'roleDb' => $roleDb
		));
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param createRequest $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
	public function store(createRequest $request) {
		$userDb = Sentinel::getUser();

		$email = $request->email;

		DB::beginTransaction();
		try {
			$role = Sentinel::findRoleById($request->role);

			$data = [
				'name'       => $request->name,
                'phone'      => $request->phone,
				'email'      => strtolower($email),
				'password'   => $request->password,
				'created_by' => $userDb->name,
                'updated_by' => ''
			];

			$fullname = explode(" ", $request->name);
	        $re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i";

	        if(!preg_match($re, $request->password) || !ctype_alnum($request->password) || strpos(strtolower($request->password), strtolower($fullname[0]))){
	        	Session::flash('failed', 'Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content');

	        	return redirect()->back()->withInput($request->all());
	        }
	        else if(strpos(strtolower($request->password), strtolower($fullname[0])) === 0){
	            Session::flash('failed', 'Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content');

	            return redirect()->back()->withInput($request->all());
	        }

			//Create a new user
			$user = Sentinel::registerAndActivate($data);

			//Attach the user to the role
			
			$role->users()->attach($user);

			DB::commit();

			Session::flash('success', __('auth.account_creation_successful'));

			return redirect()->route('users.index');
		}
		catch (\Exception $exception) {
			DB::rollBack();

			Session::flash('failed', $exception->getMessage().' '.$exception->getLine());

			return redirect()->back()->withInput($request->all());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return void
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {

		$user = Sentinel::findUserById($id);

		if (empty($user)) {
			Session::flash('failed', __('global.not_found'));

			return redirect()->route('users.index');
		}

		$roleDb = Role::select('id', 'name')->get();

		$userRole = $user->roles[0]->id ?? null;

		return view('auth.users.update', array(
			'data'     => $user,
			'roleDb'   => $roleDb,
			'userRole' => $userRole
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param updateRequest $request
	 * @param  int          $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function update(updateRequest $request, $id) {
		$user = Sentinel::findById($id);
		if (empty($user)) {
			Session::flash('failed', __('global.not_found'));

			return redirect()->route('users.index');
		}

		DB::beginTransaction();
		try {

			if($user->roles->isNotEmpty()){
                $oldRole = Sentinel::findRoleById($user->roles[0]->id ?? null);

                if ($oldRole) {
                    #Remove a user from a role.
                    $oldRole->users()->detach($user);
                }
            }

            #Valid User For Update
			$role = Sentinel::findRoleById($request->role);

			$credentials = [
                'name'       => $request->name,
				'phone'      => $request->phone,
				'email'      => strtolower($request->email),
                'updated_by' => $user->name
			];

			#If User Input Password
			if ($request->password) {
				$validator = Validator::make($request->all(), [
					'password' => 'min:8',
				]);

				if ($validator->fails()) {
					return redirect()->back()->withErrors($validator)->withInput();
				}

				$fullname = explode(" ", $request->name);
	        	$re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i";

				if(!preg_match($re, $request->password) || !ctype_alnum($request->password) || strpos(strtolower($request->password), strtolower($fullname[0]))){
		        	Session::flash('failed', 'Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content');

		        	return redirect()->back()->withInput($request->all());
		        }
		        else if(strpos(strtolower($request->password), strtolower($fullname[0])) === 0){
		            Session::flash('failed', 'Password must contain at least 1 number and letter, must an alphanumeric, 8 character minimum and not contain private content');

		            return redirect()->back()->withInput($request->all());
		        }

				$credentials['password'] = $request->password;
			}

			#Assign a user to a role.
			$role->users()->attach($user);

			#Update User
			Sentinel::update($user, $credentials);

			DB::commit();

			Session::flash('success', __('auth.update_successful'));

			return redirect()->route('users.index');
		}
		catch (\Exception $exception) {
			DB::rollBack();

			Session::flash('failed', $exception->getMessage().' '.$exception->getLine());

			return redirect()->back()->withInput($request->all());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {

		$data = Sentinel::findById($id);

		if (empty($data)) {
			Session::flash('failed', __('global.not_found'));

			return redirect()->route('users.index');
		}

		if (Sentinel::inRole('root') === false ) {
			Session::flash('failed', __('global.denied'));

			return redirect()->route('users.index');
		}

		if(!$data->deposit->isEmpty() || !$data->asset->isEmpty() || !$data->dividen_withdrawal->isEmpty() || !$data->notification->isEmpty()){
        	Session::flash('failed', 'Failed To Delete User because there is data connected');
            return redirect()->route('users.index');
        }
        else{
            $data->deleted_by = Sentinel::getUser()->email;
            $data->save();
			
			$data->delete();

			Session::flash('success', __('auth.delete_account'));

			return redirect()->route('users.index');
        }
	}

	/**
	 * DataTables Ajax Data
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function anyData(Request $request) {

		if ($request->ajax() == true) {
			$select = [
				'users.*'
			];

			if($request->role != null){
				$role = $request->role;

				if($request->status != null){
					$status = $request->status;

					if($status == 0){
						$dataDb = User::select($select)->whereHas('user_role', function($q) use($role) {
                                    $q->where('role_id', $role);
                                })->whereHas('activations', function($q) {
	                                $q->where('completed', 0);
	                            })->with('roles', 'activations');
					}
					else if($status == 1){
						$dataDb = User::select($select)->whereHas('user_role', function($q) use($role) {
                                    $q->where('role_id', $role);
                                })->whereHas('activations', function($q) {
	                                $q->where('completed', 1);
	                            })->with('roles', 'activations');
					}
					else{
						$dataDb = User::select($select)->whereHas('user_role', function($q) use($role) {
                                    $q->where('role_id', $role);
                                })->whereDoesntHave('activations', function($q) {
	                                $q;
	                            })->with('roles', 'activations');
					}
				}
				else{
					$dataDb = User::select($select)->whereHas('user_role', function($q) use($role) {
                                $q->where('role_id', $role);
                            })->with('roles', 'activations');
				}
			}
			else{
				if($request->status != null){
					$status = $request->status;

					if($status == 0){
						$dataDb = User::select($select)->whereHas('activations', function($q) {
	                                $q->where('completed', 0);
	                            })->with('roles', 'activations');
					}
					else if($status == 1){
						$dataDb = User::select($select)->whereHas('activations', function($q) {
	                                $q->where('completed', 1);
	                            })->with('roles', 'activations');
					}
					else{
						$dataDb = User::select($select)->whereDoesntHave('activations', function($q) {
	                                $q;
	                            })->with('roles', 'activations');
					}
				}
				else{
					$dataDb = User::select($select)->with('roles', 'activations');
				}
			}

			return DataTables::eloquent($dataDb)
			                ->addColumn('action', function ($dataDb) {
				                return '<a href="' . route('users.edit', $dataDb->id) . '" id="tooltip" title="Edit"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>';
                                // '<a href="#" data-message="' . trans('auth.delete_confirmation', ['name' => $dataDb->name]) . '" data-href="' . route('users.destroy', $dataDb->id) . '" id="tooltip" data-method="DELETE" data-title="' . trans('global.delete') . '" data-title-modal="' . trans( 'auth.delete_confirmation_heading' ) . '" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
			                })
			                ->addColumn('role', function ($dataDb) {
				                if ($dataDb->roles->isNotEmpty()) {
					                 return implode(', ', collect($dataDb->roles)->pluck('name')->all());
				                }
			                })
			                ->addColumn(
				                'photo',
				                function ($dataDb) {
				                    if($dataDb->photo == ''){
				                        return '';
				                    }
				                    else{
				                        return '<img src="'.$dataDb->photo.'" height="100px">';
				                    }
				                }
				            )
			                ->addColumn('status', function ($dataDb) {
				                if ($dataDb->activations->isNotEmpty()) {
					                if ($dataDb->activations[0]->completed == 1) {
						                return '<a href="#" data-message="' . trans('auth.deactivate_subheading', ['name' => $dataDb->name]) . '" data-href="' . route('users.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('auth.deactivate_this_user') . '" data-title-modal="' . trans('auth.deactivate_heading') . '" data-toggle="modal" data-target="#delete" title="' . trans('auth.deactivate_this_user') . '"><span class="label label-success label-sm">' . trans('auth.index_active_link') . '</span></a>';
					                }
					                else{
					                	return '<a href="#" data-message="' . trans('auth.activate_subheading', ['name' => $dataDb->name]) . '" data-href="' . route('users.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('auth.activate_this_user') . '" data-title-modal="' . trans('auth.deactivate_heading') . '" data-toggle="modal" data-target="#delete" title="' . trans('auth.activate_this_user') . '"><span class="label label-warning label-sm">' . trans('auth.index_notactive_link') . '</span></a>';
					                }
				                }
				                else{
				                	return '<a href="#" data-message="' . trans('auth.activate_subheading', ['name' => $dataDb->name]) . '" data-href="' . route('users.status', $dataDb->id) . '" id="tooltip" data-method="PUT" data-title="' . trans('auth.activate_this_user') . '" data-title-modal="' . trans('auth.deactivate_heading') . '" data-toggle="modal" data-target="#delete" title="' . trans('auth.activate_this_user') . '"><span class="label label-danger label-sm">' . trans('auth.index_inactive_link') . '</span></a>';
				                }

			                })
			                ->rawColumns(array('status', 'action'))
			                ->make(true);
		}
	}

	/**
	 * For Active or Deactive User
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function status($id) {

		$user = Sentinel::findById($id);

		// $activation = Activation::completed($user);
		$activation = Activation::where('user_id',$id)->first();

		if($activation == false){
			#Get Activation Code
			$activationCreate = Activation::create($user);

			#Activate this account
			Activation::complete($user, $activationCreate->code);

			Session::flash('success', __('auth.activate_successful'));

			return redirect()->back();
		}
		else{
			if ($activation->completed == 0) {

				#Activate this account
				Activation::complete($user, $activation->code);

				Session::flash('success', __('auth.activate_successful'));

				return redirect()->back();
			}
			else{
				#Deactivated This Activation
				if ($user->id === Sentinel::getUser()->id) {
					Session::flash('failed', __('auth.active_current_user_unsuccessful'));

					return redirect()->back();
				}

				#Remove this account
				Activation::remove($user);

				Session::flash('success', __('auth.deactivate_successful'));

				return redirect()->back();
			}
		}
	}

    /**
     * Get User Select2
     *
     * @param Request $request
     */
	public function select2(Request $request){
		if(Sentinel::getUser()){
			if ($request->ajax()) {
	            $perPage = 10;
	            $page    = $request->page ?? 1;

	            Paginator::currentPageResolver(function () use ($page) {
	                return $page;
	            });

	            $count = User::select(['users.id', 'users.email as text', 'users.name', 'users.phone'])->join('role_users','role_users.user_id','=','users.id')->count();

	            if($count > $perPage){
	                $perPage = $count;
	            }

	            $dataDb = User::select(['users.id', 'users.email as text', 'users.name', 'users.phone'])->join('role_users','role_users.user_id','=','users.id')->where('users.email', 'LIKE', '%' . $request->term . '%')->paginate($perPage);

	            return $dataDb;
	        }

	        return abort('404', 'uups');
		}
		else{
			return abort('404', 'uups');
		}
	}
}
