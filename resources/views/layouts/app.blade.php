<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Products Demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
<header>
    <h1><a href="{{ route('products.index') }}">Product & Reviews Demo</a></h1>
    <nav>
        <a href="{{ route('products.create') }}">Create Product</a>
    </nav>
    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
</header>

<main>
    @yield('content')
</main>

</body>
</html>
