<?php

namespace App\Http\Controllers;

use App\Yard;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class YardController extends Controller
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view',Yard::class);
        $yards = Yard::all();
        return view('yard.index',compact('yards'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create',Yard::class);
        return view('yard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create',Yard::class);

        $yard = new Yard();

        $request->validate([
            'code'=>'required|unique:yards,code',
            'name'=>'required',
        ]);

        $yard->code = $request->code;
        $yard->name = $request->name;
        $yard->save();

        return redirect('/yard')->with('success','Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\yard $yard
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Yard $yard)
    {
        $this->authorize('view',Yard::class);
        return view('yard.show', compact('yard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\yard $yard
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Yard $yard)
    {
        $this->authorize('update',Yard::class);

        return view('yard.edit',compact('yard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\yard $yard
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Yard $yard)
    {
        $this->authorize('update',Yard::class);

        $request->validate([
            'code'=>'required|unique:yards,code,'.$yard->id,
            'name'=>'required',
        ]);

        $yard->code = $request->code;
        $yard->name = $request->name;
        $yard->update();

        return redirect('/yard')->with('success','Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\yard $yard
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Yard $yard)
    {
        $this->authorize('delete',Yard::class);

        $yard->delete();
        return redirect('/yard')->with('success','deleted Successfully');
    }

    /**
     * @param DataTables $datatables
     * @return mixed
     */
    public function data(DataTables $datatables)
    {
        return $datatables->eloquent(Yard::query())
            ->editColumn('code', function ($yard) {
                return '<a href="'.url('/yard/'.$yard->id).'">' . $yard->code . '</a>';
            })
            ->addColumn('action',function ($yard){
                return view('yard.actions',compact('yard'));
            })
            ->rawColumns(['code', 'action'])
            ->make(true);
    }

}
