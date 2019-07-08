@extends('layouts.main')

@section('title','Product Sync - Jobs')

@section('content')
    <div class="d-sm-flex">
        <h1 class="h4 text-gray-800">Sync jobs</h1>
    </div>

    <div class="row my-3">
        <div class="col-12">
            <iframe src="{{ url('horizon/dashboard') }}" id="horizon"></iframe>
        </div>
    </div>
@endsection
