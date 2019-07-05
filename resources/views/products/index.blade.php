@extends('layouts.main')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Sites</h1>
    <a href="{{ route('sites.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
        <i class="fas fa-plus"></i> Create
    </a>
</div>

@include('flash::message')

<div class="card shadow">
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Title</th>
                <th class="text-center">Store</th>
                <th class="text-center">Category</th>
                <th class="text-center">Price</th>
                <th class="text-center">Status</th>
                <th class="text-center">Synced At</th>
                <th class="text-center">Synce</th>
            </tr>

            @foreach($products as $product)

                <tr>
                    <td class="text-center">
                        <p> {{ $product->id}} </p>
                    </td>

                    <td class="text-center">
                        <p> {{ $product->site->name}} </p>
                    </td>

                    <td class="text-center">
                        <p> {{ $product->site->url}} </p>
                    </td>

                    <td class="text-center">
                        <p> {{ $product->category}} </p>
                    </td>

                    <td class="text-center">
                        <p> {{ number_format($product->variants->average('price'), 2) }} din</p>
                    </td>
                     <td class="text-center">
                        <p> {{ $product->status}} </p>
                    </td>

                     <td class="text-center">
                        <p> </p>
                    </td>

                    <td class="text-center">
                        <div class="users-list-actions">                         
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
