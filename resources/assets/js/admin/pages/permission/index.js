SITE.permission.index = function(){

    console.log('index');

    $('#confirmDelete').on('show.bs.modal', function (event) {
        var button  = $(event.relatedTarget) // Button that triggered the modal
        var action  = button.data('action') // Extract info from data-* attributes
        var id      = button.data('id') // Extract info from data-* attributes

        var modal = $(this)
        modal.find('form').attr('action', action);
        modal.find('input[name=id]').attr('value', id);
    });

}