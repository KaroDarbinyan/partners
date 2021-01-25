(function($){
    $(document).ready(function () {
        $('[data-check-target]').each(function () {
            let $b = $(this),
                $it = $('#' + $b.attr('data-check-target'))
            ;
            $b.on('click', function () {
                $it.prop('checked', true);
            });
        });
    });
})(jQuery);
