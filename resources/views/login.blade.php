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


            <div class="tabs">
                <div id="tab-home" class="tab tab-home tab-active">
                    <!-- ===== TAB HOME ===== -->
                    <div class="pb-5 ">
                        <div class="page bg-black">
                            <div class="navbar navbar-transparent">
                                <div class="navbar-bg"></div>
                                <div class="navbar-inner sliding">
                                    <div class="left">
                                        <a class="link back">
                                            <i class="icon icon-back"></i>
                                        </a>
                                    </div>
                                    <div class="title">Sign In</div>
                                </div>
                            </div>
                            <div class="page-content">

                                <!-- separator -->
                                <div class="separator-large"></div>
                                <!-- end separator -->

                                <!-- sign in -->
                                <div class="sign-in">
                                    <div class="content text-center">
                                        <img class="image-illustration" src="{{ asset('img/logo.png') }}" alt="">
                                        <h3 class="text-white">Welcome To Fexa!!!</h3>
                                    </div>

                                    <!-- separator -->
                                    <div class="separator-large"></div>
                                    <!-- end separator -->

                                    <div class="content-form">
                                        <form class="list" method="post" action="{{ route('login.auth') }}">
                                            @csrf
                                            <ul>
                                                <li class="item-content item-input">
                                                    <div class="item-inner">
                                                        <div class="item-input-wrap">
                                                            <input type="text" placeholder="Wallet Address" name="username">
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="item-content item-input">
                                                    <div class="item-inner">
                                                        <div class="item-input-wrap">
                                                            <input type="password" placeholder="Password" name="password">
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="button-default ">
                                                <div class="container">
                                                    <button class="button bg-blue-500 text-black">Sign In</button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- separator -->
                                        <div class="separator-medium"></div>
                                        <!-- end separator -->

                                        <div class="link-forgot text-center text-small">
                                            <a href="#" class="">Forgot Password?</a>
                                        </div>

                                    </div>
                                </div>
                                <!-- end sign in -->

                                <!-- separator -->
                                <div class="separator-large"></div>
                                <!-- end separator -->

                            </div>
                        </div>



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
            $('.btn-cpy').click(async function() {
                var text = $(this).data('link');
                const shareData = {
                    text: text
                };
                await navigator.share(shareData);
            });
        }
        cpy()
    </script>
    @include('sweetalert::alert')
</body>

</html>