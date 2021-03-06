@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('notifications') }}
@endsection
@section('content')
    <div class="row" id="notification">
        <form action="{{url('/notification/markall')}}" method="POST">
            @csrf
            <button type="submit" class="waves-effect waves-light btn btn-small indigo m-t-10 m-l-10">@lang('app.mark all as read')</button>
        </form>
        <div class="col s12 m6">
            <blockquote>@lang('app.Unread')</blockquote>
            @if(count(Auth::user()->unreadNotifications) == 0)
                <small>@lang('app.Nothing new...')</small>
            @else
                <ul class="collection">
                    @foreach(Auth::user()->unreadNotifications as $notif)
                        <li class="collection-item avatar">
                            <i class="material-icons circle green m-t-10">notifications</i>
                            <span class="title">
                                 {{array_values($notif->data)[0]}}
                            </span>
                            <p>
                                {{array_values($notif->data)[1]}}
                                <br/>
                                @if(array_values($notif->data)[2])
                                    <a href="{{array_values($notif->data)[2]}}" @click.prevent="markAsRead({{json_encode($notif->id)}}, {{json_encode(array_values($notif->data)[2])}})">@lang('app.Open')</a>
                                @endif
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="col s12 m6">
            <blockquote>@lang('app.Read')</blockquote>
            <ul class="collection">
                @foreach(Auth::user()->notifications  as $notif)
                    <li class="collection-item avatar">
                        <i class="material-icons circle green m-t-10">notifications</i>
                        <span class="title">
                                 {{array_values($notif->data)[0]}}
                            </span>
                        <p>
                            {{array_values($notif->data)[1]}}
                            <br/>
                            @if(array_values($notif->data)[2])
                                <a href="{{array_values($notif->data)[2]}}" class="">@lang('app.Open')</a>
                            @endif
                        </p>

                        <a href="#!" class="secondary-content"><i class="material-icons">remove_red_eye</i></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#notification',
            methods: {
                markAsRead(id, url){
                    axios.post('/notification/markasread/'+id, {id:id})
                        .then(res => {
                            console.log(res)
                        })
                        .finally(() => {
                            window.location.replace(url)
                        })
                }
            }
        })
    </script>
@endsection
