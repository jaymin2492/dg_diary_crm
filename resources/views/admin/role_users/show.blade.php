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
                    <li class="breadcrumb-item active">View Item - {{ $item->title }}</li>
                </ol>
            </div>
            <h4 class="page-title">View Item - {{ $item->title }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-12">
        @include ('messages')
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Item Information</h4>                
                <p class="mb-2"><span class="fw-semibold me-2">Title:</span> {{ $item->title }}</p>
                <p class="mb-2"><span class="fw-semibold me-2">Description:</span> {{ $item->description }}</p>
                <p class="mb-2"><span class="fw-semibold me-2">Status:</span> {{ $item->status }}</p>
                <!-- <p class="mb-2"><span class="fw-semibold me-2">Created At:</span> {{ $item->created_at }}</p>
                <p class="mb-0"><span class="fw-semibold me-2">Last Updated At:</span> {{ $item->updated_at }}</p> -->
            </div>
        </div>
    </div> <!-- end col -->
</div>
@endsection