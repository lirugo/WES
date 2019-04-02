<html>
<head></head>
<title>@lang('app.Feedback')</title>
<body>
    <p>@lang('app.User') - {{$user->getShortName()}}</p>
    <p>@lang('app.Title') - {{$title}}</p>
    <p>@lang('app.Body') - {{$body}}</p>
</body>
</html>