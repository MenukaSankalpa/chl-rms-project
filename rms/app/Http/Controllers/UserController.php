<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
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
        $users = User::all();
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();

        $request->validate([
            'name'=>'required',
            'email'=>'email|required|unique:users,email',
            'password'=>'required_with:password_confirm|same:password_confirm',
            'password_confirm'=>'required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

//        User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);

        return redirect('/user')->with('success','Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user.show', compact('user'));
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
        return view('user.edit',compact('user'));
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

        $request->validate([
            'name'=>'required',
            'email'=>'email|required|unique:users,email,'.$user->id,
            'password'=>'same:password_confirm',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password!='') {
            $user->password = Hash::make($request->password);
        }
        $user->update();

        return redirect('/user')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/user')->with('success','deleted Successfully');
    }

    /**
     * @param DataTables $datatables
     * @return mixed
     */
    public function data(DataTables $datatables)
    {
        return $datatables->eloquent(User::query())
            ->editColumn('name', function ($user) {
                return '<a href="'.url('/user/'.$user->id).'">' . $user->name . '</a>';
            })
            ->addColumn('roles',function($user){
                return view('user.roles',compact('user'));
            })
            ->addColumn('access_rights',function($user){
                return view('user.access_rights',compact('user'));
            })
            ->addColumn('action',function ($user){
                return view('user.actions',compact('user'));
            })
            ->rawColumns(['name',"roles","access_rights",'action'])
            ->make(true);
    }

}
