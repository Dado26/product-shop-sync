@extends('layouts.main')

@section('content')

<!-- Main content -->
{!! Form::model($user, ['route'=>['user.update', $user->id], 'method'=>'PUT', 'class'=>'validate']) !!}

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Users Info</h1>
</div>

<div class="row">
    <div class="col-md-6 members-position">

        @include('partials.errors')

        <div class="card shadow mb-4">

            <div class="card-body">
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

                <div class="form-group">
                    <label>Password</label>
                    {!! Form::input('password', 'password', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Repeat Password</label>
                    {!! Form::input('password', 'password_confirmation', null, ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <div class="back">
                    <a href="{{route('users.index')}}" class="btn btn-primary d-none d-sm-inline-block">
                        <i class="fas fa-angle-left"></i> Back
                    </a>
                </div>

                <div class="save-user">
                    <button class="btn btn-success d-none d-sm-inline-block">
                        <i class="far fa-save"></i> Save
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

</section>
{!! Form::close() !!}

<!-- /.content -->
@endsection
