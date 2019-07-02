<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>@yield('title', 'product-sync')</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  </head>

  <body>
    <div class="container">

      @yield('header')

      <div class="row">

          <!-- LEFT SIDE -->
        <div class="col-sm-8 blog-main">

          @yield('content')

        </div><!-- /.blog-main -->

        <!-- RIGHT SIDE -->
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">

        </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
  </body>
</html>
