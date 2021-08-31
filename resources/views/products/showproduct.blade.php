@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
المــنتجات
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            @if (session()->has('Add'))
                <div class="alert alert-success alert-dismissible fade show text-center d-inline-block mb-3" role="alert">
                    <strong>{{ session()->get('Add') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session()->has('update'))
                <div class="alert alert-success alert-dismissible fade show text-center d-inline-block mb-3" role="alert">
                    <strong>{{ session()->get('update') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session()->has('delete'))
                <div class="alert alert-success alert-dismissible fade show text-center d-inline-block mb-3" role="alert">
                    <strong>{{ session()->get('delete') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
				<div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modaldemo1">اضافة منتج</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1" data-page-length="50">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">#</th>
                                                <th class="wd-15p border-bottom-0">اسم المنتج </th>
                                                <th class="wd-15p border-bottom-0">اسم القسم</th>
                                                <th class="wd-15p border-bottom-0">ملاحظات </th>
                                                <th class="wd-15p border-bottom-0">العمليات </th>
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @php
                                             $id=0;
                                         @endphp
                                            @foreach ($all as $product )
                                              
                                            <tr>
                                                <td>{{++$id}}</td>
                                                <td>{{$product->Product_name}}</td>
                                                <td>{{$product->section->section_name}}</td>
                                                <td>{{$product->description}}</td>
                                                <td>
                                                    <button class="btn btn-info edit" data-target="#modaldemo2" data-toggle="modal" data-route="{{route('products.edit',$product->id)}}" data-id="{{$product->id}}">تعديل</button>
                                                    <button class="btn btn-danger del_id" data-toggle="modal" data-target="#modaldemo3" data-id="{{$product->id}}">حذف</button>
                                                </td>
                                                
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                    <div class="modal" id="modaldemo1">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">اضافة منتج </h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                        type="button"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('products.store') }}" method="post">
                                                        {{ csrf_field() }}
                            
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">اسم المنتج</label>
                                                            <input type="text" class="form-control" id="product_name" name="product_name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">اسم القسم</label>
                                                            <select class="form-control" id="exampleFormControlSelect1" name="section_id">
                                                                @foreach ( $allsection as $section )
                                                                    
                                                                <option value="{{$section->id}}">{{$section->section_name}}</option>
                                                                @endforeach
                                                              </select>
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                        </div>
                            
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">تاكيد</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                                        </div>
                                                    </form>
                                                </div>
                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal" id="modaldemo2">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">اضافة منتج </h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                        type="button"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ url('products/update') }}" method="post">
                                                        {{ csrf_field() }}
                            
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">اسم المنتج</label>
                                                            <input type="text" class="form-control" id="product_name" name="product_name">
                                                            <input type="text" hidden class="id" id="id" name="id">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">اسم القسم</label>
                                                            <select class="form-control" id="exampleFormControlSelect1" name="section_id">
                                                                @foreach ( $allsection as $section )
                                                                    
                                                                <option value="{{$section->id}}">{{$section->section_name}}</option>
                                                                @endforeach
                                                              </select>
                                                        </div>
                            
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                        </div>
                            
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">تاكيد</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                                        </div>
                                                    </form>
                                                </div>
                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal" id="modaldemo3">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h6 class="modal-title"></h6>حذف قسم</h6><button aria-label="Close" class="close"
                                                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                       <form action="{{url('delete')}}" method="post">
                                                        @csrf
                                                        @method('get')
                                                         <input type="text" class="newId" name="id" hidden>
                                                          <p>هل انت واثق انك تريد الحذف؟؟</p>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                                            <button class="btn btn-danger delete" type="submit" 
                                                            >حذف</button>
                                                        </form>
                                                        
                                                </div>
                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script>
        var log = console.log;
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //edit
        $('button.edit').on('click', function() {

            var route = $(this).attr('data-route');
            

            $.ajax({
                url: route,
                type: "get",
                success: function(data) {
                    $('input[name="product_name"]').val(data.Product_name);
                    $('select[name="section_id"]').val(data.section_id);
                    $('textarea[name="description"]').val(data.description);
                    $('input.id').val(data.id);
                    
                }
            })
        })
        //delete 
        var id;
        $('button.del_id').on('click',function(){
            id = $(this).data('id');
            var newId = $('input.newId').val(id);
        })
    </script>
@endsection