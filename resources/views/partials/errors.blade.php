@if(count($errors) >0 )
    <div class="card bg-danger text-white shadow validation-errors">
        <div class="card-body">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach

            </ul>
        </div>
    </div>
@endif


