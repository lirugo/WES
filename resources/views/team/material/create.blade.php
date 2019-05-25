@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-material-create', $team, $discipline) }}
@endsection
@section('content')
    <div>
        {!! Form::open(['route' => ['team.material.store', $team->name, $discipline->name], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
            <div class="col s12 l6">
                <div class="card-panel">
                    <h6 class="center-align">Upload Education Materials</h6>
                    <div class="row m-b-0 m-t-0">
                    <div class="input-field col s12 m-b-0 m-t-0">
                        <input placeholder="Enter education material name" name="name" type="text" class="validate" required>
                    </div>
                        <div class="input-field col s12 m-b-0 m-t-0">
                            <select name="category_id" required>
                                <option value="" disabled>Choose a category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ old('$category') == $category->id ? 'selected="selected"' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="input-field  m-b-0">
                        <i class="material-icons prefix">date_range</i>
                        <input id="public_date" value="{{ old('public_date') }}" name="public_date" type="text" class="datepickerDefault" required>
                        <label for="public_date">Date of publication</label>
                    </div>
                    <div class="file-field input-field  m-b-0">
                        <div class="btn indigo">
                            <span>File</span>
                            <input type="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload file">
                        </div>
                    </div>
                    <p>
                        <label class="right">
                            <input type="checkbox" name="type"/>
                            <span>Public Material</span>
                        </label>
                    </p>
                    </br>
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
