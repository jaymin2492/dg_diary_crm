@extends('layouts.app_loggedin')

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ URL('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ $title }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
    @include ('messages')
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    
                    <div class="col-sm-8">
                        <!-- <div class="mt-2 mt-sm-0">
                        <button type="button" class="btn btn-info mb-2">Export</button>
                        </div> -->
                    </div>
                    <div class="col-sm-4">
                    <div class="text-sm-end mt-2 mt-sm-0">
                        <a href="{{ URL('admin/'.$urlSlug.'/create') }}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add {{ $title }}</a>
                    </div>
                    </div><!-- end col-->
                </div>
                
                @if (empty($items->toArray())) 
                            <p style="margin:150px 0;" class="text-center">No Items Found</p>
                @else
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                        <thead>
                            <tr>
                                <!-- <th style="width: 20px;">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th> -->
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th style="width: 85px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <!-- <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td> -->
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                <div class="btn-group">
                                            <button type="button" class="btn btn-sm @if ($item->status == 'Active') btn-success @else btn-danger @endif dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                                @if ($item->status == 'Active') Active @else Inactive @endif
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if ($item->status == 'Active')
                                                <a class="dropdown-item change_Status deactivate_it" href="javascript: void(0);" data-id="{{ $item->id }}">Inactive</a>
                                                @else
                                                <a class="dropdown-item change_Status activate_it" href="javascript: void(0);"  data-id="{{ $item->id }}">Active</a>
                                                @endif
                                            </div>
                                        </div>
                                </td>
                                <td>
                                <a href="{{ url('/admin/'.$urlSlug. '/' . $item->id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit"><i class="mdi mdi-square-edit-outline"></i> Edit</a>
                                <!-- <form action="{{ url('/admin/'.$urlSlug. '/' . $item->id) }}" method="POST">
                                    <a href="{{ url('/admin/'.$urlSlug. '/' . $item->id . '/edit') }}" class="action-icon" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                                    <a href="{{ url('/admin/'.$urlSlug. '/' . $item->id) }}" class="action-icon" title="Show"><i class="mdi mdi-eye-outline"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="delete" class="action-icon" onclick="return confirm('Are you sure, You want to delete this?')" style="border:0; background: none;"><i class="mdi mdi-delete"></i></button>
                                </form> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#products-datatable").DataTable({
            'language': {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                }
            },
            'drawCallback': function() {
                jQuery(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            },
            "searching": true,
            "responsive": false,
            "autoWidth": false,
            'dom'    : 'Bfrtip',
            'buttons': [
                {
                    'extend'    : 'csvHtml5', 
                    'text': 'Export',
                    'title'     : 'Export - {{ $title }}',
                    'exportOptions': {
                        columns: [ 1, 2, 3 ]
                    }
                }
            ]
        });
        jQuery(document).on("click",".change_Status.activate_it",function(){
            var curId = jQuery(this).attr("data-id");
            ajaxStatusChange(jQuery(this), curId, 'Active',);
        })
        jQuery(document).on("click",".change_Status.deactivate_it",function(){
            var curId = jQuery(this).attr("data-id");
            ajaxStatusChange(jQuery(this), curId, 'Inactive');
        })
    })
    function ajaxStatusChange(element, curId, status){
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('admin/'.$urlSlug.'/change_Status') }}",
            method: 'post',
            data: {
                id: curId,
                status: status
            },
            success: function(result){
                if(result.success){
                    if(status == "Active"){
                        element.text("Inactive");
                        element.removeClass("activate_it").addClass("deactivate_it");
                        element.parent().parent().find("button").removeClass("btn-danger").addClass("btn-success").html('Active <i class="mdi mdi-chevron-down"></i>');
                    }else if(status == "Inactive"){
                        element.text("Active");
                        element.removeClass("deactivate_it").addClass("activate_it");
                        element.parent().parent().find("button").removeClass("btn-success").addClass("btn-danger").html('Inactive <i class="mdi mdi-chevron-down"></i>');
                    }
                    Swal.fire({icon:"success",title:"Great!",text:result.message});
                }else{
                    Swal.fire({icon:"error",title:"Oops...",text:result.message});
                }
            }
        });
    }
</script>
@endsection