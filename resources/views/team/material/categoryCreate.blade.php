@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-material-category-create', $team, $discipline) }}
@endsection
@section('content')
{{--    Create Educ Mat Category--}}
    {!! Form::open(['route' => ['team.material.category.store', $team->name, $discipline->name], 'method' => 'POST']) !!}
    <div class="row">
        <div class="col s12 l6">
            <div class="card-panel">
                <h6 class="center-align">Add Education Material Category</h6>
                <div class="input-field ">
                    <input placeholder="Enter education material category name" name="name" type="text" class="validate" required>
                </div>
            </div>
        </div>

        @if(Auth::user()->hasRole(['manager', 'teacher']))
            {{--Floating button--}}
            <div class="fixed-action-btn">
                <button type="submit" class="btn-floating btn-large green tooltipped"
                        data-position="left"
                        data-tooltip="Save">
                    <i class="large material-icons">save</i>
                </button>
            </div>
        @endif
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')

@endsection
