<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/utama/g21-icon.ico') }}" />
    <title>Dashboard | L21</title>
    <link rel="stylesheet" href="/assets/style.css" />
    <link rel="stylesheet" href="/assets/design.css" />
    {{-- <link rel="stylesheet" href="/assets/custom_dash.css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            adjustElementSize();
        });
    </script>

    {{-- CDN SELECT MULTIPLE--}}
    <link href="/assets/select-assets/select2.min.css" rel="stylesheet" />
    <script src="/assets/select-assets/select2.min.js"></script>
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

<body>
    <div class="sec_container_utama">
        <div class="sec_sidebar" id="sec_sidebar">
            @include('layouts.side_nav')
        </div>
        <div class="sec_groupmain">
            <div class="sec_top_navbar">
                @include('layouts.top_nav')
            </div>
            <div class="sec_main_konten">
                <div class="title_main_content">
                    <h3>Welcome!</h3>
                </div> 
                <div class="content_body">
                    <div class="aplay_code">
                        @yield('container')
                    </div>
                    <div class="footer" id="footer">
                        <span>© Copyright 2024 Global Bola All Rights Reserved.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script> --}}
    <script src="/assets/script.js"></script>
    <script src="/assets/design.js"></script>
    <script src="/assets/component.js"></script>

</body>

</html>
