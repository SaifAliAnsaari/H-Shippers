$(document).ready(function() {
    $('#example').DataTable();
    $('#pl-close, .overlay').on('click', function() {
        $('#product-cl-sec').removeClass('active');
        $('.overlay').removeClass('active');
        $('body').toggleClass('no-scroll')
    });
});
$('.form-control').on('focus blur', function(e) {
        $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    })
    .trigger('blur');
$(".formselect").select2();
$('.sd-type').select2({
    createTag: function(params) {
        var term = $.trim(params.term);
        if (term === '') {
            return null;
        }
        return {
            id: term,
            text: term,
            newTag: true // add additional parameters
        }
    }
});