<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Audit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AuditController extends Controller
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
        return view('audit.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
        return $datatables->eloquent(Audit::query())
            ->addColumn('user_name',function ($audit){

                if($audit->guard=='admin'){
                    $user = Admin::find($audit->user_id);
                }
                if($audit->guard=='web'){
                    $user = User::find($audit->user_id);
                }

                return Str::limit(isset($user) ? $user->name : "Guest User",'100','...');
            })
            ->editColumn('url',function($audit){
                return Str::limit($audit->url,'50','...');

            })
            ->rawColumns(['user_name'])
            ->make(true);
    }

}
