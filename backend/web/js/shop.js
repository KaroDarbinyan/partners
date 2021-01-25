$(function () {
    let fullScreenEvent = false;
    let unitegallery = $("#gallery")
        .removeClass("d-none")
        .unitegallery({
            gallery_width: 1170,
            gallery_height: 780,
            gallery_mousewheel_role: 'none',
            slider_zoom_max_ratio: 2,
            slider_scale_mode: 'fit',
            theme_hide_panel_under_width: 5000,
            slider_enable_fullscreen_button: false,
            slider_enable_text_panel: true,
            slider_textpanel_padding_top: 30,
            slider_textpanel_padding_bottom: 30,
            slider_textpanel_enable_title: false
        });


    $('body').on('click', '#gallery .ug-item-wrapper', function (e) {
        if (!fullScreenEvent) {
            $('#gallery').addClass('full-screen');
            unitegallery.enterFullscreen();
        } else {
            if (e.pageX > 600) {
                unitegallery.nextItem();
            } else {
                unitegallery.prevItem();
            }
        }
    });

    unitegallery.on("resize", function () {				//on gallery resize
        if (fullScreenEvent) {
            fullScreenEvent = false;
        } else {
            fullScreenEvent = true;
        }
    });
});

$(function () {

    $("form#kart").submit(function (e) {

        let input = $("#shopproduct-pictures");
        let fileManager = input.data("fileinput").fileManager;
        let files = [];

        let loadedStack = fileManager.stack;
        for (let key in loadedStack) {
            files.push(loadedStack[key].file);
        }

        input[0].files = new FileListItem(files);
    });

    $("span[data-category-link]").popover();


    $("a[data-buy-id]").click(function (e) {
        let basketListCountCont = $("#basketListCountCont");
        let product_id = $(this).data("buy-id");
        let count = $(`input.prodCount[data-id=${product_id}]`).val();
        let element = $(this);
        $.ajax({
            url: `/admin/shop/add-to-basket?product_id=${product_id}&count=${count}`,
            success: function (response) {
                if (response.success) {
                    basketListCountCont.removeClass("d-none").data("count", response.count).html(response.count);
                    kjopeModal(element);
                }
            }
        });
    });

    $('#basket-table a[data-href]').click(function () {
        if (confirm('Are you sure you want to delete this?')) {
            let id = $(this).data('id');
            $.ajax({
                url: $(this).data('href'),
                success: function () {
                    $(`#basket-table tr[data-key=${id}]`).remove();
                    changeAttributes();
                }
            });
        }

    });

    $('#basket-table .minus, #basket-table .plus').click(function () {
        let product_count = $(`.product-count[data-id=${$(this).data('id')}]`);
        let product_price_sum = $(`.product-price-sum[data-id=${$(this).data('id')}]`);


        if (product_count.data('count') > 1 || ($(this).hasClass('plus') && product_count.data('count') === 1)) {
            let count = product_count.data('count');


            count = $(this).hasClass('minus') ? --count : ++count;
            product_count.data('count', count);
            product_count.html(count);
            let price_sum = product_price_sum.data('price') * count;

            $(`input[type=hidden][data-basket-id="${$(this).data('id')}"]`).val(count).data("sum", price_sum);
            product_price_sum.data("price-sum", price_sum).html(priceFormat(price_sum));
            changeAttributes();
            changeBasketCount($(this).data('id'), count);
        }
    });

    $("span[data-change]").click(function () {
        let productCount = $(`input.prodCount[type=number][data-id=${$(this).data("id")}]`);
        let mode = $(this).data("change");
        let productCountVal = +productCount.val();
        if (mode === 'up') {
            productCount.val(productCountVal + 1);
        }

        if (mode === 'down') {
            if (productCountVal > 1) {
                productCount.val(productCountVal - 1);
            }
        }
        changePrices($(this).data("id"))
    });

    let send = false;
    $("#shopOnlineBaskForm").on('submit keyup keypress', function (e) {

        let keyCode = e.keyCode || e.which;
        if (keyCode === 13 && send) {
            $("#shop-modal").modal('hide');
            return false;
        }
        if (e.type === "submit") {
            e.preventDefault();
            e.stopImmediatePropagation();

            let serializeArray = $(this).serializeArray();
            $("input[type=hidden][data-id]").each(function (i) {
                serializeArray.push({
                    name: `products[${$(this).data("id")}]`,
                    value: [$(this).val(), $(this).data("sum")]
                });
            })

            $.ajax({
                url: $(this).attr("action"),
                data: serializeArray,
                method: 'POST',
                success: function (response) {
                    $("#shop-modal-title").html(response.title);
                    $("#shop-modal-body").html(response.body);
                    $("#shop-modal").modal('show')
                        .on('hidden.bs.modal', function () {
                            if (response.status === "success") {
                                window.location.href = response.url;
                            }
                        });
                }
            });
            send = true;
        }
    });

    $("input.prodCount[type=number][data-id]").on("input", function (e) {
        if ($(this).val() < 1) $(this).val(1);
        changePrices($(this).data("id"))
    })

    function changePrices(productId) {
        let countOfProd = $(`input.prodCount[type=number][data-id=${productId}]`);
        let singleProductPrice = $(`span.single-product-price[data-id=${countOfProd.data("id")}][data-price]`);
        let countOfProdVal = +countOfProd.val();

        countOfProd.val(countOfProdVal);
        singleProductPrice.html(priceFormat(singleProductPrice.data("price") * countOfProdVal));
    }

    function priceFormat(price) {
        return price.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1 ');
    }

    function changeAttributes() {
        let basketListCountCont = $("#basketListCountCont");
        let basketCount = $("tr[data-key]").length;

        let general_sum = 0;
        $(".product-price-sum[data-price]").each(function () {
            general_sum += $(this).data("price-sum");
        });

        $("#general-sum").html(priceFormat(general_sum));

        basketListCountCont.data("count", basketCount).html(basketCount)

        if (basketCount === 0) basketListCountCont.addClass("d-none");
    }

    function changeBasketCount(id, count) {
        $.ajax({
            url: `/admin/shop/basket-edit?id=${id}&count=${count}`,
            success: function (response) {
            }
        });
    }

    function kjopeModal(element) {
        $("div.kjope-modal").remove();
        $(document.body).click(function (e) {
            if (!e.target.hasAttribute("data-buy-id")) {
                $("div.kjope-modal").remove();
            }
        });

        $("<div>", {
            class: "kjope-modal rounded",
            append: $('<div>', {
                class: "row",
                append: $('<p>', {
                    text: 'Varet ditt er lagt til.',
                    class: "text-center h3 pt-2 w-100"
                })
            }).add($('<div>', {
                class: "row pt-2",
                append: $("<div>", {
                    class: "col-md-6 col-6",
                    append: $('<button>', {
                        text: "Fortsette å handle",
                        class: "btn btn-sm btn-default font-weight-bold",
                        on: {
                            click: function () {
                                $(this).closest("div.kjope-modal").remove();
                            }
                        },
                    })
                }).add("<div>", {
                    class: "col-md-6 col-6",
                    append: $('<button>', {
                        html: "Gå til kurven <i class='fas fa-shopping-cart text-white'></i>",
                        class: "btn btn-sm btn-danger font-weight-bold float-right",
                        data: {
                            href: $("#basketListCountCont").parent().attr("href")
                        },
                        on: {
                            click: function () {
                                window.location.href = $(this).data("href");
                            }
                        },
                    })
                })
            }))
        })
            .appendTo(element.closest(".row").find("div.kjope_modal"))
            .animate({"opacity": "show", top: "-100"}, 500)
    }

    // Used for creating a new FileList in a round-about way
    function FileListItem(a) {
        a = [].slice.call(Array.isArray(a) ? a : arguments)
        for (var c, b = c = a.length, d = !0; b-- && d;) d = a[b] instanceof File
        if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
        for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(a[c])
        return b.files
    }

});


