$(document).ready(function() {
    var customSwiper = new Swiper('.swiper-container', {
        calculateHeight: true,
        slideToClickedSlide: false,
        preloadImages: false,
        lazy: {
            loadPrevNext: true,
            loadPrevNextAmount: 2
        },
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        keyboard: {
            enabled: true
        }
    });

    if (location.hash.includes('#360-view')) {
        customSwiper.slidePrev(100, false);
    }

    var initPhotoSwipeFromDOM = function(gallerySelector) {
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;

            for (var i = 0; i < numNodes; i++) {
                figureEl = thumbElements[i]; // <figure> element

                // include only element nodes
                if (figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0];

                if (!linkEl.getAttribute('data-html')) {
                    size = linkEl.getAttribute('data-size').split('x');

                    item = {
                        src: linkEl.getAttribute('href'),
                        title: linkEl.getAttribute('data-caption'),
                        w: parseInt(size[0], 10),
                        h: parseInt(size[1], 10)
                    };

                    if (linkEl.children.length > 0) {
                        item.msrc = linkEl.children[0].getAttribute('src');
                    }
                } else {
                    item = {
                        html: linkEl
                    };
                }

                item.el = figureEl;

                items.push(item);
            }

            return items;
        };

        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };

        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : (e.returnValue = false);

            var eTarget = e.target || e.srcElement;

            var clickedListItem = closest(eTarget, function(el) {
                return el.tagName && el.tagName.toUpperCase() === 'LI';
            });

            if (!clickedListItem) {
                return;
            }

            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if (childNodes[i].nodeType !== 1) {
                    continue;
                }

                if (childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }

            if (index >= 0) {
                openPhotoSwipe(index, clickedGallery);
            }
            return false;
        };

        var openPhotoSwipe = function(
            index,
            galleryElement,
            disableAnimation,
            fromURL
        ) {
            var pswpElement = document.querySelectorAll(".pswp")[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            options = {
                closeEl: true,
                captionEl: true,
                fullscreenEl: true,
                zoomEl: true,
                shareEl: false,
                counterEl: false,
                arrowEl: true,
                preloaderEl: true,
                history: false,
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),
                getThumbBoundsFn: function(index) {
                    var thumbnail = items[index].el.getElementsByTagName('img')[0];

                    // console.log(items[index].html)

                    if (!thumbnail) {
                        return {};
                    }

                    var pageYScroll = window.pageYOffset || document.documentElement.scrollTop;
                    var rect = thumbnail.getBoundingClientRect();

                    return { x: rect.left, y: rect.top + pageYScroll, w: rect.width };
                }
            };

            if (fromURL) {
                if (options.galleryPIDs) {
                    for (var j = 0; j < items.length; j++) {
                        if (items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            if (isNaN(options.index)) {
                return;
            }

            if (disableAnimation) {
                options.showAnimationDuration = 0;
            }

            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

            gallery.listen('imageLoadComplete', function (index, item) {
                if (item.h < 1 || item.w < 1) {
                    var img = new Image()

                    img.onload = function() {
                        item.w = img.width;
                        item.h = img.height;
                        gallery.updateSize(true);
                    }

                    img.src = item.src
                }
            });

            gallery.init();

            gallery.listen('unbindEvents', function() {
                var getCurrentIndex = gallery.getCurrentIndex();
                customSwiper.slideTo(getCurrentIndex, 100, false);
            });

            gallery.listen('initialZoomIn', function() {
                // Logic here...
            });
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);

        for (var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i + 1);
            galleryElements[i].onclick = onThumbnailsClick;
        }
    };

    initPhotoSwipeFromDOM('.photo-gallery');
});
