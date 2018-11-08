$(document).ready(function () {
    $(".product-quantity").on('change',function(e) {
        var product_id = e.target.getAttribute("product-id");
        $("#update-"+product_id).css("display","inline-block");
    });


    $(".btn-product-delete").on('click',function(e) {
        var product_id = e.target.getAttribute("product-id");

        $(this).html('<i class="fa fa-circle-o-notch fa-spin"></i> Deleting');

        $.ajax({
            url: '/pub/cart/delete',
            type: 'POST',
            dataType: 'json',
            data: {product_id: product_id}
        })
        .done(function (response) {
            if (response['result'] == 'success') {
                $(".header-customer .cart_num").html(response['cart_total']);
                //alert("Success");
            } else {
                //alert("Error");
            }

            $("#delete-"+product_id).html('Delete');
            $("#row-product-"+product_id).remove();
        })
        .fail(function (err) {
            console.log(err);
        });
    });

    $(".btn-product-update").on('click',function(e) {
        var product_id = e.target.getAttribute("product-id");
        var quantity = $("#quantity-"+product_id).val();

        $(this).html('<i class="fa fa-circle-o-notch fa-spin"></i> Saving');

        $.ajax({
            url: '/pub/cart/update',
            type: 'POST',
            dataType: 'json',
            data: {product_id: product_id, quantity: quantity}
        })
        .done(function (response) {
            if (response['result'] == 'success') {
                $(".header-customer .cart_num").html(response['cart_total']);
                //alert("Success");
            } else {
                //alert("Error");
            }

            $("#update-"+product_id).html('Save');
            $("#update-"+product_id).css("display","none");
        })
        .fail(function (err) {
            console.log(err);
        });
    });
});