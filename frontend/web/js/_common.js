$.blockUI.defaults.message = null;

$(document)
    .ajaxStart($.blockUI)
    .ajaxStop($.unblockUI);

$(document).ready(function () {

    $('.styler').styler();

    // Поп-ап

    if (location.hash.includes('be_om_salgssum')) {
        location.hash = 'salgssum';
    }

    let formAction = document.querySelector('.popup[href="' + location.hash + '"]');

    if (formAction) {
        setTimeout(function() {
            formAction.click();
        }, 1);
    }

    $(document).on('click', '.popup', function () {
        $.fancybox({
            padding: 0,
            href: $(this).attr('href'),
            helpers: {
                overlay: {
                    locked: false,
                    closeClick: false
                }
            },
            afterClose: function () {
                history.pushState('', document.title, location.pathname + location.search);
            }
        });
    });

    $('.vd_btn').click(function (e) {
        e.preventDefault();
        $(this).closest('.VERDIVURDERING').toggleClass('active');
    });

    $('.btn_nav').click(function (e) {
        if ($(window).width() <= 1230) {
            e.preventDefault();
            $(this).next().slideToggle(200);
        }
    });

    $('nav > ul > li > a').click(function (e) {
        if ($(this).parent().hasClass('nosub') == false) {
            if ($(window).width() <= 1230) {
                e.preventDefault();

                $('nav > ul > li > ul').slideUp();

                $(this).next().slideToggle(200);
            }
        }
    });

    $('.fc_val > a').click(function (e) {
        if ($(this).parent().hasClass('nosub') == false) {
            if ($(window).width() <= 1230) {
                e.preventDefault();
                $(this).next().slideToggle(200);
            }
        }
    });

    // подпунк в выпадающем фильтре
    $('.fc_val > ul > li > label  input[type="checkbox"]').on('change', function () {
        if (this.checked) {
            $(this).closest('li').find('ul').slideDown(200);
        } else {
            $(this).closest('li').find('ul').slideUp(200);
        }
    });

    // Табы
    $('.tb_nav > li > a').click(function (e) {
        if ($(this).hasClass('not_tab') == false) {
            e.preventDefault();
            $('.tb_nav > li').removeClass('active');
            $(this).parent().addClass('active');
            var index = $(this).parent().index();
            $('.tb_val > li').removeClass('active');
            $('.tb_val > li').eq(index).addClass('active');
        }
    });

    // подпунк в выпадающем фильтре
    $('.pd_nav.for_content > li > a').click(function (e) {
        e.preventDefault();
        $('.pd_nav.for_content > li').removeClass('active');
        $(this).parent().addClass('active');
    });
    $('.acordion > li').append('<i class="after-li"></i>');

    // Акордион
    $('.acordion > li > a, .acordion > li > .after-li').click(function (e) {
        e.preventDefault();
        let acordionText = $(this).parent().find('>div');
        if ($(this).parent().hasClass('active') == false) {
            $('.acordion > li').removeClass('active');
            $(this).parent().addClass('active');
            var index = $(this).parent().index();
            $('.acordion > li > div').slideUp(200);
            acordionText.slideDown(200);
        } else {
            $('.acordion > li').removeClass('active');
            acordionText.slideUp(200);
        }
    });

    if ($('.product_doc').length > 0) {
        const $navigation = $('.pd_nav.for_content li');
        const $sections = $('.product_doc h3');

        $(window).scroll(function () {
            let scrollDistance = $(window).scrollTop();

            $sections.each(function(i) {
                if ($(this).position().top - 100 <= scrollDistance) {
                    $navigation.removeClass('active')
                        .eq(i)
                        .addClass('active');
                }
            });

            /*var $sections = $('.product_doc h3');
            $sections.each(function (i, el) {
                var top = $(el).offset().top;
                var bottom = top + $(el).height();
                var scroll = $(window).scrollTop();
                if (scroll > top && scroll < bottom) {
                    var id = i;
                    $('.pd_nav.for_content > li').removeClass('active');
                    $('.pd_nav.for_content a[href="#header' + id + '"]').parent().addClass('active');
                    return false;
                }
            })*/
        }).scroll();

        $(".pd_nav.for_content").on("click", "a", function (e) {
            e.preventDefault();
            var id = $(this).parent().index();
            var $sections = $('.product_doc h3');
            $sections.each(function (i, el) {
                if (i == id) {
                    top2 = $(this).offset().top;
                    $('body,html').animate({scrollTop: top2 - $('header').outerHeight() - 20}, 600);
                }
            });
        });
    }

    /*$(".for_ekspander").on("click", "a", function (e) {
        e.preventDefault();
        $('.nabolagsprofil').toggleClass('open');
    });*/

    $(".pt_title").on("click", function (e) {
        e.preventDefault();
        if ($(this).closest('.pt_town').hasClass('open') === false) {
            $(".pt_body").slideUp(200);
            $('.pt_town').removeClass('open');
        }
        $(this).next().slideToggle(200);
        $(this).closest('.pt_town').toggleClass('open');
    });

    $("body, html").click(function (event) {
        if ($(event.target).closest(".pt_title, .pt_pop").length === 0) {
            $(".pt_body").slideUp(200);
            $('.pt_town').removeClass('open');
        }
    });


    if ($('.pd_nav.for_content').length > 0) {
        (function () {
            var a = document.querySelector('.pd_sidebar'), b = null, K = null, Z = 0, P = $('header').outerHeight(),
                N = 1;  // если у P ноль заменить на число, то блок будет прилипать до того, как верхний край окна браузера дойдёт до верхнего края элемента, если у N — нижний край дойдёт до нижнего края элемента. Может быть отрицательным числом
            window.addEventListener('scroll', Ascroll, false);
            document.body.addEventListener('scroll', Ascroll, false);

            function Ascroll() {
                if ($(window).width() >= 768) {
                    var Ra = a.getBoundingClientRect(),
                        R1bottom = document.querySelector('.pd_body').getBoundingClientRect().bottom;
                    if (Ra.bottom < R1bottom) {
                        if (b == null) {
                            var Sa = getComputedStyle(a, ''), s = '';
                            for (var i = 0; i < Sa.length; i++) {
                                if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
                                    s += Sa[i] + ': ' + Sa.getPropertyValue(Sa[i]) + '; '
                                }
                            }
                            b = document.createElement('div');
                            b.className = "stop";
                            b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
                            a.insertBefore(b, a.firstChild);
                            var l = a.childNodes.length;
                            for (var i = 1; i < l; i++) {
                                b.appendChild(a.childNodes[1]);
                            }
                            a.style.height = b.getBoundingClientRect().height + 'px';
                            a.style.padding = '0';
                            a.style.border = '0';
                        }
                        var Rb = b.getBoundingClientRect(),
                            Rh = Ra.top + Rb.height,
                            W = document.documentElement.clientHeight,
                            R1 = Math.round(Rh - R1bottom),
                            R2 = Math.round(Rh - W);
                        if (Rb.height > W) {
                            if (Ra.top < K) {  // скролл вниз
                                if (R2 + N > R1) {  // не дойти до низа
                                    if (Rb.bottom - W + N <= 0) {  // подцепиться
                                        b.className = 'sticky';
                                        b.style.top = W - Rb.height - N + 'px';
                                        Z = N + Ra.top + Rb.height - W;
                                    } else {
                                        b.className = 'stop';
                                        b.style.top = -Z + 'px';
                                    }
                                } else {
                                    b.className = 'stop';
                                    b.style.top = -R1 + 'px';
                                    Z = R1;
                                }
                            } else {  // скролл вверх
                                if (Ra.top - P < 0) {  // не дойти до верха
                                    if (Rb.top - P >= 0) {  // подцепиться
                                        b.className = 'sticky';
                                        b.style.top = P + 'px';
                                        Z = Ra.top - P;
                                    } else {
                                        b.className = 'stop';
                                        b.style.top = -Z + 'px';
                                    }
                                } else {
                                    b.className = '';
                                    b.style.top = '';
                                    Z = 0;
                                }
                            }
                            K = Ra.top;
                        } else {
                            if ((Ra.top - P) <= 0) {
                                if ((Ra.top - P) <= R1) {
                                    b.className = 'stop';
                                    b.style.top = -R1 + 'px';
                                } else {
                                    b.className = 'sticky';
                                    b.style.top = P + 'px';
                                }
                            } else {
                                b.className = '';
                                b.style.top = '';
                            }
                        }
                        window.addEventListener('resize', function () {
                            a.children[0].style.width = getComputedStyle(a, '').width
                        }, false);
                    }
                }
            }
        })()

    }

});
(function () {
    var $searchOverlay = document.querySelector(".search-overlay");
    var $search = document.querySelector(".search");
    var $clone, offsetX, offsetY;

    // $search.addEventListener("click", function () {
    //     var $original = this;
    //     $clone = this.cloneNode(true);

    //     $searchOverlay.classList.add("s--active");

    //     $clone.classList.add("s--cloned", "s--hidden");
    //     $searchOverlay.appendChild($clone);

    //     var triggerLayout = $searchOverlay.offsetTop;

    //     var originalRect = $original.getBoundingClientRect();
    //     var cloneRect = $clone.getBoundingClientRect();

    //     offsetX = originalRect.left - cloneRect.left;
    //     offsetY = originalRect.top - cloneRect.top;

    //     $clone.style.transform = "translate(" + offsetX + "px, " + offsetY + "px)";
    //     $original.classList.add("s--hidden");
    //     $clone.classList.remove("s--hidden");

    //     var triggerLayout = $searchOverlay.offsetTop;

    //     $clone.classList.add("s--moving");

    //     $clone.setAttribute("style", "");

    //     $clone.addEventListener("transitionend", openAfterMove);
    // });

    function openAfterMove() {
        $clone.classList.add("s--active");
        $clone.querySelector("input").focus();

        addCloseHandler($clone);
        $clone.removeEventListener("transitionend", openAfterMove);
    };

    function addCloseHandler($parent) {
        var $closeBtn = $parent.querySelector(".search__close");
        $closeBtn.addEventListener("click", closeHandler);
    };

    /* close handler functions */
    function closeHandler(e) {
        $clone.classList.remove("s--active");
        e.stopPropagation();

        var $cloneBg = $clone.querySelector(".search__bg");

        $cloneBg.addEventListener("transitionend", moveAfterClose);
    };

    function moveAfterClose(e) {
        e.stopPropagation(); // prevents from double transitionend even fire on parent $clone

        $clone.classList.add("s--moving");
        $clone.style.transform = "translate(" + offsetX + "px, " + offsetY + "px)";
        $clone.addEventListener("transitionend", terminateSearch);
    };

    function terminateSearch(e) {
        $search.classList.remove("s--hidden");
        $clone.remove();
        $searchOverlay.classList.remove("s--active");
    };
}());
