function getSlugName(value) {
    if (value.trim() == null)
        return false;

    $.ajax({
        "url": "/admin/product/get_slug_name",
        "type": "post",
        "data": {
            "name": value
        },
        "success": function(data) {
            $("#input-slug_name").val(data.slug_name);
        },
        "error": function(jqXHR, exception) {
            if (jqXHR.status == 422) {
                alert('Value is not valid');
            } else {
                alert('Something went wrong, please try again later');
            }
        }
    })
}