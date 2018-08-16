@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('discipline-edit', $discipline) }}
@endsection
@section('content')
    {!! Form::open([$discipline, 'route' => ['discipline.update',$discipline->name], 'method' => 'POST']) !!}
    {{--Header--}}
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title center-align">Discipline - {{$discipline->display_name}}</span>
                    <button type="submit" href="{{url('/discipline/'.$discipline->name.'/edit')}}" class="indigo waves-effect waves-light btn right"><i class="material-icons right">cloud</i>Update</button>
                    <a href="{{url('/discipline')}}" class="indigo waves-effect waves-light btn left m-r-10 tooltipped" data-tooltip="Information will be lost!" data-position="top"><i class="material-icons left">apps</i>Back to disciplines</a>

                </div>
            </div>
        </div>
    </div>
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel hoverable">
                <div class="input-field">
                    <i class="material-icons prefix">group</i>
                    {!! Form::text('display_name', $discipline->display_name, ['class' => 'validate', 'id' => 'display_name', 'required']) !!}
                    <label for="display_name">Displaying Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">attachment</i>
                    {!! Form::text('name', $discipline->name, ['class' => 'validate', 'id' => 'name', 'required', 'disabled']) !!}
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    {!! Form::textarea('description', $discipline->description, ['class' => 'validate materialize-textarea', 'id' => 'description', 'required']) !!}
                    <label for="description">Description</label>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
