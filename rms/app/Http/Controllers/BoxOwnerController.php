<?php

namespace App\Http\Controllers;

use App\BoxOwner;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BoxOwnerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web,admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', BoxOwner::class);
        $box_owners = BoxOwner::all();
        return view('box_owner.index',compact('box_owners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', BoxOwner::class);

        return view('box_owner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', BoxOwner::class);

        $box_owner = new BoxOwner();

        $request->validate([
            'code'=>'required|unique:box_owners,code',
            'name'=>'required',
            'monitor_or_plug'=>'required',

        ]);

        $box_owner->code = $request->code;
        $box_owner->name = $request->name;
        $box_owner->monitor_or_plug = $request->monitor_or_plug;
        $box_owner->save();

        return redirect('/box_owner')->with('success','Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BoxOwner  $box_owner
     * @return \Illuminate\Http\Response
     */
    public function show(BoxOwner $box_owner)
    {
        $this->authorize('view', BoxOwner::class);

        return view('box_owner.show', compact('box_owner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BoxOwner  $box_owner
     * @return \Illuminate\Http\Response
     */
    public function edit(BoxOwner $box_owner)
    {
        $this->authorize('update', BoxOwner::class);

        return view('box_owner.edit',compact('box_owner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BoxOwner  $box_owner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoxOwner $box_owner)
    {
        $this->authorize('update', BoxOwner::class);

        $request->validate([
            'code'=>'required|unique:box_owners,code,'.$box_owner->id,
            'name'=>'required',
            'monitor_or_plug'=>'required',
        ]);

        $box_owner->code = $request->code;
        $box_owner->name = $request->name;
        $box_owner->monitor_or_plug = $request->monitor_or_plug;
        $box_owner->update();

        return redirect('/box_owner')->with('success','Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BoxOwner $box_owner
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(BoxOwner $box_owner)
    {
        $this->authorize('delete', BoxOwner::class);

        $box_owner->delete();
        return redirect('/box_owner')->with('success','deleted Successfully');
    }

    /**
     * @param DataTables $datatables
     * @return mixed
     */
    public function data(DataTables $datatables)
    {
        return $datatables->eloquent(BoxOwner::query())
            ->editColumn('code', function ($box_owner) {
                return '<a href="'.url('/box_owner/'.$box_owner->id).'">' . $box_owner->code . '</a>';
            })
            ->addColumn('action',function ($box_owner){
                return view('box_owner.actions',compact('box_owner'));
            })
            ->rawColumns(['code', 'action'])
            ->make(true);
    }
}
