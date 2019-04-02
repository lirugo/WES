@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('tag') }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable" id="slug">
                <table class="striped responsive-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('app.Name')</th>
                        <th>@lang('app.Display Name')</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        {!! Form::open(['route' => ['tag.delete',$tag->id]]) !!}
                            <tr>
                                <td>{{$tag->id}}</td>
                                <td>{{$tag->name}}</td>
                                <td>{{$tag->display_name}}</td>
                                <td>
                                    <button class="btn btn-small red waves-effect waves-light" type="submit" name="action">@lang('app.Delete')
                                        <i class="material-icons right">delete</i>
                                    </button>
                                </td>
                            </tr>
                        {!! Form::close() !!}
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large green tooltipped" href="{{url('/tag/create')}}" data-position="left" data-tooltip="@lang('app.Create Tag')">
                <i class="large material-icons">add</i>
            </a>
        </div>
    </div>
@endsection