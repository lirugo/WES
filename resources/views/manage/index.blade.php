@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('manage') }}
@endsection

@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">@lang('app.Manage Panel')</span>
                    <p>
                         @lang('app.No content yet...')
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
