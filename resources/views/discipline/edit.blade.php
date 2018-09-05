@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('discipline-edit', $discipline) }}
@endsection
@section('content')
    {!! Form::open([$discipline, 'route' => ['discipline.update',$discipline->name], 'method' => 'POST']) !!}
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
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Save">
            <i class="large material-icons">save</i>
        </button>
    </div>
    {!! Form::close() !!}
@endsection
