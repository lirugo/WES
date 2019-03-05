<footer class="page-footer indigo p-t-5">
    <div class="container">
        <div class="row m-b-5">
            {{--<div class="col l6 s12">--}}
                {{--<h5 class="white-text">Footer Content</h5>--}}
                {{--<p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>--}}
            {{--</div>--}}
            {{--<div class="col l4 offset-l2 s12">--}}
                {{--<h5 class="white-text">Links</h5>--}}
                {{--<ul>--}}
                    {{--<li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>--}}
                    {{--<li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>--}}
                    {{--<li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>--}}
                    {{--<li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            <div class="col s12 m-t-0 m-b-0">
                <span><small>{{env('APP_NAME')}}</small> | <small>@version</small></span>
                <span class="right">
                    <small>Laravel - {{app()::VERSION}}</small> |
                    <small>Node.js - 10.3.0</small> |
                    <small>PHP - {{phpversion() }}</small>
                </span>
            </div>
        </div>
    </div>
    <div class="footer-copyright indigo darken-2">
        <div class="container">
            © {{date("Y")}} All rights reserved

            {{--Docs pdf link--}}
            @if(Auth::user()->hasRole('manager'))
                <a class="grey-text text-lighten-4 right" href="{{asset('/uploads/docs/se_istr_coordin.pdf')}}"><i class="material-icons">help_outline</i></a>
            @elseif(Auth::user()->hasRole('teacher'))
                <a class="grey-text text-lighten-4 right" href="{{asset('/uploads/docs/se_istr_teacher.pdf')}}"><i class="material-icons">help_outline</i></a>
            @elseif(Auth::user()->hasRole('student'))
                <a class="grey-text text-lighten-4 right" href="{{asset('/uploads/docs/se_istr_listen.pdf')}}"><i class="material-icons">help_outline</i></a>
            @endif

            {{--Feedback form--}}
            <a class="grey-text text-lighten-4 right m-r-10" href="#" @click="showPasswordReset()" id="feedback-modal"><i class="material-icons">announcement</i></a>
            {{--Youtube--}}
            <a class="grey-text text-lighten-4 right m-r-10" target="_blank" href="https://www.youtube.com/playlist?list=PLVhYd7lLjPq0SkCjKTIskEwpCYWTzmggn" @click="showPasswordReset()" id="feedback-modal">
                <img src="{{url('/images/icon/youtube.svg')}}"/>
            </a>
        </div>
    </div>
</footer>