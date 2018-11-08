$(document).ready(function () {
    $(".product-quantity").on('change',function(e) {
        var product_id = e.target.getAttribute("product-id");
        $("#update-"+product_id).css("display","inline-block");
    });

    $(".btn-product-delete").on('click',function(e) {
        var product_id = e.target.getAttribute("product-id");
    });

    $(".btn-product-update").on('click',function(e) {
        var product_id = e.target.getAttribute("product-id");
        var quantity = $("#quantity-"+product_id).val();

        $(this).html('<i class="fa fa-circle-o-notch fa-spin"></i> Saving');
        return;
        $.ajax({
            url: '/pub/cart/update',
            type: 'POST',
            dataType: 'json',
            data: {product_id: product_id, quantity: quantity}
        })
            .done(function (response) {
                if (response == 'success') {
                    showAlert("Success");
                } else {
                    showAlert("Error");
                }

                $(this).html('Save');
                $(this).css("display","none");
            })
            .fail(function (err) {
                console.log(err);
            });
    });
});