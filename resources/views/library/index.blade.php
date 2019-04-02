@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('library') }}
@endsection
@section('content')
{{--    <div class="row m-b-0" xmlns:v-clipboard="http://www.w3.org/1999/xhtml">--}}
{{--        <div class="col s12">--}}
{{--            <div class="card-panel p-b-10 p-t-10">--}}
{{--                <a href="{{url('/library/?sort=asc')}}">New first</a> |--}}
{{--                <a href="{{url('/library/?sort=desc')}}">Old first</a> |--}}
{{--                <a href="{{url('/library/?sort=a-z')}}">Title A-Z</a> |--}}
{{--                <a href="{{url('/library/?sort=z-a')}}">Title Z-A</a> |--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="row" id="clipboard">
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
                        <span class="new badge blue" data-badge-caption="@lang('app.year')">{{$library->year}}</span>
                        <span class="new badge green" data-badge-caption="@lang('app.pages')">{{$library->pages}}</span>
                        <span class="new badge red" data-badge-caption="">PDF</span>
                    </div>
                    <div class="card-content p-t-5">
                        @foreach($library->tags as $tag)
                            @if($tag->get)
                                <div class="chip">
                                    {{$tag->get->display_name}}
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">{{$library->title}}<i class="material-icons right">close</i></span>
                        <p>
                            {!! $library->description !!}
                        </p>
                    </div>
                    <a class="btn-floating btn left halfway-fab m-l-80 waves-effect waves-light indigo tooltipped"
                       @click="copyToClipBoard({{ $library->id }})"
                       data-position="bottom" data-tooltip="Copy to buffer"
                       href="#"><i class="material-icons">content_copy</i></a>
                    <a class="btn-floating btn halfway-fab left waves-effect waves-light indigo tooltipped"
                       data-position="bottom" data-tooltip="Open"
                       href="{{url('/library/'.$library->id)}}"><i class="material-icons">open_in_new</i></a>
                    <a class="btn-floating btn halfway-fab right waves-effect waves-light indigo tooltipped"
                       data-position="bottom" data-tooltip="Download file"
                       href="{{url('/library/file/'.$library->file)}}" download><i class="material-icons">cloud_download</i></a>
                </div>
            </div>
        @endforeach
    </div>
    @if(count($libraries) == 0)
        <div class="row">
            <div class="col s12">
                @lang('app.So far there is nothing here...')
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
                <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="@lang('app.Tags')" href="{{url('/tag')}}"><i class="material-icons">visibility</i></a></li>
            </ul>
        </div>
        @endrole
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#clipboard',
            data: {
              url: '{{url('/library/')}}'
            },
            methods: {
                copyToClipBoard(libraryId){
                    this.$copyText(this.url + '/' + libraryId).then(function (e) {
                        M.toast({html: 'Copied to buffer!'})
                    })
                },
            }
        });
    </script>
@endsection
