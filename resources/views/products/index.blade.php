@extends('layouts.main')

@section('title','Product Sync - Products')

@section('content')

    <div class="d-sm-flex align-items-center mb-4">
        <h1 class="h4 mb-0 text-gray-800">Products</h1>
    </div>

     @include('flash::message')

    @include('partials.errors')

    <div class="card">
    <form action="{{ route('product.import') }}" method="POST" class="form-horizontal">
       {!! csrf_field() !!}

        <div class="card-body shadow">

            <div class="row">

                <div class="col-6">


                    <div class="d-none d-sm-inline-block form-inline navbar-search w-100">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">URL:</span>
                            </div>
                            <input type="text" name='url' class="form-control border" placeholder="https://shop.com/product/73625" aria-label="Search" aria-describedby="basic-addon2">
                        </div>
                    </div>

                </div>

                <div class="col-4 w-100">

                    <select class="form-control" name="category">
                        <option value="CA" data-select2-id="85">California</option>
                        <option value="NV" data-select2-id="86">Nevada</option>
                        <option value="OR" data-select2-id="87">Oregon</option>
                        <option value="WA" data-select2-id="88">Washington</option>
                    </select>

                </div>

                <div class="col-2 w-100">

                    <button type="submit" class="d-none d-sm-inline-block btn btn-primary shadow-sm float-right">
                        <i class="fas fa-plus"></i> import
                    </button>

                </div>


            </div>

        </div>

     </form>

    </div>


    <div class="card shadow mt-5">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <form action="" method="get" class="d-flex d-inline-block mb-4 w-100">
                        <div class="input-group">
                            <input name="search" type="text" value="{{ request()->get('search') }}" class="form-control border" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn btn-light border text-muted" type="submit">
                                    Go!
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-bordered">
                <tr class="card-header">
                    <th class="text-center">ID</th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Store</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Synced at</th>
                    <th class="text-center">Sync</th>
                </tr>

                @foreach($products as $product)

                    <tr class="align-td">
                        <td class="text-center">
                            {{ $product->id}}
                        </td>

                        <td class="text-center">
                            {{ $product->title }}
                        </td>

                        <td class="text-center">
                            {{ $product->site()->withTrashed()->first()->name }}
                        </td>

                        <td class="text-center">
                            {{ $product->category }}
                        </td>

                        <td class="text-center">
                            {{ number_format($product->variants->average('price'), 2) }} din
                        </td>

                        <td class="text-center">
                            {{ $product->status }}
                        </td>

                        <td class="text-center">
                            {{ $product->synced_at }}
                        </td>

                        <td class="text-center">
                            <div class="users-list-actions">

                            {!! Form::open(['route'=>['product.sync', $product->id],'method'=>'PUT','class'=>'pull-right delete']) !!}
                            <button type="submit" data-toggle="modal" data-target="#confirmButton" class="btn btn-primary d-none d-sm-inline-block btn-sm">
                                <i class="fas fa-sync-alt"></i> Sync
                            </button>
                            {!! Form::close() !!}


                            </div>
                        </td>
                    </tr>

                @endforeach

            </table>
        </div>

        <div class="card-footer d-flex justify-content-center">
            <div class="mt-3">
                {!! $products->render() !!}
            </div>
        </div>
    </div>

@endsection

@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

    <script>
        $("select[name=category]").select2({
            placeholder: "Select Category",
        });
    </script>
@endsection
