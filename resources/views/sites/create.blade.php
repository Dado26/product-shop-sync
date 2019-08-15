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

        <!-- SITE -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    General
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        {!! Form::input('text', 'sites[name]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Url</label>
                        {!! Form::input('text', 'sites[url]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Email</label>
                        {!! Form::input('text', 'sites[email]', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label">Price Modification</label>
                        {!! Form::input('number', 'sites[price_modification]', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>

            @include('sites.test_rules')
        </div>

        <!-- RULES -->
        <div class="col-lg-6 members-position">
            <div class="card shadow mb-4">
                <div class="card-header">
                    Scrape rules
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">Title</label>
                        {!! Form::input('text', 'sync_Rules[title]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Description</label>
                        {!! Form::input('text', 'sync_Rules[description]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Specification</label>
                        {!! Form::input('text', 'sync_Rules[specifications]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Price</label>
                        {!! Form::input('text', 'sync_Rules[price]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Price decimals</label>
                        {!! Form::input('text', 'sync_Rules[price_decimals]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">In stock</label>
                        {!! Form::input('text', 'sync_Rules[in_stock]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">In stock value</label>
                        {!! Form::input('text', 'sync_Rules[in_stock_value]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Images</label>
                        {!! Form::input('text', 'sync_Rules[images]', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Variants</label>
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


 {{--  
    {{ Aire::open()->route('sites.store') }}
 <div class="d-sm-flex align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Site</h1>
</div>

<div class="flex flex-col md:flex-row">
<div class="row">
<div class="col-lg-6 members-position">
<div class="card shadow mb-4">
                <div class="card-header">
                    General
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                {{ Aire::input('sites[name]')->type('text')->Class('form-control') }}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Url</label>
                        {{ Aire::input('sites[url]')->Class('form-control')->type('text') }}
                    </div>

                    <div class="form-group">
                        <label class="control-label">Email</label>
                        {{ Aire::email('sites[name]')->Class('form-control') }}
                    </div>
                    <div class="form-group">
                        <label class="control-label">Price Modification</label>
                        {{ Aire::input('sites[price_modification]')->Class('form-control')->type('number') }}
                    </div>
                </div>
 </div>

</div>
@include('sites.test_rules')


<div class="col-lg-6 members-position">
            <div class="card shadow mb-4">
                <div class="card-header">
                    Scrape rules
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="control-label">Title</label>
                        {{ Aire::input('sync_Rules[title]')->Class('form-control')->type('text') }}

                    </div>

                    <div class="form-group">
                        <label class="control-label">Description</label>
                        {{ Aire::input('sync_Rules[description]')->Class('form-control')->type('text') }}                       
                    </div>

                    <div class="form-group">
                        <label class="control-label">Specification</label>
                        {{ Aire::input('sync_Rules[specifications]')->Class('form-control')->type('text') }}                       

                    </div>

                    <div class="form-group">
                        <label class="control-label">Price</label>
                        {{ Aire::input('sync_Rules[price]')->Class('form-control')->type('text') }}                       
                    </div>

                    <div class="form-group">
                        <label class="control-label">Price decimals</label>
                        {{ Aire::input('sync_Rules[price_decimals]')->Class('form-control')->type('text') }}                       
                    </div>

                    <div class="form-group">
                        <label class="control-label">In stock</label>
                        {{ Aire::input('sync_Rules[specifications]')->Class('form-control')->type('text') }}                       
                    </div>

                    <div class="form-group">
                        <label class="control-label">In stock value</label>
                        {{ Aire::input('sync_Rules[in_stock_value]')->Class('form-control')->type('text') }}                       
                    </div>

                    <div class="form-group">
                        <label class="control-label">Images</label>
                        {{ Aire::input('sync_Rules[images]')->Class('form-control')->type('text') }}                       
                    </div>

                    <div class="form-group">
                        <label class="control-label">Variants</label>
                        {{ Aire::input('sync_Rules[variants]')->Class('form-control')->type('text') }}                       
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
</div>
  
</div>
  
{{ Aire::submit('Save') }}
  
{{ Aire::close() }}
--}}

    <!-- /.content -->
@endsection
