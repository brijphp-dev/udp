<?php

namespace App\Http\Controllers;

use App\Models\{Role, ModelForPermission};
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data =  Role::where('slug','!=','master')->get();
            return DataTables::of($data)
                    ->addColumn('action', function($data){

                        $button = (checkPermission([app('router')->getRoutes()->getByName('role.edit.form')->uri])) ? '<a href="'.route('role.edit.form', [$data->id]).'" title="Edit" class="btn btn-sm btn-clean btn-icon mr-2" role="button" aria-pressed="true">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                </g>
                            </svg>
                        </span>
                        </a>&nbsp&nbsp' : '';
                        $button .= (checkPermission([app('router')->getRoutes()->getByName('role.destroy')->uri]) && $data->is_deletable) ? '<button data-deleteURL="'.route('role.destroy', [$data->id]).'"  title="Delete" data-alertMessage="Roles deleted won\'t be reveretback!" data-dataTableReloadid="#role_list" onclick="showcommonDeleteAlert(this)" class="btn btn-sm btn-clean btn-icon">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                        </button>' : '';

                        return $button;
                    })->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
        }
        /*$logsCollection = \Spatie\Activitylog\Models\Activity::whereIn('log_title', ['Role-Created', 'Role-Updated', 'Role-delete'])->orderBy('id', 'desc')->get();
        $logCollection = $logsCollection->map( function($log){
            $logUser = \App\User::find($log->causer_id);
            $logDetails = [];
            $logDetails['logTime'] = changeDateTimezone($log->created_at);
            $logDetails['logMessage'] = $log->description . " " . $logUser->first_name . " " . $logUser->last_name;
            return $logDetails;
        });*/

        return view('roles.list'); //, ['logCollection' => $logCollection]
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelsWithPermissions = ModelForPermission::with(['permissions:display_name,permissions_name,model_id'])->get();
        //dd($modelsWithPermissions);
        return view('roles.create', compact(['modelsWithPermissions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "udp.role_name" => "required|max:255",
            "udp.role_slug" => "required|unique:roles,slug",
            "udp.role_permission" => "required",
            "udp.role_permission.*" => "required"
        ],[
            "udp.role_slug.unique" => "Slug is already exist",
            "udp.role_permission.*" => "Role permission is required."
        ],[
            "udp.role_name" => "Role Name",
            "udp.role_slug" => "Slug",
        ]);
        return DB::transaction(function() use ($request) {
            try{
                $request = $request->except(array('_token', 'name', '_method', 'previousUrl'));

                $permissionArrat = $this->createPermissionObject($request['udp']['role_permission']);
                $insertRole = new Role();
                $insertRole->name = $request['udp']['role_name'];
                $insertRole->slug = $request['udp']['role_slug'];
                $insertRole->permissions = $permissionArrat;
                $insertRole->save();
                return redirect()->route('role.index')->with('success', 'Role added successfully!' );
            }catch (\Exception $e) {
                    DB::rollback();
                    $message = (config('app.env') == 'production') ? 'Some error, please contact developers!' : $e->getMessage();
                    \Session::flash('failed',$message);
                    return redirect()->route('role.index');
            }
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $modelsWithPermissions = ModelForPermission::with(['permissions:display_name,permissions_name,model_id'])->get();
        return view('roles.edit',['role' => ['id' => $role['id'] ,'name' => $role['name'], 'slug' =>  $role['slug'], 'permissions' => json_decode($role['permissions']) ], 'modelsWithPermissions' => $modelsWithPermissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            "bridgestone.role_name" => "required|max:255",
            "bridgestone.role_slug" => "required|unique:roles,slug,".$role->id,
            "bridgestone.role_permission.*" => "required"
        ],[
            "bridgestone.role_slug.unique" => "Slug is already exist",
        ],[
            "bridgestone.role_name" => "Role Name",
            "bridgestone.role_slug" => "Slug",
            "bridgestone.role_permission.*" => "permission"
        ]);
        return DB::transaction(function() use ($request,$role) {
            try{
                $request = $request->except(array('_token', 'name', '_method', 'previousUrl'));

                $permissionArrat = $this->createPermissionObject($request['bridgestone']['role_permission']);

                $role->name = $request['bridgestone']['role_name'];
                $role->slug= $request['bridgestone']['role_slug'];
                $role->permissions = $permissionArrat;
                $role->save();
                return redirect()->route('role.index')->with('success', 'Role Update Successfully!');
            }catch (\Exception $e) {
                DB::rollback();
                $message = (config('app.env') == 'production') ? 'Some error, please contact developers!' : $e->getMessage();
                Session::flash('failed',$message);
                return redirect()->route('role.index');
            }
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        return DB::transaction(function() use ($role) {
            try{
                $userswithRole = $role->users()->where('deleted_at',null)->orderBy('id')->get();
                if( sizeof($userswithRole) > 0 ){
                    $message = \Lang::get('userMessages.role_user_delete');
                    $message .= '<ul>';
                    foreach($userswithRole as $user){
                        $message .= '<li><a href="'.route('systemuser.edit.form', [encode_url($user->id)]).'" target="_blank">'.$user->first_name . ' ' . $user->last_name .'</a></li>';
                    }
                    $message .= '</ul>';
                    return response()->json(['message' => $message,'status'=>10]);
                }else{
                    $role->delete();
                    return response()->json(['message' => 'Role has been deleted.','status'=>1]);
                }
            }catch (\Exception $e) {
                DB::rollback();
                $message = (config('app.env') == 'production') ? \Lang::get('messages.exception_error_message') : $e->getMessage();
                return response()->json(['message' => $message,'status'=>0]);
            }
        });
    }

    public function slugCreate(Request $request)
    {
        // https://laraveldaily.com/generate-slug-keyword-from-title-laravel-ajax/
        // https://stackoverflow.com/questions/48264084/how-to-get-unique-slug-to-same-post-title-for-other-time-too

        // http://laraveleasytutorials.blogspot.com/2017/11/how-to-create-unique-slug-or-unique-url.html
        $slug = \Illuminate\Support\Str::slug($request->title, '-');
        $id = (isset($request->id)) ? $request->id : '';
        if($id != ''){
            $slugCount = count(Role::whereRaw("(slug = '$slug' and id != $id)")->get());
        }else{
            $slugCount = count(Role::whereRaw("(slug = '$slug' or slug LIKE '$slug-%') ")->get());
        }
        $slug = $slugCount == 0 ? $slug : $slug.'-'.$slugCount;
        return response()->json(['slug' => $slug]);
    }

    public function createPermissionObject($selectedPermissions)
    {
        $permissions['dashboard'] = true;
        $permissions['general.profile'] = true;
        $permissions['general.notification'] = true;
        foreach ($selectedPermissions as $key => $value) {
            $permissions[preg_replace('/_([^_]*)$/', '.\1', $value)] = true;
        }

        return json_encode($permissions);
    }
}
