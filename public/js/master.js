$(document).ready(function() {
    $('#example').DataTable();
    $('#pl-close, .overlay').on('click', function() {
        $('#product-cl-sec').removeClass('active');
        $('.overlay').removeClass('active');
        $('body').toggleClass('no-scroll')
    });

    var notif_ids = [];
    $(document).on('click', '#NotiFications', function(){
        $('.notifications_list').each(function (){
            notif_ids.push($(this).attr('id'));
        });
        

        $.ajax({
        type: 'POST',
        url: '/read_notif_four',
        data: {
            _token: $('input[name="_token"]').val(),
            notif_ids: notif_ids
        },
        success: function (response) {
            var response = JSON.parse(response);
            console.log(response);
        }
        });
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