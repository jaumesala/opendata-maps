SITE.role.create = function(){

    console.log('create');

    var $select = $('.select2');
    var $oldValues = $select.data('old').toString().split(",");
    $('.select2').css('width', '100%').select2().val($oldValues).trigger("change");

}