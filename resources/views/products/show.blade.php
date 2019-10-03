@extends('layouts.main')

@section('content')

 <div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800">Import product</h1>
</div>

<div class="row">

    <div class="col-lg-6 members-position">

        <div class="card shadow mb-4">

            <div class="card-header">Site</div>

            <div class="card-body">
                <div class="form-group">
                    <label class="control-label">Name</label>
                    <span class="form-control">
                        <a href="{{ $product->site->url }}" target="_blank">{{ $product->site->name }}</a>
                    </span>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">

            <div class="card-header">Products</div>

            <div class="card-body">

                <div class="form-group">
                    <label class="control-label">Title</label>
                    <div class="form-control">{{ $product->title }}</div>
                </div>

                <div class="form-group">
                    <label class="control-label">Description</label>
                    <div class="form-control multiline">{!! $product->description !!}</div>
                </div>

                <div class="form-group">
                    <label class="control-label">URL</label>
                    <a href="{{ $product->url }}" target="_blank" class="btn btn-link text-left custom-border d-block">{{ $product->url }}</a>
                </div>

                <div class="form-group">
                    <label class="control-label">Specifications</label>
                    <div class="form-control">{!! $product->specifications !!}</div>
                </div>

                <div class="form-group">
                    <label class="control-label">Status</label>
                    <div class="form-control">{{ $product->status }}</div>
                </div>

                <div class="form-group">
                    <label class="control-label">Synced at</label>
                    <div class="form-control">{{ $product->synced_at }}</div>
                </div>

                <div class="form-group">
                    <label class="control-label">Created at</label>
                    <div class="form-control">{{ $product->created_at }}</div>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    @foreach($variants as $variant)
                        <tr class="align-td">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $variant->name }}</td>
                            <td>{{ number_format($variant->price, 2) }} din</td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>

        <div class="card shadow mb-4">

            <div class="card-header">
                Product images
            </div>

            <div class="card-body">
                <div class="row">
                @foreach($images as $image)
                    <div class="col-6">
                        <img class="img-fluid" src="{{  $image->url }}" alt="img1">
                    </div>
                @endforeach
                </div>
            </div>

        </div>

    </div>

</div>

<div class="d-flex justify-content-between mb-5">
    <div class="back">
        <a href="{{route('products.index')}}" class="btn btn-primary d-none d-sm-inline-block btn-lg">
            <i class="fas fa-angle-left"></i> Back
        </a>
    </div>
</div>

@endsection
