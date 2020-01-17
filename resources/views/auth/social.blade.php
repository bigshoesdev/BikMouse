<html>
<head>
    <title>@lang('general/message.bikmouse')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/general/logo_icon.png') }}">
</head>
<body>
<script type="text/javascript">
    var login = {
        success: {{$success}},
        msg: "{{$msg}}"
    };

    if (window.opener && window.opener.handleLogin) {
        window.opener.handleLogin(login);
    }
</script>
</body>
</html>