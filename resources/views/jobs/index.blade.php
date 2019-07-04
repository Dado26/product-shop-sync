@extends('layouts.main')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-5">
    <h1 class="h4 text-gray-800">Sync jobs</h1>
</div>

<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card border-success alert-success text-dark shadow">
        <div class="card-body text-center">
            Queued jobs
            <div class="h2 font-weight-bold mt-2">111</div>
        </div>
        </div>
    </div>
    <div class="col-lg-3 mb-4">
        <div class="card border-danger alert-danger text-dark shadow">
        <div class="card-body text-center">
            Failed jobs
            <div class="h2 font-weight-bold mt-2">0</div>
        </div>
        </div>
    </div>
</div>
<div class="row justify-content-center mt-5 mb-5">
    <iframe src="{{URL::to('/')}}/your file path here" width="100%" height="400"></iframe>
</div>

@endsection
