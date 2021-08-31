<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\products;
use App\Models\invoices_attachments;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use App\Notifications;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\UsersExport;
use App\Notifications\Add_invoice_new;
use Maatwebsite\Excel\Facades\Excel;
class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $invoices = invoices::all();
       return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();
       
        return view('invoices.addinvoices',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


           // $user = User::first();
           // Notification::send($user, new AddInvoice($invoice_id));

        $user = User::get();
        $invoices = invoices::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));

     




        

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
}



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = invoices::where('id',$id)->first();
        $sections = sections::all();
        return view('invoices.stutus_update',compact('row','sections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = invoices::findOrfail($id);
        $sections = sections::all();
        return view('invoices.editinvoices',compact('row','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $row = invoices::findOrfail($request->invoice_id);
        $row->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,   
        ]);
        session()->flash('edit','تم التعديل بنجاح');
        return back();

    }
    public function Status_update($id,Request $request){
        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }
    public function Invoices_paid(){
       $invoices = invoices::where('Value_Status',1)->get();
       return view('invoices.invoices_paid',compact('invoices'));
    }
    public function Invoices_unpaid(){
       $invoices = invoices::where('Value_Status',2)->get();
       return view('invoices.invoices_unpaid',compact('invoices'));
    }
    public function Invoices_Partial(){
       $invoices = invoices::where('Value_Status',3)->get();
       return view('invoices.invoices_Partial',compact('invoices'));
    }
    public function getproduct($id){

        $data = DB::table('products')->where('section_id',$id)->pluck('Product_name','id');

        return response()->json($data);

    }
    public function print_invoice($id){
        $invoices = invoices::where('id',$id)->first();
        return view('invoices.Print_Invoice',compact('invoices'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id',$id)->first();
        $Details = invoices_attachments::where('invoice_id',$id)->first();
        
        if($request->id_page =="2"){
            $invoices->delete();
            session()->flash('archive');
            
            return redirect('/Invoicesarchives');
              
        }else{
            if(!empty($Details->invoice_number)){
                Storage::disk('public_upload')->deleteDirectory($Details->invoice_number);
            }
            $invoices->forcedelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');
        }
    }
    public function export() 
    {
        return Excel::download(new UsersExport, 'invoices.xlsx');
    }
    public function MarkAsRead_all (Request $request)
    {

        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }
}

