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

    auth: {
        init: function() {
            console.log('auth');
        }
    },

    dashboard: {
        init: function() {
            console.log('dashboard');
        }
    },

    settings: {
        init: function() {
            console.log('settings');
        }
    },

    user: {
        init: function() {
            console.log('user');
        }
    },

    role: {
        init: function() {
            console.log('role');
        }
    },

    permission: {
        init: function() {
            console.log('permission');
        }
    },

    map: {
        init: function() {
            console.log('map');
        }
    },

    source: {
        init: function() {
            console.log('source');
        }
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