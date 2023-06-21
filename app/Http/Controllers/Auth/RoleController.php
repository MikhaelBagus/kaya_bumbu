<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\Log;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Auth\Role\createRequest;
use App\Http\Requests\Auth\Role\updateRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class RoleController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		
		return view( 'auth.role.index' );
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'auth.role.create', array(
			'permissions' => []
		) );
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param createRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function store( createRequest $request ) {
		
		$userDb = Sentinel::getUser()->email;
		
		$data             = new Role();
		$data->name       = $request->name;
		$data->slug       = Str::slug( $request->name );
		$data->created_by = $userDb;
		$data->updated_by = '';
		
		/**
		 *  Permission Here
		 */
		$permissions       = collect( json_decode( $this->permissions( $request ) ) )->toArray();
		$data->permissions = $permissions;
		
		$data->save();

		$logDb = new Log();
        $logDb->user_id     = Sentinel::getUser()->id;
        $logDb->action      = 'Create '.$data->name;
        $logDb->menu        = 'Role';
        $logDb->item_id     = $data->id;
        $logDb->created_by  = Sentinel::getUser()->email;
        $logDb->save();
		
		Session::flash( 'success', __( 'auth.role_creation_successful' ) );
		
		return redirect()->route( 'roles.index' );
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
	public function edit( $id ) {
		
		$dataDb = Role::find( $id );
		
		if ( empty( $dataDb ) || Sentinel::getUser()->roles[0]->slug !== 'root' && $this->restricted($dataDb->slug) ) {
			Session::flash( 'failed', __( 'global.denied' ) );
			
			return redirect()->route('roles.index');
		}
		
		$permission = json_decode( json_encode( $dataDb->permissions ), true );
		
		return view( 'auth.role.update', array(
			'dataDb'      => $dataDb,
			'permissions' => $permission
		) );
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
	public function update( updateRequest $request, $id ) {
		
		$dataDb = Role::find( $id );
		
		if ( empty( $dataDb ) ) {
			Session::flash( 'failed', __( 'global.denied' ) );
			
			return redirect()->back();
		}
		
		$userDb             = Sentinel::getUser()->email;
		$dataDb->name       = $request->name;
		$dataDb->updated_by = $userDb;
		
		/**
		 *  Permission Here
		 */
		$permissions         = collect( json_decode( $this->permissions( $request ) ) )->toArray();
		$dataDb->permissions = $permissions;
		$dataDb->save();

		$logDb = new Log();
        $logDb->user_id     = Sentinel::getUser()->id;
        $logDb->action      = 'Update '.$data->name;
        $logDb->menu        = 'Role';
        $logDb->item_id     = $data->id;
        $logDb->created_by  = Sentinel::getUser()->email;
        $logDb->save();
		
		Session::flash( 'success', __( 'auth.role_update_successful' ) );
		
		return redirect()->route( 'roles.index' );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		
		$userDb = Sentinel::getUser();
		$dataDb = Sentinel::findRoleById($id);
		
		if(empty($dataDb) || $this->restricted($dataDb->slug)){
			Session::flash('failed', __('global.denied'));
			
			return redirect()->route('roles.index');
		}

        if(!$dataDb->users->isEmpty()){
        	Session::flash('failed', 'Failed To Delete Role because there is data connected');
            return redirect()->route('roles.index');
        }
        else{
            $dataDb->deleted_by = Sentinel::getUser()->email;
            $dataDb->save();

            $dataDb->users()->detach($userDb);
			$dataDb->delete();

			$logDb = new Log();
	        $logDb->user_id     = Sentinel::getUser()->id;
	        $logDb->action      = 'Delete '.$data->name;
	        $logDb->menu        = 'Role';
	        $logDb->item_id     = $data->id;
	        $logDb->created_by  = Sentinel::getUser()->email;
	        $logDb->save();
			
			Session::flash('success', __('auth.delete_account'));
			
			return redirect()->route('roles.index');
        }
	}
	
	/**
	 * DataTables Ajax Data
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function anyData() {
		$dataDb = Role::select( [
			'id',
			'slug',
			'name',
			'created_at',
			'updated_at',
			'created_by',
			'updated_by',
		] );
		
		return DataTables::eloquent( $dataDb )
		->addColumn( 'action', function ( $dataDb ) {
			if ( Sentinel::getUser()->roles[0]->slug !== 'root' && $this->restricted($dataDb->slug) ) {
				return '';
			} else {
				return '<a href="' . route( 'roles.edit', $dataDb->id ) . '" id="tooltip" title="' . __( 'global.edit' ) . '"><span class="label label-warning label-sm"><i class="fa fa-edit"></i></span></a>
				<a href="#" data-message="' . trans( 'auth.delete_confirmation', [ 'name' => $dataDb->name ] ) . '" data-href="' . route( 'roles.destroy', $dataDb->id ) . '" id="tooltip" data-method="DELETE" data-title="' . trans( 'global.delete' ) . '" data-title-modal="' . trans( 'auth.delete_confirmation_heading' ) . '" data-toggle="modal" data-target="#delete"><span class="label label-danger label-sm"><i class="fa fa-trash-o"></i></span></a>';
			}
		} )
		->make( true );
	}
	
	/**
	 * For Add Permission
	 *
	 * @param $request
	 *
	 * @return string
	 */
	private function permissions( $request ) {
		
		//Dashboard
		$permissions['dashboard'] = true;
		
		$request = $request->except( array( '_token', 'name', '_method', 'previousUrl' ) );
		
		foreach ( $request as $key => $value ) {
			$permissions[ preg_replace( '/_([^_]*)$/', '.\1', $key ) ] = true;
		}
		
		return json_encode( $permissions );
	}

    /**
     * Restricted For Edit And Destroy Role
     *
     * @param $slug
     *
     * @return bool
     */
    private function restricted($slug){
    	return $slug == 'root' || $slug == 'member';
    }

    public function select2(Request $request)
    {
    	if(Sentinel::getUser()){
	        if ($request->ajax() === true) {
	        	try {
		            $perPage = 10;
		            $page    = $request->page ?? 1;
		            $term = $request->term;

		            Paginator::currentPageResolver(
		                function () use ($page) {
		                    return $page;
		                }
		            );

		            $count = Role::count();

		            if($count > $perPage){
		                $perPage = $count;
		            }

		            $dataDb = Role::select('id', 'name as text', 'slug')->where('name', 'LIKE', '%'.$request->term.'%')->paginate($perPage);

		            return $dataDb;
		        }
		        catch (\Exception $exception) {
		            // dd($exception->getMessage());
		            return $exception->getCode();
		        }
	        }

	        return abort('404', 'uups');
	    }
        else{
            abort('404', 'uups');
        }
    }
}
