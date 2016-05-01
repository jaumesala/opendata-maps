        <?php
            if(App::environment() != 'production')
                $min = '';
            else
                $min = '.min';
        ?>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery{{ $min }}.js"></script>
        <script>window.jQuery || document.write('<script src="{{ asset("js/vendor/jquery".$min.".js") }}"><\/script>')</script>

        <!-- Mapbox GL -->
        <script src='{!! setting_value('mapbox', 'glScript') !!}'></script>
        <!-- Turf -->
        <script src='{!! setting_value('mapbox', 'turfScript') !!}'></script>

        <script>
            var env = {!! $environment or '{}' !!}
        </script>

        @stack('preAppScripts')

        <script src="{{ asset('js/public/plugins'.$min.'.js') }}"></script>
        <script src="{{ asset('js/public/app'.$min.'.js') }}"></script>

        @stack('postAppScripts')

    </body>
</html>