@extends('layouts.main')

@section('content')

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800">Products</h1>
</div>

<div class="card">
    <div class="card-body d-flex justify-content-between">

        <form class="d-none d-sm-inline-block form-inline navbar-search col-8">
            <div class="input-group input-group-prepend">
                <button class="btn btn-light border-light" type="button">url</button>
                <input type="text" class="form-control border-light" placeholder="https://sample.rs/product/123" aria-label="Search" aria-describedby="basic-addon2">
            </div>
        </form>

        <div class="col-4 d-flex justify-content-between">

            <div class="dropdown d-inline-block">
                <button class="btn border-light bg-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </button>
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>

            <div class="d-inline-block">
                <a href="{{ route('sites.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                    <i class="fas fa-plus"></i> import
                </a>
            </div>

        </div>

    </div>
</div>

@include('flash::message')

<div class="card shadow mt-5">
    <div class="card-body">
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
                        {{ $product->site->name}}
                    </td>

                    <td class="text-center">
                        {{ $product->site->url}}
                    </td>

                    <td class="text-center">
                        {{ $product->category}}
                    </td>

                    <td class="text-center">
                        {{ number_format($product->variants->average('price'), 2) }} din.
                    </td>

                     <td class="text-center">
                        {{ $product->status}}
                    </td>

                     <td class="text-center">
                        <p> </p>
                    </td>

                    <td class="text-center">
                        <div class="users-list-actions">
                            <button type="button" data-toggle="modal" data-target="#confirmButton" class="btn btn-primary d-none d-sm-inline-block btn-sm rounded-circle">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button type="button" data-toggle="modal" data-target="#confirmButton" class="btn btn-primary d-none d-sm-inline-block btn-sm">
                                <i class="fas fa-sync-alt"></i> Sync
                            </button>
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
