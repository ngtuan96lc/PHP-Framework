$(function () {
    /**
     * Function save product
     */
    $('button.save-product').click(function() {
        let productName = $('#productName').val();
        let sku = $('#sku').val();
        let quantity = $('#quantity').val();

        $.ajax({
            type: "POST",
            url: location.origin + "/product/add/",
            data: {
                productName: productName,
                sku: sku,
                quantity: quantity
            },
            success: function (response) {
                let result = JSON.parse(response);
                if (result['entityId']) {
                    let newProductRow = '<tr id="' + result.entityId + '"><th scope="row">' + result.entityId + '</th><td>' + result.name + '</td><td><b><i> ' + result.sku + ' </i></b></td> <td> ' + result.quantity + ' </td> <td> <button class="edit-product btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-name="' + result.name + '" data-product-id="' + result.entityId + '" data-product-sku="' + result.sku + '" data-product-quantity="' + result.quantity + '">Edit</button> <button class="delete-product btn btn-danger" data-product-name="' + result.name + '" data-product-id="' + result.entityId + '">Delete</button> </td> </tr>';
                    $('#product-listing tbody').append(newProductRow);

                    let message = 'The product named <b>' + result.name + '</b> is added successfully\n';
                    let type = 'success';
                    notices(type, message);
                } else {
                    /* Handle something when occurs error */
                }
            }
        });
    });

    /**
     * Function notices
     * Define types: success, info, warning, danger, primary, secondary, light, dark
     *
     * @param type
     * @param message
     */
    function notices(type, message) {
        let noticesTarget = $('.notices');
        if (noticesTarget.length > 0) {
            noticesTarget.html(message);
        } else {
            $('header').append('<div class="notices alert alert-' + type + '" role="alert"> ' + message + ' </div>');
        }
    }

    /**
     * Function delete product
     */
    $('#product-listing').on("click", "button.delete-product", function () {
        let self = $(this);
        let productId = self.attr('data-product-id');
        let productName = self.attr('data-product-name');

        $.ajax({
            type: "POST",
            url: location.origin + "/product/deleteAjax/",
            data: {
                productId: productId
            },
            success: function (response) {
                let message = '';
                if (response) {
                    let whichTr = self.closest('tr');
                    whichTr.remove();
                    message = "The chosen product named <b>" + productName +  "</b> was deleted successfully";
                } else {
                    message = "Error is occurred ...";
                }

                let type = 'success';
                notices(type, message);
            }
        });
    });

    /**
     * Push current row data into Popup Modal
     */
    $('#product-listing').on("click", "button.edit-product", function () {
        let self = $(this);
        let productId = self.attr('data-product-id');
        let productName = self.attr('data-product-name');
        let sku = self.attr('data-product-sku');
        let quantity = self.attr('data-product-quantity');

        $('#editProductModal h5#editProductModalLabel').html("Edit product: " + productName);

        $('#editProductModal input#product-id-modal').val(productId);
        $('#editProductModal input#product-name-modal').val(productName);
        $('#editProductModal input#product-sku-modal').val(sku);
        $('#editProductModal input#product-quantity-modal').val(quantity);
    });

    /**
     * Save product when submit editing
     */
    $('#editProductModal').on("click", "button.save-product", function () {
        let productId = $('#editProductModal input#product-id-modal').val();
        let productName = $('#editProductModal input#product-name-modal').val();
        let sku = $('#editProductModal input#product-sku-modal').val();
        let quantity = $('#editProductModal input#product-quantity-modal').val();

        $.ajax({
            type: "POST",
            url: location.origin + "/product/editAjax/",
            data: {
                productId: productId,
                productName: productName,
                sku: sku,
                quantity: quantity
            },
            success: function (response) {
                let result = JSON.parse(response);
                if (result['entityId']) {
                    let whichTr = $('#product-listing tbody tr[id=' + result.entityId + ']');
                    let indexTr = whichTr.index();
                    whichTr.remove();

                    let updateProductRow = '<tr id="' + result['entityId'] + '">' +
                        '<th scope="row">' + result.entityId + '</th>' +
                        '<td>' + result.name + '</td><td><b><i> ' + result.sku + ' </i></b></td>' +
                        '<td> ' + result.quantity + ' </td>' +
                        '<td>' +
                        '<button class="edit-product btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-name="' + result.name + '" data-product-id="' + result.entityId + '" data-product-sku="' + result.sku + '" data-product-quantity="' + result.quantity + '">Edit</button>' +
                        ' <button class="delete-product btn btn-danger" data-product-name="' + result.name + '" data-product-id="' + result.entityId + '">Delete</button>' +
                        '</td>' +
                        '</tr>';
                    $('#product-listing tbody tr').eq(indexTr - 1).after(updateProductRow);

                    let message = 'The product named <b>' + result.name + '</b> is updated successfully\n';
                    let type = 'success';
                    notices(type, message);

                    $('#editProductModal').modal('hide');
                } else {
                    /* Handle something when occurs error */
                }
            }
        });
    });
});