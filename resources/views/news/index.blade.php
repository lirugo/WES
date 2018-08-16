@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('news') }}
@endsection

@section('content')
    <div class="row m-t-20">
        @foreach($news as $news)
            <div class="col s12 m8 l8 offset-l2 offset-m2">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$news->title}}</span>
                        <p>{!! $news->description !!}</p>
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
        @role(['administrator', 'top-manage', 'manager'])
            <div class="fixed-action-btn">
                <a href="{{url('/news/create')}}" class="btn-floating btn-large waves-effect waves-light red">
                    <i class="large material-icons">add</i>
                </a>
            </div>
        @endrole
    </div>
@endsection
