@extends('layouts.main')


@section('content')

<!-- Main content -->
{!! Form::open(['route'=>'sites.store', 'method'=>'POST', 'class'=>'validate']) !!}

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Site</h1>
</div>

<div class="row">

    <div class="col-lg-6 members-position">

        @include('partials.errors')

        <div class="card shadow mb-4">

            <div class="card-header">
                General
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label>Name</label>
                    {!! Form::input('text', 'sites[name]', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Url</label>
                    {!! Form::input('text', 'sites[url]', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Email</label>
                    {!! Form::input('text', 'sites[email]', null, ['class'=>'form-control']) !!}
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
                    <label>Title</label>
                    {!! Form::input('text', 'sync_Rules[title]', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Description</label>
                    {!! Form::input('text', 'sync_Rules[description]', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Price</label>
                    {!! Form::input('text', 'sync_Rules[price]', null, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>In_stock</label>
                    {!! Form::input('text', 'sync_Rules[in_stock]', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>In_stock_value</label>
                    {!! Form::input('text', 'sync_Rules[in_stock_value]', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Images</label>
                    {!! Form::input('text', 'sync_Rules[images]', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Variants</label>
                    {!! Form::input('text', 'sync_Rules[variants]', null, ['class'=>'form-control']) !!}
                </div>
            </div>

        </div>

    </div>

</div>

    <div class="d-flex justify-content-between mb-5">
        <div class="back">
            <a href="{{route('sites.index')}}" class="btn btn-primary d-none d-sm-inline-block btn-lg">
                <i class="fas fa-angle-left"></i> Back
            </a>
        </div>

        <div class="save-user">
            <button class="btn btn-success d-none d-sm-inline-block btn-lg">
                <i class="fas fa-save"></i> Save
            </button>
        </div>
    </div>

{!! Form::close() !!}

<!-- /.content -->
@endsection
