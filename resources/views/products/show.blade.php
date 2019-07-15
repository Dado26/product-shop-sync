@extends('layouts.main')

@section('content')

 <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800">Import product</h1>
</div>

<div class="row">

    <div class="col-lg-6 members-position">

        <div class="card shadow mb-4">

            <div class="card-header">
                Products
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label class="control-label">Site Name</label>
                    <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Title</label>
                    <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Description</label>
                    <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">URL</label>
          <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Category</label>
          <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Specification</label>
          <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Status</label>
          <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Synced at</label>
          <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Created at</label>
          <div class="form-control"></div>
                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-6 members-position">

        <div class="card shadow mb-4">

            <div class="card-header">
                Variants
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label class="control-label">Name</label>
                    <div class="form-control"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Price</label>
                    <div class="form-control"></div>
                </div>

            </div>

        </div>

        <div class="card shadow mb-4">

            <div class="card-header">
                Product images
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <img class="img-fluid" src="" alt="img1">
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<div class="d-flex justify-content-between mb-5">
    <div class="back">
        <a href="{{route('sites.index')}}" class="btn btn-primary d-none d-sm-inline-block btn-lg">
            <i class="fas fa-angle-left"></i> Back
        </a>
    </div>
</div>

@endsection
