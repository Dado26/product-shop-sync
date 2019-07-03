@extends('layouts.main')
@section('content')
<a href="{{ route('create.user') }}" class="btn btn-success pull-right add-member" style="width: 200px">
                <i class="fa fa-plus"></i> Kreiraj Člana
</a>
<table class="table table-striped">
                    <tr>                    
                        <th>ID</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>


                    </tr>
                  @foreach($users as $user)

                    <tr>   
                        <td>                           
                                <p> {{ $user->id }}  </p>                         
                                                          
                        </td>
                        <td>
                                <p> {{ $user->email}}  </p>    
                        </td>

                        <td>
                                <p> {{ $user->first_name}}  </p>    
                        </td>
                        <td>
                                <p> {{ $user->last_name}}  </p>    
                        </td>
                        <td>
                                <p> {{ $user->created_at}}  </p>    
                        </td>
                        <td>
                                <p> {{ $user->updated_at}}  </p>    
                        </td>
                        <td>
                                <a href="{{ route('edit.user', $user->id) }}" class="btn btn-warning">Edit</a>

                        {!! Form::open(['route'=>['destroy.user', $user->id],'method'=>'DELETE','class'=>'pull-right delete']) !!}
                            <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
                          {!!Form::close()!!}
                        </td>
                       
                        

                    </tr>
                    @endforeach
@endsection