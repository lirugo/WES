@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-material-category-create', $team, $discipline) }}
@endsection
@section('content')
{{--    Create Educ Mat Category--}}
    {!! Form::open(['route' => ['team.material.link.store', $team->name, $discipline->name], 'method' => 'POST']) !!}
    <div class="row">
        <div class="col s12 l6">
            <div class="card-panel">
                <h6 class="center-align">Add Link</h6>
                <div class="input-field">
                    <i class="material-icons prefix">title</i>
                    <input placeholder="Enter name for link" name="name" type="text" class="validate" required>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">
                        <i class="material-icons prefix">insert_link</i></i>
                    <input placeholder="Enter link" name="link" type="text" class="validate" required>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">date_range</i>
                    <input id="public_date" value="{{ old('public_date') }}" name="public_date" type="text" class="datepickerDefault" required>
                    <label for="public_date">Date of publication</label>
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
