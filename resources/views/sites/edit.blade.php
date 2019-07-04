@extends('layouts.main')

@section('content')

<!-- Main content -->
<form action="{{ route('sites.update', $site->id) }}" method="POST" class="form-horizontal">
    {!! csrf_field() !!}
    <input type="hidden" name="_method" value="PUT">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Site</h1>
    </div>

    <div class="row">

        <div class="col-md-6 members-position">

            @include('partials.errors')

            <div class="card shadow mb-4">

                <div class="card-header">
                    General
                </div>

                <div class="card-body">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" name="sites[name]" class="form-control" value="{{$site->name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">URL</label>
                        <div class="col-sm-12">
                            <input type="text" name="sites[url]" class="form-control" value="{{$site->url}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" name="sites[email]" class="form-control" value="{{$site->email}}">
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-6 members-position">

            <div class="card shadow mb-4">

                <div class="card-header">
                    Scrape rules
                </div>

                <div class="card-body">


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" name="sync_Rules[title]" class="form-control" value="{{ $site->SyncRules->title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-12">
                            <textarea rows="5" cols="80" name="sync_Rules[description]"class="form-control">{{ $site->SyncRules->description}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-12">
                            <input type="text" name="sync_Rules[price]" class="form-control" value="{{ $site->SyncRules->price }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">In Stock</label>
                        <div class="col-sm-12">
                            <input type="text" name="sync_Rules[in_stock]" class="form-control" value="{{  $site->SyncRules->in_stock}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">In_stock_value</label>
                        <div class="col-sm-12">
                            <input type="text" name="sync_Rules[in_stock_value]" class="form-control" value="{{ $site->SyncRules->in_stock_value}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Images</label>
                        <div class="col-sm-12">
                            <input type="text" name="sync_Rules[images]" class="form-control" value="{{ $site->SyncRules->images }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Variants</label>
                        <div class="col-sm-12">
                            <input type="text" name="sync_Rules[variants]" class="form-control" value="{{ $site->SyncRules->variants }}">
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="d-flex justify-content-between mb-5">
        <div class="back">
            <a href="{{route('sites.index') }}" class="btn btn-primary d-none d-sm-inline-block btn-lg">
                <i class="fas fa-angle-left"></i> Back
            </a>
        </div>

        <div class="save-user">
            <button type="submit" class="btn btn-success d-none d-sm-inline-block btn-lg">
                <i class="far fa-save"></i> Save
            </button>
        </div>
    </div>

</form>

<!-- /.content -->
@endsection
