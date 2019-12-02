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

                <div class="col-7">

                    <div class="navbar-search w-100" id="single-url">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">URL:</span>
                            </div>
                            <input type="text" name="url" value="{{ old('url') }}" class="form-control border" placeholder="https://shop.com/product/73625" aria-label="Search" aria-describedby="basic-addon2">
                        </div>
                    </div>

                    <div class="navbar-search w-100" id="batch-urls" style="display: none">
                        <div class="input-group">
                            <textarea name="urls"
                                      class="form-control border w-100"
                                      rows="5"
                                      placeholder="https://shop.com/product/73625
https://shop.com/product/564658
https://shop.com/product/957778">{{ old('urls') }}</textarea>
                        </div>
                    </div>

                </div>

                <div class="col-3 w-100">

                    <select class="form-control" name="category">
                        <option value="" selected disabled>Select Category</option>
                        @foreach($categories as $category )
                        <option value="{{ $category->category_id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>

                </div>

                <div class="col-2 w-100">

                    <button type="submit" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                        <i class="fas fa-plus"></i> import
                    </button>
                    <button type="button" class="btn btn-link" id="toggle-batch">batch</button>

                    <input type="hidden" name="batch" value="0">
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
                        <input name="search" type="text" value="{{ request()->get('search') }}" class="form-control border mr-3" placeholder="Search">
                        
                        <div class="mr-3 w-50">
                            <select name="site" class="form-control border" value="{{ request()->get('site') }}">
                                <option value="" selected disabled>Select Site</option>
                                @foreach($sites as $site )
                                <option value="{{ $site->id }}">
                                    {{ $site->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary border" type="submit">
                            Go!
                        </button>
                    </form>
                </div>
            </div>

            <table class="table table-bordered">
                <tr class="card-header">
                    <th class="text-center">ID</th>
                    <th>Title</th>
                    <th class="text-center">Store</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Synced at</th>
                    <th class="text-center">Sync</th>
                    <th class="text-center">Show</th>
                </tr>

                @foreach($products as $product)

                    <tr class="align-td">
                        <td class="text-center">
                            {{ $product->id}}
                        </td>

                        <td>
                            {{ $product->title }}
                        </td>

                        <td class="text-center">
                            {{ $product->site()->withTrashed()->first()->name }}
                        </td>

                        <td class="text-center">
                            {{ number_format($product->variants->average('price'), 2) }} din
                        </td>

                        <td class="text-center">
                            {{ $product->status }}
                        </td>

                        <td class="text-center cursor-help" title="{{ $product->synced_at }}">
                            {{ $product->synced_at->diffForHumans() }}
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

                         <td class="text-center">
                         <div class="text-center cursor-help">
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-success d-none d-sm-inline-block btn-sm">show</a>
                            </div>
                        </td>

                    </tr>

                @endforeach

            </table>
        </div>

        <div class="card-footer d-flex justify-content-center">
            <div class="mt-3">
               
                {{ $products->appends(['site' => request()->get('site' ), 'search' => request()->get('search')])->links() }}
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

        $("select[name=site]").select2({
            placeholder: "Select Site",
        });

        // toggle batch/single feature
        $('#toggle-batch').click(function() {
            $('#single-url,#batch-urls').toggle();

            // by this we can know if batch was used
            var isBatch = $('input[name=batch]').val() == 1 ? 0 : 1;

            $(this).text(isBatch ? 'single' : 'batch');

            $('input[name=batch]').val(isBatch);
        });

        // show batch if it's populated on init, this means
        // that the validation has failed when batch was selected
        if ($('textarea[name=urls]').val().length > 0) {
            $('#toggle-batch').click();
        }
    </script>
@endsection
