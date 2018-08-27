<footer class="page-footer indigo">
    <div class="container">
        <div class="row m-b-5">
            <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
            </div>
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
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
        </div>
    </div>
</footer>