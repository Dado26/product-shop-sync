@extends('layouts.main')


@section('content')

    <!-- Main content -->
    {!! Form::open(['route'=>'store.user', 'method'=>'POST', 'class'=>'validate']) !!}
<section class="content">
          <div class="row">
              <div class="col-md-6 members-position">
                  
              @include('partials.errors')
                  
                <div class="box">
                      <div class="box-body">
                <div class="form-group">
                  <label>First Name</label>
                  {!! Form::input('text', 'first_name', null, ['class'=>'form-control']) !!}
                </div>                          
                 
               <div class="form-group">
               <label>Last Name</label>                              
                  {!! Form::input('text', 'last_name', null, ['class'=>'form-control']) !!}            
               </div>
                          
               <div class="form-group">
               <label>Email</label>                              
                  {!! Form::input('text', 'email', null, ['class'=>'form-control']) !!}            
               </div>

                <label>Password</label>                              
                  {!! Form::input('password', 'password', null, ['class'=>'form-control']) !!}            
               </div>

               <label>Repeat Password</label>                              
                  {!! Form::input('password', 'password_confirmation', null, ['class'=>'form-control']) !!}            
               </div>


                          
               
    <div class="box-footer">
         <div class="pull-left">
         <a href="{{route('index.users')}}" class="btn btn-primary btn-lg">Back</a>
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