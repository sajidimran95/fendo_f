<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'fendo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: Inter, sans-serif; background: #f7f8f5; }
        .phone { max-width: 430px; margin: 0 auto; min-height: 100vh; background: #fff; position: relative; box-shadow: 0 0 40px rgba(0,0,0,.06); }
        .green { background: #6DB33F; }
        .green-text { color: #6DB33F; }
        .curve { border-bottom-left-radius: 28px; border-bottom-right-radius: 28px; }
        .pill { border-radius: 999px; }
    </style>
</head>
<body>
<div class="phone">
    @yield('content')
</div>
</body>
</html>
