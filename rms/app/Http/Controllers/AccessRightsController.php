<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AccessRightsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('access_right.test');
        return view('access_right.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd('hi');
        $user = User::find($request->user);
        if(isset($request->submit)) {
            $user->assignRole($request->role);
        }
        if(isset($request->delete)){
            $user->removeRole($request->role);
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $getRouteCollection = Route::getRoutes(); //get and returns all returns route collection
        $roles = $user->getRoleNames();
        $all_roles = Role::where('guard_name','web')->get();

        $route_list = [];
        foreach ($getRouteCollection as $route){

            $slices = explode('/',$route->uri);
            $route_list[$slices[0]][$route->uri.$route->getName()]['name'] = $route->getName();
            $route_list[$slices[0]][$route->uri.$route->getName()]['uri'] = $route->uri;
            $route_list[$slices[0]][$route->uri.$route->getName()]['prefix'] = $route->getPrefix();
            $route_list[$slices[0]][$route->uri.$route->getName()]['actionMethod'] = $route->getActionMethod();
            $route_list[$slices[0]][$route->uri.$route->getName()]['methods'] = $route->methods();
            $permission = Permission::where('name','=',$route->getName())->first();
            $route_list[$slices[0]][$route->uri.$route->getName()]['initialized'] = $permission;
            if($permission==null){
                $route_list[$slices[0]][$route->uri.$route->getName()]['user_has_permission_to'] = 'Permission is Not Initialized';
            }else{
                $route_list[$slices[0]][$route->uri.$route->getName()]['user_has_permission_to'] = $user->hasPermissionTo($route->getName());
            }

            //initializing empty user role array.
            $route_list[$slices[0]][$route->uri.$route->getName()]['roles'][]='';

            foreach ($roles as $role){
                //user role has the permission role is collected to the array

                $r = Role::findByName($role,'web');
                if($permission!=null) {
                    if ($r->hasPermissionTo($route->getName())) {
                        $route_list[$slices[0]][$route->uri . $route->getName()]['roles'][] = $role;
                    }
                }
            }

        }

        return view('access_right.edit',compact('user','getRouteCollection','route_list','roles','all_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $permission = Permission::where('name','=',$request->permission)->first();
        //if permission doesn't exist creates one and apply
        if($permission == null){
            dd('permission_not_initialized');
        }
        //upon request of giving permission
        if($request->checked == 'true'){
            $user->givePermissionTo($request->permission);
            echo 'permitted';
        }
        //permission revoke request
        if($request->checked == 'false'){
            $user->revokePermissionTo($request->permission);
            echo 'revoked';
        }

        //var_dump($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param DataTables $datatables
     * @return mixed
     */
    public function data(DataTables $datatables)
    {
        return $datatables->eloquent(User::query())
            ->editColumn('name',function($user){
                return '<a href="#">'.$user->name.'</a>';
            })
            ->addColumn('action',function ($user){
                return view('access_right.actions',compact('user'));
            })
            ->rawColumns(['action','name'])
            ->make(true);
    }

}
