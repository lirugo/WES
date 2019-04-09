@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('chat') }}
@endsection
@section('content')
    <div id="conversations">
        @if(isset($conversation))
            <conversations-dashboard :id="{{$conversation->id}}" :users="users"></conversations-dashboard>
        @else
            <conversations-dashboard :users="users"></conversations-dashboard>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#conversations',
            data(){
                return {
                    users: {!! json_encode($users) !!}
                }
            },
        })
    </script>
@endsection
