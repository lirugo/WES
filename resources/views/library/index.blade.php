@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('library') }}
@endsection
@section('content')
    <div class="row">
        @foreach($libraries as $library)
            <div class="col s12 m4 l4">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="{{url('/library/image/'.$library->image)}}">
                    </div>
                    <div class="card-content p-b-10">
                        <span class="card-title activator grey-text text-darken-4">{{$library->title}}<i class="material-icons right">more_vert</i></span>
                        <small> |
                            @foreach($library->authors as $author)
                                {{$author->getShortName()}} |
                            @endforeach
                        </small>
                    </div>
                    <div class="card-content p-t-0">
                        <span class="new badge blue" data-badge-caption="year">{{$library->year}}</span>
                        <span class="new badge green" data-badge-caption="pages">{{$library->pages}}</span>
                        <span class="new badge red" data-badge-caption="">PDF</span>
                    </div>
                    <div class="card-content p-t-5">
                        @foreach($library->tags as $tag)
                            <div class="chip">
                                {{$tag->get->display_name}}
                            </div>
                        @endforeach
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">{{$library->title}}<i class="material-icons right">close</i></span>
                        <p>
                            {!! $library->description !!}
                        </p>
                    </div>

                    <a class="btn-floating btn halfway-fab left waves-effect waves-light indigo" href="{{url('/library/'.$library->id)}}"><i class="material-icons">open_in_new</i></a>
                    <a class="btn-floating btn halfway-fab right waves-effect waves-light indigo" href="{{url('/library/file/'.$library->file)}}" download><i class="material-icons">cloud_download</i></a>
                </div>
            </div>
        @endforeach
    </div>
    @if(count($libraries) == 0)
        <div class="row">
            <div class="col s12">
                So far there is nothing here...
            </div>
        </div>
    @endif
    <div class="row">
        @role(['administrator', 'top-manager', 'manager'])
        <div class="fixed-action-btn">
            <a href="{{url('/library/create')}}" class="btn-floating btn-large waves-effect waves-light red">
                <i class="large material-icons">add</i>
            </a>
            <ul>
                <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="Tags" href="{{url('/tag')}}"><i class="material-icons">visibility</i></a></li>
            </ul>
        </div>
        @endrole
    </div>
@endsection
