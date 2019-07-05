@extends('layouts.main')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">Sites</h1>
    <a href="{{ route('sites.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
        <i class="fas fa-plus"></i> Create
    </a>
</div>

@include('flash::message')

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered">
            <tr class="card-header">
                <th class="text-center">ID</th>
                <th class="text-center">Name</th>
                <th class="text-center">Url</th>
                <th class="text-center">Imported</th>
                <th class="text-center">Created at</th>
                <th class="text-center">Updated at</th>
                <th class="text-center">Actions</th>
            </tr>

            @foreach($sites as $site)

            <tr class="align-td">
                <td class="text-center">
                    {{ $site->id }}
                </td>

                <td class="text-center">
                    {{ $site->name }}
                </td>

                <td class="text-center">
                    <a href="{{ $site->url }}" target="_blank">{{ $site->url }}</a>
                </td>

                <td class="text-center">
                    {{ $site->Imported }}
                </td>

                <td class="text-center">
                    {{ $site->created_at }}
                </td>

                <td class="text-center">
                    {{ $site->updated_at }}
                </td>

                <td class="text-center">
                    <div class="users-list-actions">
                        <div class="delete-user">
                            {!! Form::open(['route'=>['sites.destroy', $site->id],'method'=>'DELETE','class'=>'pull-right delete', 'id'=>'form-delete-user-'.$site->id]) !!}
                            <button type="submit" data-toggle="modal" data-target="#confirmButton" class="btn btn-danger d-none d-sm-inline-block btn-sm btn-delete">
                                Delete
                            </button>
                            {!! Form::close() !!}
                        </div>

                        <div class="edit-user">
                            <a href="{{ route('sites.edit', $site->id) }}" class="btn btn-success d-none d-sm-inline-block btn-sm">
                                Edit
                            </a>
                        </div>
                    </div>
                </td>
            </tr>

            @endforeach

        </table>
    </div>

    <div class="card-footer d-flex justify-content-center">
        <div class="mt-3">
            {!! $sites->render() !!}
        </div>
    </div>
</div>


@component('components.confirmation_modal')
    @slot('title')
        Delete site
    @endslot

    Are you sure you want to delete this site?
@endcomponent

@endsection
