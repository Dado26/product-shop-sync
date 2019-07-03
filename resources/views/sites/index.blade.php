@extends('layouts.main')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Sites</h1>
    <a href="{{ route('site.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
        <i class="fas fa-plus"></i> Create
    </a>
</div>

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
            <p> {{ $site->name}} </p>

        </td>

        <td>
            <p> {{ $site->url}} </p>
        </td>

        <td>
            <p> {{ $site->Imported}} </p>
        </td>

        <td>
            <p> {{ $site->created_at}} </p>
        </td>

        <td>
            <p> {{ $site->updated_at}} </p>
        </td>

        <td>

            <a href="{{ route('site.edit', $site->id) }}" class="btn btn-warning">Edit</a>

            {!! Form::open(['route'=>['site.destroy', $site->id],'method'=>'DELETE','class'=>'pull-right delete']) !!}
            <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
            {!!Form::close()!!}

            <div class="users-list-actions">
                        <div class="delete-user">
                            {!! Form::open(['route'=>['destroy.user', $user->id],'method'=>'DELETE','class'=>'delete']) !!}
                                <button type="submit" value="Delete" class="btn btn-danger d-none d-sm-inline-block btn-sm">
                                    <i class="fas fa-user-minus fa-fw"></i>  Delete
                                </button>
                            {!!Form::close()!!}
                        </div>
                        <div class="edit-user">
                            <a href="{{ route('edit.user', $user->id) }}" class="btn btn-success d-none d-sm-inline-block btn-sm">
                                <i class="fas fa-user-edit fa-fw"></i> Edit
                            </a>
                        </div>
                    </div>


        </td>
    </tr>

    @endforeach

</table>

<div class="pull-right">
    {!! $sites->render() !!}
</div>

@endsection
