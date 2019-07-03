@extends('layouts.main')


@section('content')

    <!-- Main content -->
    {!! Form::open(['route'=>'sites.store', 'method'=>'POST', 'class'=>'validate']) !!}
<section class="content">
          <div class="row">
              <div class="col-md-6 members-position">
                  
              @include('partials.errors')
                  
                <div class="box">
                      <div class="box-body">
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

        

               
    <div class="box-footer">
         <div class="pull-left">
         <a href="{{route('sites.index')}}" class="btn btn-primary btn-lg">Back</a>
         </div>
            
         <div class="pull-right">
             <button class="btn btn-success btn-lg">Save</button>
         </div>
        
                      </div>
                 </div>
             </div>
              
        </div>
</section>
    {!! Form::close() !!}
    
    <!-- /.content -->
@endsection