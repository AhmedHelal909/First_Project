<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
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
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $invoices = invoices::where('id','=',$id)->first();
       $details = invoices_details::where('id_Invoice','=',$id)->get();
       $attachments = invoices_attachments::where('invoice_id','=',$id)->get();
        return view('invoices.detailsinvoices',compact('invoices','details','attachments'));
    }

    public function open_file($invoice_number,$file_name){
        
        $file = Storage::disk('public_upload')->getdriver()->getAdapter()->applypathprefix($invoice_number.'/'.$file_name);
        return response()->file($file);
    }
    public function download($invoice_number,$file_name){
        $file = Storage::disk('public_upload')->getdriver()->getAdapter()->applypathprefix($invoice_number.'/'.$file_name);
        return response()->download($file);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = invoices_attachments::findOrfail($request->id_file)->delete();
        Storage::disk('public_upload')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete','تم الحذف بنجاح');
        return back();
    }
}
