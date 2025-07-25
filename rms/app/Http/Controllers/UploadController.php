<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
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
        //
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'upload_file'=>'required|file',
            'redirect_target'=>'required',
        ]);
        if($request->hasFile('upload_file')){
            //file name with extension
            $fileNameWithExt = $request->file('upload_file')->getClientOriginalName();

            //just file name
            $filename = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

            //jus ext
            $extension = $request->file('upload_file')->getClientOriginalExtension();

            //file name to store
            $fileNameToStore = $filename.'_'.auth()->user()->name.'_'.time().'.'.$extension;
            $fileNameToStore = str_replace(' ','',$fileNameToStore);

            //upload
            $path = $request->file('upload_file')->storeAs('public/uploads',$fileNameToStore);


        }else{
            $fileNameToStore = 'noimage.png';
        }

        $file = new Upload();

        $file->name = $filename;

        $file->saved_index = $fileNameToStore;

        $file->path = 'storage/uploads';

        $file->ext = $extension;

        $file->data = json_encode($request->all());

        $file->save();

        //redirect target contains the path of the reader controller that will read the uploaded file.
        return redirect($request->redirect_target.$file->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
        //
    }
}
