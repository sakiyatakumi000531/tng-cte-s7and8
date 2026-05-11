<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="旧CyTech STEP7 テスト">
    <meta name="author" content="Takumi Sakiya(Tokyo Branch)">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @yield('js') {{-- ページ固有のJS --}}
    @yield('css') {{-- ページ固有のCSS --}}
</head>

<body>
    <header>
        <h1>@yield('title')</h1>
        @yield('search_box')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <form action = "{{ route('logout') }}" method = "POST">
            @csrf
            <button type = "submit">ログアウト</button>
        </form>
    </footer>
</body>

</html>