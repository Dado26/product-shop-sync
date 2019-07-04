@extends('layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800">Users</h1>
        <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Create
        </a>
    </div>

    @include('flash::message')

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
                <td class="text-center">
                    <p> {{ $user->id }} </p>
                </td>
                <td class="text-center">
                    <p> {{ $user->email}} </p>
                </td>
                <td class="text-center">
                    <p> {{ $user->first_name}} </p>
                </td>
                <td class="text-center">
                    <p> {{ $user->last_name}} </p>
                </td>
                <td class="text-center">
                    <p> {{ $user->created_at}} </p>
                </td>
                <td class="text-center">
                    <p> {{ $user->updated_at}} </p>
                </td class="text-center">
                <td>
                    <div class="users-list-actions">
                        <div class="delete-user">
                            <button type="button" data-toggle="modal" data-target="#confirmButton" class="btn btn-danger d-none d-sm-inline-block btn-sm">
                                <i class="fas fa-user-minus fa-fw"></i>  Delete
                            </button>
                        </div>
                        <div class="edit-user">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success d-none d-sm-inline-block btn-sm">
                                <i class="fas fa-user-edit fa-fw"></i> Edit
                            </a>
                        </div>
                    </div>

                    <!-- Delete button Warrning Modal -->
                    <div class="modal fade" id="confirmButton" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" >Delete user</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this user?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>

                                    {!! Form::open(['route'=>['user.destroy', $user->id],'method'=>'DELETE','class'=>'pull-right delete']) !!}
                                        <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
                                    {!!Form::close()!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete button Warrning Modal End-->
                </td>
            </tr>
        @endforeach
    </table>
@endsection
