<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = sections::all();

        return view('sections.showsections',compact('all'));
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
        
        $input = $request->all();
        $validatedata = $request->validate([
            'section_name'=>'required|unique:sections|max:255'
        ],[
            'section_name.required'=>'برجــاء ادخــال اسم القسم',
            'section_name.unique'=>'اسم القسم مدخل مسبقا',

        ]);

       
            sections::create([
                'section_name'=>$request->section_name,
                'description'=>$request-> discription,
                'Created_by'=> (Auth::user()->name)
            ]);
            session()->flash('Add','تم الاضافة بنجاح');
            return back();
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $data = product::findOrFail($id);
        $data = sections::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedata = $request->validate([
            'section_name'=>'required|max:255'
        ],[
            'section_name.required'=>'برجــاء ادخــال اسم القسم',

        ]);
        $data = sections::findOrFail($request->id);
        $data->section_name = $request->section_name;
        $data->description  = $request->description;
        $data->save();
        session()->flash('update','تم التعـديل  بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        sections::findOrfail($id)->delete();
        return response()->json(['id'=>$id,
        'message'=>'تم الحذف بنجاح'
        ]);
    }
}
