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
                        <!--  <div class="mt-2 mt-sm-0">
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
                                <th style="width: 20px;">
                                    #
                                </th>
                                <th>Sales Rep</th>
                                <th>School name</th>
                                <th>Population</th>
                                <th>Sales Stage</th>
                                <th>Closure Month</th>
                                <th>Follow-up date</th>
                                <th>Manager Status</th>
                                <th>Details</th>
                                <th style="width: 85px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                @endif
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        
        jQuery("#products-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/'.$urlSlug.'/ajax_list') }}",
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
            "autoWidth": true,
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
        jQuery("#products-datatable").on('xhr.dt', function(e, settings, json, xhr){
            setTimeout(function(){
                jQuery(".folow_up_date").flatpickr();
            },1000);
        });
        jQuery(document).on("click", ".editable_field", function() {
            jQuery(this).next().show()
            jQuery(this).hide();
        })
        jQuery(document).on("change", ".editable_form select, .editable_form input", function() {
            var curId = jQuery(this).attr("data-id");
            if (jQuery(this).val() == "") {
                return false;
            }
            var key = jQuery(this).attr("name");
            var value = jQuery(this).val();
            ajaxUpdate(jQuery(this), key, curId, value);
        })
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

    function ajaxUpdate(element, key, curId, value) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('admin/'.$urlSlug.'/field_update') }}",
            method: 'post',
            data: {
                id: curId,
                key: key,
                value: value
            },
            success: function(result) {
                if (result.success) {
                    element.parent().hide();
                    if (result.new_value) {
                        element.parent().prev().text(result.new_value);
                    }
                    element.parent().prev().show();
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