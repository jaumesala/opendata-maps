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
            
        }
    },

    home: {
        init: function() {
            console.log('home');
        }
    },

    neighborhoods: {
        init: function() {
            console.log('neighborhoods');
        }
    complains: {
        init: function() {
            console.log('complains');
        }
    },
    }

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
            controller = body.getAttribute("data-controller"),
            action = body.getAttribute("data-action");

        UTIL.exec("common");
        UTIL.exec(controller);
        UTIL.exec(controller, action);
    }
};
/* ---------------------------------------------------------------------------------------------------- */


//Let's go baby!
$(document).ready(UTIL.init);