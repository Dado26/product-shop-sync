!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Product Sync - Login</title>

        <!-- Custom fonts for this template-->
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    </head>

    <body class="bg-gradient-primary">

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-5 col-lg-6 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Product Sync</h1>
                                        </div>

                                        <form class="user" method="POST" action="{{ route('test.login') }}">
                                            {{ csrf_field() }}

                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user" name="email"
                                                       value="{{ old('email') }}" placeholder="Enter Email Address..." required
                                                       autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" placeholder="Password" required>
                                        </div>

                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember Me</label>
                                                </div>
                                            </div>

                                            @include('partials.errors')

                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </body>

</html>
