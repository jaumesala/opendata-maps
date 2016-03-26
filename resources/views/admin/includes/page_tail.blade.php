        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{ asset("js/vendor/jquery.js") }}"><\/script>')</script>

        <!-- Mapbox GL -->
        <script src='{!! setting_value('mapbox', 'glScript') !!}'></script>
        <!-- Turf -->
        <script src='{!! setting_value('mapbox', 'turfScript') !!}'></script>


        @if (App::environment() != 'production')
            <script src="{{ asset('js/admin/plugins.js') }}"></script>
            <script src="{{ asset('js/admin/app.js') }}"></script>
        @else
            <script src="{{ asset('js/admin/plugins.min.js') }}"></script>
            <script src="{{ asset('js/admin/app.min.js') }}"></script>
        @endif

    </body>
</html>