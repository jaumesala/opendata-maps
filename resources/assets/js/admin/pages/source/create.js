SITE.source.create = function(){

    console.log('create');

    // $('#confirmDelete').on('show.bs.modal', function (event) {
    //     var button  = $(event.relatedTarget) // Button that triggered the modal
    //     var action  = button.data('action') // Extract info from data-* attributes
    //     var id      = button.data('id') // Extract info from data-* attributes

    //     var modal = $(this)
    //     modal.find('form').attr('action', action);
    //     modal.find('input[name=id]').attr('value', id);
    // });

    var $select = $('.select2');
    // var $oldValues = $select.data('old').toString().split(",");
    $('.select2').css('width', '100%').select2({ minimumResultsForSearch: -1 });

    var oui = $('#origin_url');
    var oub = $('#origin_url_check');
    var ofs = $('#origin_format_static');
    var oss = $('#origin_size_static');

    oui.keyup(function(){
        if($(this).val()){
            oub.prop("disabled", false);
        } else {
            oub.prop("disabled", true);
        }
    });

    oub.click(function(e){
        e.preventDefault();

        var dataUrl = oui.val();
        var requestUrl = oub.data('url');

        if(dataUrl){
            // oub.prop("disabled", true);
            $(oub).find('.text').addClass('hidden');
            $(oub).find('.spin').removeClass('hidden');

            $.get(requestUrl, { 'origin_url' : dataUrl }, function(data, text, xhr){
                if(xhr.status == 200){
                    var size = data.data.fileSize;
                    var type = data.data.fileType;

                    ofs.text(type);
                    oss.text(size);
                }

                $(oub).find('.text').removeClass('hidden');
                $(oub).find('.spin').addClass('hidden');



            });
        }


    });

}