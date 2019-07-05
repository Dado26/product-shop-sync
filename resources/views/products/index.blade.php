@extends('layouts.main')

@section('content')

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800">Products</h1>
</div>

<div class="card">
    <div class="card-body d-flex justify-content-between shadow">

        <form class="d-none d-sm-inline-block form-inline navbar-search col-8">
            <div class="input-group">

                <div class="input-group-append">
                    <button class="btn btn-light rounded-left text-muted border" type="button">
                        url
                    </button>
                </div>
                <input type="text" class="form-control border" placeholder="https://webartisan.in.rs" aria-label="Search" aria-describedby="basic-addon2">
            </div>
        </form>

        <div class="col-4 d-flex justify-content-between">

            {{-- select2 dropdown --}}
                <div class="w-50">
                    <select class="form-control" name="category" id="id_label_multiple" multiple="" data-select2-id="id_label_multiple" tabindex="-1" aria-hidden="true">
                        <optgroup label="Alaskan/Hawaiian Time Zone" data-select2-id="81">
                            <option value="CA" data-select2-id="85">California</option>
                            <option value="NV" data-select2-id="86">Nevada</option>
                            <option value="OR" data-select2-id="87">Oregon</option>
                            <option value="WA" data-select2-id="88">Washington</option>
                        </optgroup>
                    </select>
                </div>
            {{-- select2 dropdown end --}}

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

        <form action="" method="get" class="d-flex d-inline-block mb-4 w-50">
            <div class="input-group">
                <input name="search" type="text" value="{{ request()->get('search') }}" class="form-control border" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-light border text-muted" type="submit">
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
                        {{ $product->title }}
                    </td>

                    <td class="text-center">
                        {{ $product->site()->withTrashed()->first()->name}}
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

@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

    <script>
        $("select[name=category]").select2({
            placeholder: "Select Category",
        });
    </script>
@endsection
