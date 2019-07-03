@extends('layouts.main')
@section('content')
<a href="{{ route('site.create') }}" class="btn btn-success pull-right add-member" style="width: 200px">
                <i class="fa fa-plus"></i> Create
</a>
<table class="table table-striped">
                    <tr>                    
                        <th>Name</th>
                        <th>Url</th>
                        <th>Imported</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>


                    </tr>
                  @foreach($sites as $site)

                    <tr>   
                        <td>                           
                                <p> {{ $site->name}}  </p>                         
                                                          
                        </td>

                        <td>
                                <p> {{ $site->url}}  </p>    
                        </td>

                        <td>
                                <p> {{ $site->Imported}}  </p>    
                        </td>  

                        <td>
                                <p> {{ $site->created_at}}  </p>    
                        </td>

                        <td>
                                <p> {{ $site->updated_at}}  </p>    
                        </td>

                        <td> 
                                <a href="{{ route('site.edit', $site->id) }}" class="btn btn-warning">Edit</a>

                        {!! Form::open(['route'=>['site.destroy', $site->id],'method'=>'DELETE','class'=>'pull-right delete']) !!}
                            <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
                          {!!Form::close()!!}
                        </td>
                                              

                    </tr>
                    @endforeach

            <div class="pull-right">
                    {!! $sites->render() !!}
            </div>
@endsection