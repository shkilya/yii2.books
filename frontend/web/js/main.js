$(document).ready(function () {
    $("[data-fancybox]").fancybox({});


    $(document).on('click','.view-book',function () {
        var  $self = $(this);
        var book_id =$self.data('book_id');
        $.ajax({
            method:'GET',
            url:'/book/view-popup/'+book_id,
            success:function (data) {
                $('#BookModalContent').html(data);
                $('#BookModal').modal('show');
            }
        })
    })
});