{{--Check have a flash message--}}
@if (Session::has('success'))
    <script>
        M.toast({
            html: 'Success - {!! json_encode(Session::get('success')) !!}',
            displayLength: 4000,
            classes: 'green darken-1'
        });
    </script>
@endif
@if (Session::has('info'))
    <script>
        M.toast({
            html: 'Heads up - {!! json_encode(Session::get('info')) !!}',
            displayLength: 4000,
            classes: 'light-blue'
        });
    </script>
@endif
@if (Session::has('warning'))
    <script>
        M.toast({
            html: 'Warning - {!! json_encode(Session::get('warning')) !!}',
            displayLength: 4000,
            classes: 'orange darken-1'
        });
    </script>
@endif
@if (count($errors) > 0)
    @foreach($errors->all() as $error)
        <script>
            M.toast({
                html: 'Oh snap - {!! json_encode($error) !!}',
                displayLength: 6000,
                classes: 'red darken-1'
            });
        </script>
    @endforeach
@endif