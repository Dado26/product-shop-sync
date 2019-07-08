@extends('layouts.main')

@section('title','Product Sync - User')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800">Users</h1>
        <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>

    @include('flash::message')

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered">

            <tr class="card-header">
                <th class="text-center">ID</th>
                <th class="text-center">Email</th>
                <th class="text-center">First Name</th>
                <th class="text-center">Last Name</th>
                <th class="text-center">Created at</th>
                <th class="text-center">Updated at</th>
                <th class="text-center">Actions</th>
            </tr>

            @foreach($users as $user)
                <tr class="align-td">
                    <td class="text-center">
                        {{ $user->id }}
                    </td>
                    <td class="text-center">
                        {{ $user->email}}
                    </td>
                    <td class="text-center">
                        {{ $user->first_name}}
                    </td>
                    <td class="text-center">
                        {{ $user->last_name}}
                    </td>
                    <td class="text-center">
                        {{ $user->created_at}}
                    </td>
                    <td class="text-center">
                        {{ $user->updated_at}}
                    </td>
                    <td class="text-center">
                        <div class="users-list-actions">
                            <div class="delete-user">
                                {!! Form::open(['route'=>['user.destroy', $user->id],'method'=>'DELETE','class'=>'pull-right delete', 'id'=>'form-delete-user-'.$user->id]) !!}
                                    <button type="submit" data-toggle="modal" data-target="#confirmButton" class="btn btn-danger d-none d-sm-inline-block btn-sm btn-delete">
                                        Delete
                                    </button>
                                {!! Form::close() !!}
                            </div>
                            <div class="edit-user">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success d-none d-sm-inline-block btn-sm">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

@component('components.confirmation_modal')
    @slot('title')
        Delete user
    @endslot

    Are you sure you want to delete this user?
@endcomponent

@endsection
