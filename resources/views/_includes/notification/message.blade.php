{{--Check have a flash message--}}
@if (Session::has('success'))
    <div class="row">
        <div class="col s12">
            <div class="card-panel green darken-1 white-text m-b-0 p-t-10 p-b-10">
                <strong>Well done!</strong> {{ Session::get('success') }}
            </div>
        </div>
    </div>
@endif
@if (Session::has('info'))
    <div class="row">
        <div class="col s12">
            <div class="card-panel light-blue white-text m-b-0 p-t-10 p-b-10">
                <strong>Heads up!</strong> {{ Session::get('info') }}
            </div>
        </div>
    </div>
@endif
@if (Session::has('warning'))
    <div class="row">
        <div class="col s12">
            <div class="card-panel orange darken-1 white-text m-b-0 p-t-10 p-b-10">
                <strong>Warning!</strong> {{ Session::get('warning') }}
            </div>
        </div>
    </div>
@endif
@if (count($errors) > 0)
    <div class="row">
        <div class="col s12">
            <div class="card-panel red darken-1 white-text m-b-0 p-t-10 p-b-10">
                <ul>
                    <strong>Oh snap!</strong>
                    @foreach($errors->all() as $error)
                        <li> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif