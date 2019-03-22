@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-common-file-create', $team) }}
@endsection
@section('content')
    <div class="row" id="team-create">
        <div class="col s12">
            {!! Form::open(['route' => ['team.common.file.store', $team->name], 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class="col s12 m6 l6">
                    <div class="card-panel">
                        <div class="input-field">
                            <i class="material-icons prefix">title</i>
                            <input id="title" name="title" type="text" class="validate" required value="{{ old('title') }}">
                            <label for="title">Title</label>
                        </div>
                        <div class="input-field">
                            <div class="file-field">
                                <div class="btn indigo">
                                    <span>Common File</span>
                                    <input type="file" name="file" accept="application/pdf" required>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload only PDF">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fixed-action-btn">
                <button type="submit" class="btn-floating btn-large waves-effect waves-light green"><i class="material-icons">save</i></button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
