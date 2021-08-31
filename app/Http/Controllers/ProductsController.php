<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = products::all();
        $allsection = sections::all();
        return view('products.showproduct',compact('all','allsection'));
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
        $validatedata = $request->validate([
            'product_name'=>'required|unique:products|max:255'
        ],[
            'product_name.required'=>'برجــاء ادخــال اسم القسم',
            'product_name.unique'=>'اسم القسم مدخل مسبقا',

        ]);

       
            products::create([
                'product_name'=>$request->product_name,
                'description'=>$request-> description,
                'section_id'=> $request->section_id
            ]);
            session()->flash('Add','تم الاضافة بنجاح');
            return back();
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = products::findOrfail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $validatedata = $request->validate([
        //     'product_name'=>'required|max:255'
        // ],[
        //     'product_name.required'=>'برجــاء ادخــال اسم القسم',

        // ]);
        $data = products::findOrFail($request->id);
        $data->product_name = $request->product_name;
        $data->section_id  = $request->section_id;
        $data->description  = $request->description;
        $data->save();
        session()->flash('update','تم التعـديل  بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        products::findOrFail($request->id)->delete();
        session()->flash('delete','تم الحذف بنجاح');
        return back();
    }
}
