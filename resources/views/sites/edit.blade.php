@extends('layouts.main')


@section('content')

    <!-- Main content -->
    <form action="{{ route('sites.update', $site->id) }}" method="POST" class="form-horizontal">
             {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            
            @include('partials.errors')

            <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sites[name]" class="form-control" value="{{$site->name}}">
                    
                </div>
                
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">URL</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sites[url]" class="form-control" value="{{$site->url}}">
                    
                </div>
                
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sites[email]" class="form-control" value="{{$site->email}}">
                    
                </div>
                
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sync_Rules[title]" class="form-control" value="{{ $site->SyncRules->title}}">
                    
                </div>
                
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                    
                    <textarea rows="17" cols="80" name="sync_Rules[description]" class="form-control">{{ $site->SyncRules->description}}</textarea>
                    
                </div>
                
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sync_Rules[price]" class="form-control" value="{{ $site->SyncRules->price }}">
                    
                </div>
                
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">In Stock</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sync_Rules[in_stock]" class="form-control" value="{{  $site->SyncRules->in_stock}}">
                    
                </div>
                
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">In_stock_value</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sync_Rules[in_stock_value]" class="form-control" value="{{ $site->SyncRules->in_stock_value}}">
                    
                </div>
                
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">Images</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sync_Rules[images]" class="form-control" value="{{ $site->SyncRules->images }}">
                    
                </div>
                
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Variants</label>
                <div class="col-sm-10">
                    
                    <input type="text" name="sync_Rules[variants]" class="form-control" value="{{ $site->SyncRules->variants }}">
                    
                </div>
                
            </div>
            
            
           <a href="{{route('sites.index') }}" class="btn btn-primary pull-left" >Back</a>

           <button type="submit" class="btn btn-success pull-right">Save</button>
            
</form>
    
    <!-- /.content -->
@endsection
