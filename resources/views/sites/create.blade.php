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
            </div>
        </div>

        <!-- TEST RULES -->
        <div class="card shadow mb-4" id="test-rules">
            <div class="card-header">
                Test Rules
            </div>

            <div class="card-body">
                <div class="d-flex form-inline navbar-search mb-2">
                    <div class="input-group w-75">
                        <div class="input-group-prepend">
                            <span class="input-group-text">URL:</span>
                        </div>
                        <input type="text" id="test-url" class="form-control border" placeholder="https://shop.com/product/73625">
                    </div>

                    <button type="button" id="check-rules-btn" class="btn btn-primary shadow-sm w-auto ml-3">
                        Check Rules
                    </button>
                </div>

                <!-- SPINNER -->
                <div class="text-center mt-5 mb-4" style="display: none">
                    <div class="spinner"></div>
                </div>

                <!-- RESULTS -->
                <div class="results-container" style="display: none">
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group title">
                                <label class="control-label">Title</label>
                                <div class="form-control text-truncate"></div>
                            </div>

                            <div class="form-group description">
                                <label class="control-label">Description</label>
                                <div class="form-control text-truncate"></div>
                            </div>

                            <div class="form-group price">
                                <label class="control-label">Price</label>
                                <div class="form-control"></div>
                            </div>

                            <div class="form-group in_stock_value">
                                <label class="control-label">In stock value</label>
                                <div class="form-control"></div>
                            </div>

                            <div class="form-group variants">
                                <label class="control-label">Variants</label>
                                <div class="variants-container"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group images">
                                <label class="control-label">Images</label>
                                <div class="images-container"></div>
                            </div>
                        </div>

                        <div class="form-group col specifications">
                            <label class="control-label">Specifications</label>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

<!-- /.content -->
@endsection
