@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('chat') }}
@endsection
@section('content')
    <div id="chat">
        <chat-component></chat-component>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#chat',
            mounted(){
                console.log('Chat mounted')
            }
        })
    </script>
@endsection
