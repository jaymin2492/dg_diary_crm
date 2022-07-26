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
                    <li class="breadcrumb-item"><a href="{{ URL('admin/'.$urlSlug) }}">{{ $title }}</a></li>
                    <li class="breadcrumb-item active">Add {{ $title }}</li>
                </ol>
            </div>
            <h4 class="page-title"><a href="{{ URL('admin/schools/'.$sid.'/edit') }}" style="text-decoration: underline;">{{ $school->title }}</a> - Add {{ $title }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-12">
    @include ('messages')
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ $title }}</h4>
                <p class="text-muted font-13">Add {{ $title }}</p>
                <!--begin::Form-->
                <form method="POST" action="{{ url('admin/'.$urlSlug.'/') }}" id="create_form" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf
                    @include ('admin.'.$urlSlug.'.form', ['formMode' => 'create'])
                </form>
                <!--end::Form-->
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
@endsection