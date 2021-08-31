<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoicesarchives;
use Illuminate\Http\Request;

class InvoicesarchivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.invoicesarcheves',compact('invoices'));
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
     * @param  \App\Models\invoicesarchives  $invoicesarchives
     * @return \Illuminate\Http\Response
     */
    public function show(invoicesarchives $invoicesarchives)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoicesarchives  $invoicesarchives
     * @return \Illuminate\Http\Response
     */
    public function edit(invoicesarchives $invoicesarchives)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoicesarchives  $invoicesarchives
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->restore();
       session()->flash('restore_invoice');
       return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoicesarchives  $invoicesarchives
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first()->forceDelete();
        session()->flash('delete_invoice');
        return back();

    }
}
