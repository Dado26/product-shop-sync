@extends('layouts.main')

@section('content')
    <!-- Main content -->
    {!! Form::open(['route' => ['product.store', $site->id], 'method' => 'POST']) !!}

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add rules</h1>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            @include('partials.errors')

            <!-- SITE -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    General
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">Next Page Rule</label>
                        <input type="text" name="next_page" class="form-control" value="{{ ($site->productLinks) ? $site->productLinks->next_page  : ''}}">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Link Rule</label>
                        <input type="text" name="product_link" class="form-control" value="{{ ($site->productLinks) ?  $site->productLinks->product_link  : ''}}">
                    </div>
                </div>


                <div class="card-footer d-flex justify-content-between">
                    <div class="back">
                        <a href="{{route('sites.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <i class="fas fa-angle-left"></i> Back
                        </a>
                    </div>

                    <div class="save-user">
                        <button type="submit" class="btn btn-success d-none d-sm-inline-block">
                            <i class="far fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}


        <div class="col-sm-12 col-md-6 col-lg-6">

            {!! Form::open(['route' => ['link', $site->id], 'method' => 'GET']) !!}
            <div class="card shadow mb-4">
                <div class="card-header">
                    Products links
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">Link</label>
                        <input type="text" name="link" class="form-control" value="{{ request('link') }}">
                    </div>

                    @if(!empty($productLinks))
                        <textarea class="form-control mt-3" style="width:100%; height:500px">{!! $productLinks->implode("\n") !!}</textarea>
                    @endif

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success pull-right">Fetch</button>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

    <!-- /.content -->
@endsection
