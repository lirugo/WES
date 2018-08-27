@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('library') }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="https://images-na.ssl-images-amazon.com/images/I/41T9JSV0ZAL.jpg">
                </div>
                <div class="card-content p-b-10">
                    <span class="card-title activator grey-text text-darken-4">Java Black Book<i class="material-icons right">more_vert</i></span>
                    <small>Jhordan H.M Mickle F.A. Benedict D.D.</small>
                    <a class="btn-floating btn halfway-fab right waves-effect waves-light indigo"><i class="material-icons">cloud_download</i></a>
                </div>
                <div class="card-content p-t-0">
                    <span class="new badge blue" data-badge-caption="year">1984</span>
                    <span class="new badge green" data-badge-caption="pages">963</span>
                    <span class="new badge red" data-badge-caption="">PDF</span>
                </div>
                <div class="card-content p-t-5">

                    <div class="chip">
                        Management Accounting
                    </div>
                    <div class="chip">
                        Some long tag
                    </div>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Java Black Book<i class="material-icons right">close</i></span>
                    <p>
                        Today I am sharing the best java books to learn java programming.
                        Java is one of the most widely used programming languages.
                        You will find java based applications everywhere, from embedded systems to web applications.
                        Android programming is built on top of java, that is used in billions of smartphones, tablets etc.
                        So if you want to build your career as a Java professional,
                        having good core java knowledge is a must. If you are good at Core Java,
                        learning all other java based frameworks is not that hard. That’s why,
                        even after working in IT industry for 10 years and using several Java,
                        Java EE frameworks; I value Core Java most.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
