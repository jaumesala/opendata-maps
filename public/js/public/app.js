/* @preserve
 *
 * Author:  Jaume Sala
 * Website: jaumesala.net
 *
 */


/* ---------- SITE OBJECT ---------- */

SITE = {
    common: {
        init: function() {
            console.log('common');
        }
    },

    map: {
        init: function() {
            console.log('map');
        }
    },
}



/* ---------------------------------------------------------------------------------------------------- */
UTIL = {
    exec: function(controller, action) {
        var ns = SITE,
            action = (action === undefined) ? "init" : action;

        if (controller !== "" && ns[controller] && typeof ns[controller][action] == "function") {
            ns[controller][action]();
        }
    },

    init: function() {
        var body = document.body,
            controller = body.getAttribute("data-controller").trim(),
            action = body.getAttribute("data-action").trim();

        UTIL.exec("common");
        UTIL.exec(controller);
        UTIL.exec(controller, action);
    }
};
/* ---------------------------------------------------------------------------------------------------- */


//Let's go baby!
$(document).ready(UTIL.init);
SITE.map.show = function(){

    console.log('show');

    mapView.init();

    $('#button-info').click(function(){
        $('#map-info').addClass('show');
    });

    $('#close-panel').click(function(){
        $('#map-info').removeClass('show');
    });

}
//# sourceMappingURL=app.js.map
