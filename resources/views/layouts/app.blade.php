<!DOCTYPE HTML>
<html lang="ja">
<head>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script>
        $("#search").change(function(){
            $.ajax({
                type:"GET",
                url:"{{ route('list') }}",
                dataType: 'json',
            })
            .done(function(json){
                alert('ajax成功');
            })
            .fail(function(){
                alert('ajax失敗');
            })
            .always(function(){
                //通信の成功と失敗に関わらず実行される処理
            });
        });
    </script>
</body>
</html>