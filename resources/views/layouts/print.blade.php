<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Nota')</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            color: #000;
            max-width: 380px;
            margin: 20px auto;
            padding: 0 10px;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .fs-lg { font-size: 16px; }
        hr { border: none; border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 2px 0; vertical-align: top; }
        .no-print { margin-top: 16px; }

        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    @yield('content')

    <div class="no-print text-center">
        <button onclick="window.print()">🖨️ Cetak Nota</button>
        <button onclick="window.close()">Tutup</button>
    </div>

</body>
</html>