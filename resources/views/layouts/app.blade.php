<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Staffs App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" >
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" >
</head>
<body>
    @include('layouts.header')

    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Сотрудники</h1>
                <a href="{{ action('StaffsController@create') }}" class="btn btn-warning  mt-2">Добавить сотрудника</a>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </main>
    <div class="preloader"><div class="loader"></div></div>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
