<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="旧CyTech STEP7 テスト">
    <meta name="author" content="Takumi Sakiya(Tokyo Branch)">
    <title>@yield('title')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@100..900&display=swap" rel="stylesheet">

    {{-- 全ページ共通のCSS --}}
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    {{-- ページ固有のCSS --}}
    @yield('css')

    {{-- ページ固有のJS --}}
    @yield('js')
</head>

<body>
    <div class = "container">
        <header>
            <h1>@yield('title')</h1>
        </header>

        <main>
            @yield('search_box')
            @yield('content')
        </main>

        <footer>
            <form action = "{{ route('logout') }}" method = "POST">
                @csrf
                <button type = "submit" class = "btn btn-gray">ログアウト</button>
            </form>
        </footer>
    </div>
</body>

</html>