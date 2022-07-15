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
                        <div class="mt-2 mt-sm-0">
                            <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog"></i></button>
                            <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                            <button type="button" class="btn btn-light mb-2">Export</button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            <a href="{{ URL('admin/'.$urlSlug.'/create') }}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i> Add {{ $title }}</a>
                        </div>
                    </div><!-- end col-->
                </div>

                @if (empty($items->toArray()['data']))
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
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th style="width: 85px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                    </div>
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <div class="switchery-demo">
                                        <input type="checkbox" @if ($item->status == 'Active') checked @endif data-plugin="switchery" data-color="#ff7aa3"/>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ url('/admin/'.$urlSlug. '/' . $item->id) }}" method="POST">
                                        <a href="{{ url('/admin/'.$urlSlug. '/' . $item->id . '/edit') }}" class="action-icon" title="Edit"><i class="mdi mdi-square-edit-outline"></i></a>
                                        <a href="{{ url('/admin/'.$urlSlug. '/' . $item->id ) }}" class="action-icon" title="Show"><i class="mdi mdi-eye-outline"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="delete" class="action-icon" onclick="return confirm('Are you sure, You want to delete this?')" style="border:0; background: none;"><i class="mdi mdi-delete"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @include ('pagination')
                @endif
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>
@endsection