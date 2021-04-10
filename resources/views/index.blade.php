<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Comenion</title>
<link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
@if(env('GA_ENABLE'))
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-139969751-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-139969751-4');
</script>

@endif
</head>
<body>
<div id="app">
</div>
<script src="{{ mix('/js/app.js') }}" defer></script>
</body>
</html>