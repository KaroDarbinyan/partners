$(function () {
    let compareContainer = [];
    $('#listing').on("click", ".ed-check", function () {
        let checked = $(this).find("span[data-checked-id]");
        let ed_id = $(this).data("id");
        let eiendom = $(this).next().find("figure");
        let src = eiendom.find("img").attr("src");
        let title = eiendom.find("h3").text();
        if (!compareContainer.includes(ed_id)) {
            $("<div>", {
                "class": "collapse-card",
                "data-card-id": ed_id,
                "append": $("<div>", {
                    "append": $("<div>", {
                        "class": "col-img",
                        "append": $("<img>", {
                            "src": src,
                        })
                    }).add($("<p>", {
                        "class": "col-title",
                        "text": title
                    })),
                }).add($("<span>", {
                    "class": "col-x",
                    "text": "x",
                    "data-remove-id": ed_id,
                    "on": {
                        "click": function () {
                            removeChecked(ed_id);
                        }
                    }
                }))
            }).appendTo("#collapse-body");
            compareContainer.push(ed_id);
            checked.addClass("ed-checked");
            $("#compare-count").html(compareContainer.length);
            if (compareContainer.length > 1) {
                $("#sammenlign").removeClass("fade").prop('disabled', false);
            }
        } else {
            removeChecked(ed_id);
        }

        if (compareContainer.length === 0) {
            $("#compare-collapse").addClass("fade");
        } else {
            $("#compare-collapse").removeClass("fade");
        }
    });

    function removeChecked(id) {
        let checked = $(`.ed-check[data-id=${id}]`);
        checked.find("span[data-checked-id]").removeClass("ed-checked");
        compareContainer.splice(compareContainer.indexOf(id), 1);
        $("#compare-count").html(compareContainer.length);
        $("#collapse-body").find(`div[data-card-id=${id}]`).hide('slow', function () {
            $(this).remove();
        });
        if (compareContainer.length < 2) {
            $("#sammenlign").addClass("fade").prop('disabled', true);
        }
    }


    $(".collapse-toggle .pull-left").click(function (e) {
        e.preventDefault();
        $(this).parent().toggleClass("collapse-active").find("span").toggleClass("caret-up");
        $(this).find("span").toggleClass("caret-up");
        $('#collapse-body').toggle("slow");
    });

    $("#sammenlign").click(function () {
        $.ajax({
            url: "/compare/compare",
            type: "GET",
            data: {
                "ids": compareContainer
            },
            success: function (response) {
                $("body").css({overflowY: "hidden"});
                $(document).on("click", ".fancybox-item.fancybox-close", function () {
                    $("body").css({overflowY: "unset"});
                });
                $("#compare-modal").html(response);
                $("a[data-open-modal]").click();
            }
        })
    })

});
