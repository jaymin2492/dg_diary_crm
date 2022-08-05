@extends('layouts.app_loggedin')

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ URL('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ URL('admin/schools/'.$sid.'/edit') }}">{{ $school->title }}</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
            <h4 class="page-title"> <a href="{{ URL('admin/schools/'.$sid.'/edit') }}" style="text-decoration: underline;">{{ $school->title }}</a> - {{ $title }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        @include ('messages')
        <div class="card" style="background: none;">
            <div class="card-body" style="background: none;">
                <div class="row mb-2">

                    <div class="col-sm-8">
                        <!--  <div class="mt-2 mt-sm-0">
                            <button type="button" class="btn btn-info mb-2">Export</button>
                        </div> -->
                    </div>
                    <div class="col-sm-4">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#standard-modal"><i class="mdi mdi-plus-circle me-1"></i>Add {{ $title }}</a>
                        </div>
                    </div><!-- end col-->
                </div>

                @if (empty($items->toArray()))
                <p style="margin:150px 0;" class="text-center">No Items Found</p>
                @else
                @foreach ($items as $item)
                <div class="col-lg-12">
                    <!-- Portlet card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="card-widgets">
                                <a data-bs-toggle="collapse" href="#cardCollpase_{{ $item->id }}" role="button" aria-expanded="true" aria-controls="cardCollpase_{{ $item->id }}" class=""><i class="mdi mdi-minus"></i></a>
                            </div>
                            <h5 class="card-title mb-0">{{ $item->note_by_at }}</h5>

                            <div id="cardCollpase_{{ $item->id }}" class="collapse show" style="">
                                <div class="pt-3">
                                {{ $item->notes }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-->
                </div>
                @endforeach



                @endif
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>
<!-- Standard modal content -->
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Add {{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ url('admin/'.$urlSlug.'/') }}" id="create_form" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf
                    @include ('admin.'.$urlSlug.'.form', ['formMode' => 'create'])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="create_form">Create {{ $title }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    jQuery(document).ready(function() {
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
            'dom': 'Bfrtip',
            'buttons': [{
                'extend': 'csvHtml5',
                'text': 'Export',
                'title': 'Export - {{ $title }}',
                'exportOptions': {
                    columns: [1, 2, 3]
                }
            }]
        });
        jQuery(document).on("click", ".change_Status.activate_it", function() {
            var curId = jQuery(this).attr("data-id");
            ajaxStatusChange(jQuery(this), curId, 'Active');
        })
        jQuery(document).on("click", ".change_Status.deactivate_it", function() {
            var curId = jQuery(this).attr("data-id");
            ajaxStatusChange(jQuery(this), curId, 'Inactive');
        })
    })

    function ajaxStatusChange(element, curId, status) {
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
            success: function(result) {
                if (result.success) {
                    if (status == "Active") {
                        element.text("Inactive");
                        element.removeClass("activate_it").addClass("deactivate_it");
                        element.parent().parent().find("button").removeClass("btn-danger").addClass("btn-success").html('Active <i class="mdi mdi-chevron-down"></i>');
                    } else if (status == "Inactive") {
                        element.text("Active");
                        element.removeClass("deactivate_it").addClass("activate_it");
                        element.parent().parent().find("button").removeClass("btn-success").addClass("btn-danger").html('Inactive <i class="mdi mdi-chevron-down"></i>');
                    }
                    Swal.fire({
                        icon: "success",
                        title: "Great!",
                        text: result.message
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: result.message
                    });
                }
            }
        });
    }
</script>
@endsection