        <?php
            if(App::environment() != 'production')
                $min = '';
            else
                $min = '.min';
        ?>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery{{ $min }}.js"></script>
        <script>window.jQuery || document.write('<script src="{{ asset("js/vendor/jquery".$min.".js") }}"><\/script>')</script>

        <!-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css"> -->
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui{{ $min }}.js"></script>
        <script>window.jQuery.ui || document.write('<script src="{{ asset("js/vendor/jquery-ui".$min.".js") }}"><\/script>')</script>

        <!-- Mapbox GL -->
        <script src='{!! setting_value('mapbox', 'glScript') !!}'></script>
        <!-- Turf -->
        <script src='{!! setting_value('mapbox', 'turfScript') !!}'></script>

        <script>
            var env = {!! $environment or '{}' !!}
        </script>

        @stack('preAppScripts')

        <script src="{{ asset('js/admin/plugins'.$min.'.js') }}"></script>
        <script src="{{ asset('js/admin/app'.$min.'.js') }}"></script>

        @stack('postAppScripts')

    </body>
</html>