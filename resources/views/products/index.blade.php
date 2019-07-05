@extends('layouts.main')

@section('content')

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800">Products</h1>
</div>

<div class="card">
    <div class="card-body d-flex justify-content-between">

        <form class="d-none d-sm-inline-block form-inline navbar-search col-8">
            <div class="input-group">

                <div class="input-group-append">
                    <button class="btn btn-light border-light rounded-left text-muted" type="button">
                        url
                    </button>
                </div>
                <input type="text" class="form-control border-light" placeholder="https://webartisan.in.rs" aria-label="Search" aria-describedby="basic-addon2">
            </div>
        </form>

        <div class="col-4 d-flex justify-content-between">

            <div class="dropdown d-inline-block w-50 ml-4">
                <button class="btn border-light bg-light dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Category
                </button>
                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                    <a class="dropdown-item" href="#">Lap top</a>
                    <a class="dropdown-item" href="#">Desktop</a>
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

        <form class="d-flex d-inline-block mb-4 w-50">
            <div class="input-group">
                <input type="text" class="form-control border-light" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-light border-light text-muted" type="button">
                        Go!
                    </button>
                </div>
            </div>
        </form>

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
