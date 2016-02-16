        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{ asset("js/vendor/jquery.js") }}"><\/script>')</script>
        
        <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.14.1/mapbox-gl.js'></script>
        {{-- // <script src="https://www.google.com/recaptcha/api.js?hl={{ LaravelLocalization::getCurrentLocale() }}" async defer></script> --}}

        @if (App::environment() != 'production')
            <script src="{{ asset('js/plugins.js') }}"></script>
            <script src="{{ asset('js/main.js') }}"></script>
        @else
            <script src="{{ asset('js/plugins.min.js') }}"></script>
            <script src="{{ asset('js/main.min.js') }}"></script>
        @endif

        @if (App::environment() == 'production')
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-SUKI-BASE','auto');ga('send','pageview');
        </script>
        @endif
    </body>
</html>