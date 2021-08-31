@extends('layouts.master')
@section('title')
    الاقسام
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الاقسام</span>
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
    <div class="deletealert">

    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary" data-target="#modaldemo1" data-toggle="modal">إضافة قسم</button>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">اسم القسم</th>
                                    <th class="wd-15p border-bottom-0">الوصف</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $id = 0;
                                    
                                @endphp
                                @foreach ($all as $section)


                                    <tr id={{ $section->id }}>
                                        <td>{{ ++$id }}</td>
                                        <td>{{ $section->section_name }}</td>
                                        <td>{{ $section->description }}</td>
                                        <td>
                                            <button class="btn btn-info edit" data-toggle="modal" data-target="#modaldemo2"
                                                data-route="{{ route('sections.edit', $section->id) }}"
                                                data-id="{{ $section->id }}">تعديل</button>
                                        
                                                <button class="btn btn-danger del_id"  data-route="{{ route('section.destroy', $section->id) }}">حذف</button>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <div class="modal" id="modaldemo1">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة قسم </h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('sections.store') }}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم القسم</label>
                                <input type="text" class="form-control" id="section_name" name="section_name">
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
                        <h6 class="modal-title">تعــديل القسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('sections/update') }}" method="post">
                            {{ csrf_field() }}
                            @method('PUT')

                            <div class="form-group">
                                <input type="text" hidden class="id" name="id">
                                <label for="exampleInputEmail1">اسم القسم</label>
                                <input type="text" class="form-control" id="section_name" name="section_name">
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
                              <p>هل انت واثق انك تريد الحذف؟؟</p>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                <button class="btn btn-danger delete" data-id=""
                                >حذف</button>
                            
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
    <!-- Internal Data tables -->
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
        $(document).ready(function()
{
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //edit
        $('button.edit').on('click', function() {
            var route = $(this).attr('data-route');
            var id = $(this).attr('data-id');
            $('input.id').val(id);


            $.ajax({
                url: route,
                type: "get",
                success: function(data) {
                    $('input[name="section_name"]').val(data.section_name);
                    $('textarea#description').val(data.description);
                }
            })
        })
        //delete
        var route;
    $('button.del_id').on('click',function(){
        $('#modaldemo3').modal('show');
      route = $(this).data('route');
    })  ;
    

        $('button.delete').on('click', function() {
           

            $.ajax({
                url: route,
                type: "get",
                success: function(data) {
                    $('div.alert').remove();

                    $('#' + data.id).remove();
                    $('div.deletealert').append(`<div class="alert alert-success alert-dismissible fade show text-center d-inline-block mb-3" role="alert">
                        <strong>${data.message}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>`);
                    $('div.modal').modal('hide');
  

                }

            });
           
        });
});

    </script>
@endsection
