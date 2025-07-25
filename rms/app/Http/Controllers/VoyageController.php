<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoyageResourse;
use App\Vessel;
use App\Voyage;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

/**
 * Class VoyageController
 * @package App\Http\Controllers
 */
class VoyageController extends Controller
{
    /**
     * VoyageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:web,admin',['except' => ['get_voyage_by_vessel_id']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view',Voyage::class);
        $voyages = Voyage::all();
        return view('voyage.index',compact('voyages'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create',Voyage::class);
        $vessels = Vessel::all();
        return view('voyage.create',compact('vessels'));
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
        $this->authorize('create',Voyage::class);

        //
        $voyage = new Voyage();

        $request->validate([
            'code'=>'required|unique_with:voyages,code,vessel_id',
            'vessel_id'=>'required',
            'eta'=>'required',
        ]);

        $voyage->code = $request->code;
        $voyage->vessel_id = $request->vessel_id;
        $voyage->eta = $request->eta;
        $voyage->save();

        return redirect('/voyage')->with('success','Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voyage $voyage
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Voyage $voyage)
    {
        $this->authorize('view',Voyage::class);

        //
        $vessels = Vessel::all();
        return view('voyage.show',compact('vessels','voyage'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Voyage $voyage
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Voyage $voyage)
    {
        $this->authorize('update',Voyage::class);

        $vessels = Vessel::all();
        return view('voyage.edit',compact('vessels','voyage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Voyage $voyage
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Voyage $voyage)
    {
        //
        $this->authorize('update',Voyage::class);

        $request->validate([
            'code'=>'required|unique_with:voyages,code,vessel_id,'.$voyage->id,
            'vessel_id'=>'required',
            'eta'=>'required',
        ]);

        $voyage->code = $request->code;
        $voyage->vessel_id = $request->vessel_id;
        $voyage->eta = $request->eta;
        $voyage->update();

        return redirect('/voyage')->with('success','Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voyage $voyage
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Voyage $voyage)
    {
        $this->authorize('delete',Voyage::class);

        $voyage->delete();
        return redirect('/voyage')->with('success','deleted Successfully');

    }

    /**
     * @param DataTables $datatables
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(DataTables $datatables)
    {
        return $datatables->eloquent(Voyage::query()->with(['vessel'])->whereHas('vessel'))
            ->editColumn('code', function ($voyage) {
                return '<a href="'.url('/voyage/'.$voyage->id).'">' . $voyage->code . '</a>';
            })
            ->addColumn('action',function ($voyage){
                return view('voyage.actions',compact('voyage'));
            })
            ->rawColumns(['code', 'action'])
            ->make(true);
    }

    /**
     * @param $vessel_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    public function get_voyage_by_vessel_id($vessel_id){
        $voyages = Voyage::where('vessel_id',$vessel_id)->get();

        return VoyageResourse::collection($voyages);
    }

}
