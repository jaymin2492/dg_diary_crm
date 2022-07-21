@extends('layouts.app_loggedin')

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ URL('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ URL('admin/'.$urlSlug) }}">{{ $title }}</a></li>
                    <li class="breadcrumb-item active">Edit Item - {{ $item->user_name }}</li>
                </ol>
            </div>
            <h4 class="page-title">Edit Item - {{ $item->user_name }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-12">
        @include ('messages')
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Edit Item - {{ $item->user_name }}</h4>
                <p class="text-muted font-13">Edit Item - {{ $item->user_name }}</p>
                <!--begin::Form-->
                <form method="POST" action="{{ url('admin/'.$urlSlug.'/' . $item->id) }}" id="edit_form" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    @include ('admin.'.$urlSlug.'.form', ['formMode' => 'update'])
                </form>
                <!--end::Form-->
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
@endsection