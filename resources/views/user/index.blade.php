@extends('layouts.main')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800">Users</h1>
        <a href="{{ route('create.user') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            Create
        </a>
    </div>

<table class="table table-striped">
    <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Email</th>
        <th class="text-center">First Name</th>
        <th class="text-center">Last Name</th>
        <th class="text-center">Created at</th>
        <th class="text-center">Updated at</th>
        <th class="text-center">Actions</th>
    </tr>

    @foreach($users as $user)

    <tr>
        <td>
            <p> {{ $user->id }} </p>

        </td>
        <td>
            <p> {{ $user->Email}} </p>
        </td>

        <td>
            <p> {{ $user->first_name}} </p>
        </td>
        <td>
            <p> {{ $user->last_name}} </p>
        </td>
        <td>
            <p> {{ $user->created_at}} </p>
        </td>
        <td>
            <p> {{ $user->updated_at}} </p>
        </td>
        <td>
            <div class="users-list-actions">
                <div class="delete-user">
                    {!! Form::open(['route'=>['destroy.user', $user->id],'method'=>'DELETE','class'=>'delete']) !!}
                    <button type="submit" value="Delete" class="btn btn-danger d-none d-sm-inline-block btn-sm">Delete</button>
                    {!!Form::close()!!}
                </div>
                <div class="edit-user">
                    <a href="{{ route('edit.user', $user->id) }}" class="btn btn-success d-none d-sm-inline-block btn-sm">Edit</a>
                </div>
            </div>
        </td>

    </tr>
    @endforeach
    @endsection
