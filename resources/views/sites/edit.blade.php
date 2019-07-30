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

            <!-- SITE -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        General
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" name="sites[name]" class="form-control" value="{{$site->name}}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">URL</label>
                            <input type="text" name="sites[url]" class="form-control" value="{{$site->url}}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="text" name="sites[email]" class="form-control" value="{{$site->email}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Price Modification</label>
                            <input type="number" name="sites[price_modification]" class="form-control" value="{{$site->price_modification}}">
                        </div>
                    </div>
                </div>

                @include('sites.test_rules')
            </div>

            <div class="col-lg-6 members-position">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        Scrape rules
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input type="text" name="sync_Rules[title]" class="form-control" value="{{ $site->SyncRules->title}}">
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <input type="text" name="sync_Rules[description]" class="form-control" value="{{ $site->SyncRules->description}}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Specification</label>
                            <input type="text" name="sync_Rules[specifications]" class="form-control" value="{{ $site->SyncRules->specifications}}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Price</label>
                            <input type="text" name="sync_Rules[price]" class="form-control" value="{{ $site->SyncRules->price }}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Price decimals</label>
                            <input type="text" name="sync_Rules[price_decimals]" class="form-control" value="{{ $site->SyncRules->price_decimals }}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">In stock</label>
                            <input type="text" name="sync_Rules[in_stock]" class="form-control" value="{{  $site->SyncRules->in_stock}}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">In stock value</label>
                            <input type="text" name="sync_Rules[in_stock_value]" class="form-control" value="{{ $site->SyncRules->in_stock_value}}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Images</label>
                            <input type="text" name="sync_Rules[images]" class="form-control" value="{{ $site->SyncRules->images }}">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Variants</label>
                            <input type="text" name="sync_Rules[variants]" class="form-control" value="{{ $site->SyncRules->variants }}">
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
