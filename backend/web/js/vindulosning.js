$(function () {

    let prop_ids = [];

    $(document).delegate("input[type = 'checkbox'][name = 'selection[]']", "change", function () {

        let property = {id: +$(this).val(), is_visible: +$(this).is(':checked')};
        let op_val;

        if (property.is_visible === 1) {
            op_val = 1;
            prop_ids.push(property.id);
        } else {
            op_val = 0.4;
            let index = prop_ids.indexOf(property.id);
            prop_ids.splice(index, 1);

        }

        $("button#link").attr("disabled", (prop_ids.length === 0));

        $(`tr[data-key='${property.id}']`).css({opacity: op_val});

        $.ajax({
            url: "/admin/vindulosning/change-visible",
            type: 'POST',
            data: {
                "property": property
            }
        });
    });

    $(document).delegate("#prt-select", "change", function (e) {
        e.preventDefault();
        let data = {};
            data[$(this).attr("name")] = $(this).val();
        $.ajax({
            type: 'GET',
            data: data,
            success: function (response) {
                if (response.visible) $("#property-visible").html(response.visible);
                else if (response.template) $("#property-template").html(response.template);
                prop_ids = [];
            }
        });
    })

    $("button#link").click(function (e) {
        e.preventDefault();
        $("#vindulosning-property_ids").val(prop_ids.join(", "))
        let serializeArray = $("form#vindulosning-form").serializeArray();

        $.ajax({
            type: 'POST',
            data: serializeArray,
            success: function (response) {

                let link = $("#vindulosning-link");
                link.attr("href", response).html(response);

                $("#tooltip-container").removeClass("d-none");

                $("#copy-link").on("click", function () {
                    let temp = $("<input>");
                    $("body").append(temp);
                    temp.val(link.attr("href")).select();
                    document.execCommand("copy");
                    temp.remove();
                    $("#myTooltip").html("Copied: " + link.attr("href"));
                });
            }
        });

    });

});