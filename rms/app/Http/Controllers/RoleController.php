<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $roles = Role::all();
        return view('role.index',compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guard_list = config('auth.guards');

        return view('role.create',compact('guard_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();

        $request->validate([
            'name'=>'required',
        ]);

        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $role->save();

        return redirect('/role')->with('success','Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $guard_list = config('auth.guards');

        return view('role.show', compact('role','guard_list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $getRouteCollection = Route::getRoutes(); //get and returns all returns route collection


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
                $route_list[$slices[0]][$route->uri.$route->getName()]['role_has_permission_to'] = 'Permission is Not Initialized';
            }else{
                $route_list[$slices[0]][$route->uri.$route->getName()]['role_has_permission_to'] = $role->hasPermissionTo($route->getName());
            }

        }

        $guard_list = config('auth.guards');
        return view('role.edit',compact('role','guard_list','route_list'));
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
            'name'=>'required',
        ]);

        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $role->update();

        return redirect('/role')->with('success','Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect('/role')->with('success','deleted Successfully');
    }

    /**
     * @param DataTables $datatables
     * @return mixed
     */
    public function data(DataTables $datatables)
    {
        return $datatables->eloquent(Role::query())
            ->editColumn('name',function ($role){
                return '<a href="'.url('/role/'.$role->id).'">' . $role->name . '</a>';
            })
            ->addColumn('action',function ($role){
                return view('role.actions',compact('role'));
            })
            ->rawColumns(['name', 'action'])
            ->make(true);
    }

    public function permission(Request $request, Role $role){
        $permission = Permission::where('name','=',$request->permission)->first();
        //if permission doesn't exist creates one and apply
        if($permission == null){
            dd('permission_not_initialized');
        }
        //upon request of giving permission
        if($request->checked == 'true'){
            $role->givePermissionTo($request->permission);
            echo 'permitted';
        }
        //permission revoke request
        if($request->checked == 'false'){
            $role->revokePermissionTo($request->permission);
            echo 'revoked';
        }

    }
}
