var Order = {

    removeOrder: function(orderId) {

        if (!confirm('Are You Sure, Want To Delete This Order ?')) {
            return false;
        }

        $.ajax({
            "url": "/order/" + orderId + "/removeOrder",
            "type": "delete",
            "success": function() {
                window.location.reload();
            },
            "error": function(jqXHR, exception) {
                console.log(jqXHR);
                var response = jqXHR.responseJSON;
                toastr.error(response.message != '' ? response.message : response.statusText);
            }
        })
    }
};