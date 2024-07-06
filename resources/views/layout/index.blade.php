<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta http-equiv="Content-Security-Policy" content="default-src * 'self' 'unsafe-inline' 'unsafe-eval' data: gap:">

    <link rel="icon" href="{{ asset('img/logo.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700;800;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Fexa</title>
    <link rel="stylesheet" href="{{ asset('buzzle') }}/css/framework7.bundle.css">
    <link rel="stylesheet" href="{{ asset('buzzle') }}/css/style.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <div class="view view-main view-init ios-edges" data-url="/">
        <div class="page page-home page-with-subnavbar">

            @include('layout.menu')

            <div class="tabs bg-black">
                <div id="tab-home" class="tab tab-home tab-active">
                    <!-- ===== TAB HOME ===== -->
                    <div class="pb-5">
                        @yield('content')
                    </div>
                    <!-- ===== END TAB HOME ===== -->
                </div>

            </div>

        </div>
    </div>


    <!-- script -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- end script -->
    <script>
        function cpy() {
            $('.btn-cpy').click(function() {
                var text = $(this).data('link');
                if (navigator.share) {
                    navigator.share({
                        text: text
                    }).catch(console.error);
                } else {
                    // Fallback for browsers that don't support the Web Share API
                    navigator.clipboard.writeText(text).then(function() {
                        alert('Teks berhasil disalin!');
                    }, function(err) {
                        alert('Gagal menyalin teks: ', err);
                    });
                }
            });
        }
        cpy()
    </script>
    @stack('script')
</body>

</html>