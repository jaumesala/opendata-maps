SITE.map.create = function(){

    console.log('create');

    // var $select = $('.select2');
    // $select.css('width', '100%').select2({ minimumResultsForSearch: -1 });
    // var $oldValues = $select.data('old').toString().split(",");
    // $('.select2').css('width', '100%').select2().val($oldValues).trigger("change");

    $window = $(window);
    $mapView = $('#map-view');
    $controlsView = $('#controls-view');

    $mapView.height($window.height() - 195);
    $controlsView.height($window.height() - 175);

    $window.resize(function() {
        $mapView.height($window.height() - 195);
        $controlsView.height($window.height() - 175);
    });

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

    Vue.directive('select2', {
        twoWay: true,
        priority: 1000,
        bind: function () {
            $(this.el)
                .css('width', '100%')
                // .select2({ minimumResultsForSearch: -1 })
                .select2($(this.el).data('options'))
                .on("select2:select", function(e) {
                    this.set($(this.el).val());
                }.bind(this));
        },
        update: function(nv, ov) {
            $(this.el).trigger("change");
        },
        unbind: function () {
            $(this.el).off().select2('destroy')
        }
    });



    $mapObject = {
        id: null,
        name: '',
        description: '',
        status: 'public',
        tags: []
    }


    var mapCreator = new Vue({
        el: '#map-creator',
        data: {
            map: $mapObject,
            errors: null
        },

        methods : {
            saveData: function(){
                // console.log(this.map);
                this.$http.post('/admin/map', this.map)
                    .then(
                        function(response){
                            console.log(response);
                        }, function (response) {
                            this.errors = response;
                        }
                    );
            }
        }
    });


}