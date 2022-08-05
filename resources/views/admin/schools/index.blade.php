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
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                    </div>
                                </th>
                                <th class="no-sort">Sales Rep</th>
                                <th>School name</th>
                                <th>Population</th>
                                <th class="no-sort">Sales Stage</th>
                                <th>Closure Month</th>
                                <th>Follow-up date</th>
                                <th class="no-sort">Manager Status</th>
                                <th class="no-sort">Details</th>
                                <th class="no-sort" style="width: 85px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); ?>
                            @foreach ($items as $item)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td>
                                    @if(isset($fieldItems['salesReps'][$item->sales_rep_id]))
                                    {{ $fieldItems['salesReps'][$item->sales_rep_id] }}
                                    @else
                                    {{ $item->sales_rep_id }}
                                    @endif
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->population }}</td>
                                <td>
                                    <div class="editable_field">
                                        @if(isset($fieldItems['statuses'][$item->status_id]))
                                        {{ $fieldItems['statuses'][$item->status_id] }}
                                        @else
                                        {{ $item->status_id }}
                                        @endif
                                    </div>
                                    <div class="editable_form">
                                        <select class="form-select" name="status_id" data-id="{{ $item->id }}" required>
                                            <option value="">Please Select</option>
                                            @foreach($fieldItems['statuses'] as $key => $value)
                                            <option value="{{ $key }}" @if($item->status_id==$key ) selected="selected" @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="editable_field">
                                        {{ $item->closure_month }}
                                    </div>
                                    <div class="editable_form">
                                        <select class="form-select" name="closure_month" data-id="{{ $item->id }}" required>
                                            <option value="">Please Select</option>
                                            @foreach($months as $value)
                                            <option value="{{ $value }}" @if($item->closure_month==$value ) selected="selected" @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="editable_field">
                                        {{ $item->folow_up_date }}
                                    </div>
                                    <div class="editable_form">
                                        <input type="text" name="folow_up_date" class="form-control folow_up_date" data-id="{{ $item->id }}" placeholder="Follow-up Date*" value="{{ $item->folow_up_date }}" required>
                                    </div>
                                </td>
                                <td>
                                    <div class="editable_field">
                                        @if(isset($fieldItems['statuses'][$item->manager_status_id]))
                                        {{ $fieldItems['statuses'][$item->manager_status_id] }}
                                        @else
                                        {{ $item->manager_status_id }}
                                        @endif
                                    </div>
                                    <div class="editable_form">
                                        <select class="form-select" name="manager_status_id" data-id="{{ $item->id }}" required>
                                            <option value="">Please Select</option>
                                            @foreach($fieldItems['statuses'] as $key => $value)
                                            <option value="{{ $key }}" @if($item->manager_status_id==$key ) selected="selected" @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('/admin/school_contacts/'.$item->id) }}" class="btn btn-sm btn-secondary"><i class="bx bxs-plus-circle"></i> <span>Contacts</span></a>
                                    <a href="{{ url('/admin/school_notes/'.$item->id) }}" class="btn btn-sm btn-info"><i class="bx bxs-plus-circle"></i> <span>Notes</span></a>
                                </td>
                                <td>
                                    <a href="{{ url('/admin/'.$urlSlug. '/' . $item->id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit"><i class="mdi mdi-square-edit-outline"></i> Edit</a>
                                    <div class="btn-group" style="margin-left: 10px;">
                                        <button type="button" class="btn btn-sm @if ($item->status == 'Active') btn-success @else btn-danger @endif dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">
                                            @if ($item->status == 'Active') Active @else Inactive @endif
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if ($item->status == 'Active')
                                            <a class="dropdown-item change_Status deactivate_it" href="javascript: void(0);" data-id="{{ $item->id }}">Inactive</a>
                                            @else
                                            <a class="dropdown-item change_Status activate_it" href="javascript: void(0);" data-id="{{ $item->id }}">Active</a>
                                            @endif
                                        </div>
                                    </div>
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
    jQuery(document).ready(function() {
        jQuery(".folow_up_date").flatpickr();
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
        jQuery(document).on("click", ".editable_field", function() {
            jQuery(this).next().show()
            jQuery(this).hide();
        })
        jQuery(".editable_form select, .editable_form input").on("change", function() {
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