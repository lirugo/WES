@extends('layouts.app')

@section('content')
    <div class="row m-t-20">
        @foreach($news as $news)
            <div class="col s12 m8 l8 offset-l2 offset-m2">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$news->title}}</span>
                        <p>{{$news->description}}</p>
                    </div>
                </div>
            </div>
        @endforeach
        @if($news->all() == null)
            <div class="row">
                <div class="col s12">
                    <div class="card-panel orange white-text">
                        <h5 class="center-align m-t-0 m-b-0-">Sorry, but you do not have any news...</h5>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
