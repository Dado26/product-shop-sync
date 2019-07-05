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
                        {{ $site->name}}
                    </td>

                    <td class="text-center">
                        <a href="{{ $site->url }}" target="_blank">{{ $site->url }}</a>
                    </td>

                    <td class="text-center">
                        {{ $site->Imported}}
                    </td>

                    <td class="text-center">
                        {{ $site->created_at}}
                    </td>

                    <td class="text-center">
                        {{ $site->updated_at}}
                    </td>

                    <td class="text-center">
                        <div class="users-list-actions">

                           <!-- Delete button Warrning Modal -->
<div class="modal fade" id="confirmButton" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Delete site</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this site?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>

                {!! Form::open(['route'=>['sites.destroy', $site->id],'method'=>'DELETE','class'=>'pull-right delete']) !!}
                <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
<!-- Delete button Warrning Modal End-->

                            <div class="edit-user">
                                <a href="{{ route('sites.edit', $site->id) }}" class="btn btn-success d-none d-sm-inline-block btn-sm">
                                    <i class="fas fa-edit"></i> Edit
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


<!-- Delete button Warrning Modal -->
<div class="modal fade" id="confirmButton" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Delete site</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this site?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>

                {!! Form::open(['route'=>['sites.destroy', $site->id],'method'=>'DELETE','class'=>'pull-right delete']) !!}
                <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
<!-- Delete button Warrning Modal End-->

@endsection
