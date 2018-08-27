@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('library') }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card horizontal">
                <div class="card-image">
                    <img src="{{url('/library/image/'.$library->image)}}">
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="new badge blue" data-badge-caption="year">{{$library->year}}</span>
                        <span class="new badge green" data-badge-caption="pages">{{$library->pages}}</span>
                        <span class="new badge red" data-badge-caption="">PDF</span>
                    <span class="card-title">{{$library->title}}</span>
                        @foreach($library->authors as $name)
                            {{$name->getShortName()}} |
                        @endforeach
                        <hr>
                        <p>{!! $library->description !!}</p>

                    </div>
                    <div class="m-l-20 m-b-10 bottom">
                        @foreach($library->tags as $tag)
                            <div class="chip">
                                {{$tag->get->display_name}}
                            </div>
                        @endforeach
                    </div>
                    <a class="btn-floating btn halfway-fab right waves-effect waves-light indigo"><i class="material-icons">cloud_download</i></a>
                </div>
            </div>
        </div>
    </div>
    @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager']))
    <div class="row">
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-content">
                    {!! Form::open(['route' => ['library.author.update', $library->id]]) !!}
                    <span class="card-title center-align">Add Author</span>
                    <div class="input-field">
                        <input placeholder="Second Name" id="second_name" name="second_name" type="text" class="validate" required>
                    </div>
                    <div class="input-field">
                        <input placeholder="Name" id="name" name="name" type="text" class="validate" required>
                    </div>
                    <div class="input-field">
                        <input placeholder="Middle Name" id="middle_name" name="middle_name" type="text" class="validate" required>
                    </div>
                    <button class="btn indigo waves-effect waves-light" type="submit">Add
                        <i class="material-icons right">send</i>
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
