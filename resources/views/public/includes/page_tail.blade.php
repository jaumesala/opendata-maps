        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{ asset("js/vendor/jquery.js") }}"><\/script>')</script>

        <!-- iCheck -->
        <!-- <script src="../../plugins/iCheck/icheck.min.js"></script> -->

        <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.14.1/mapbox-gl.js'></script>

        <script src='https://api.mapbox.com/mapbox.js/plugins/turf/v2.0.2/turf.min.js'></script>

        <!-- <script src='https://api.mapbox.com/mapbox.js/v2.3.0/mapbox.js'></script> -->
        <!-- <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.2.0/leaflet-omnivore.js'></script> -->

        @if (App::environment() != 'production')
            <script src="{{ asset('js/plugins.js') }}"></script>
            <script src="{{ asset('js/main.js') }}"></script>
        @else
            <script src="{{ asset('js/plugins.min.js') }}"></script>
            <script src="{{ asset('js/main.min.js') }}"></script>
        @endif
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
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