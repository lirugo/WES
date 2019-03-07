@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('notifications') }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12 m6">
            <ul class="collection">
                @foreach($notifications as $notif)
                    <li class="collection-item avatar">
                        <i class="material-icons circle green m-t-10">notifications</i>
                            <span class="title">
                                 {{array_values($notif->data)[0]}}
                            </span>
                            <p>
                                 {{array_values($notif->data)[1]}}
                            <br/>
                            <a href="{{array_values($notif->data)[2]}}" class="">Open</a>
                            </p>

                        <a href="#!" class="secondary-content"><i class="material-icons">remove_red_eye</i></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
