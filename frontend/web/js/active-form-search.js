(function ($) {
    let $document = $(document),
        $timeout = 0.3 * 1000
    ;

    /**
     * Ajax Submit form with timeout and cancels it on resubmit
     * @param $s
     */
    function ajaxSubmitForm (){

        let $s = this;
        if ($s.timeout){clearTimeout($s.timeout);}

        // Exit function if keyword length is shorter then 3
        if ($s.$searchInput.val().length < 3){$s.$list.html('');return;}

        $s.timeout = setTimeout(function () {
            $.ajax({
                method: $s.method,
                url: $s.action,
                data: $s.$jQObject.serialize(),
            })
                .done(function( responce ) {
                    $s.$list.html(responce);
                });
        }, $timeout);
    };

    $document.ready(function (e) {
        let $searches = $('[data-active-form-serach]'),
            $lists = $('[data-active-form-serach-list]')
        ;
        //console.log('$searches',$searches);
        /**
         * Remove list when click outside of it
         */
        $document.on('click', function (e) {
            if (
                $lists &&
                !$lists.is(e.target) &&
                $lists.has(e.target).length === 0 &&
                !$searches.is(e.target) &&
                $searches.has(e.target).length === 0
            )
            {// if the target of the click isn't the container nor a descendant of the container
                $lists.html('');
            }
        });

        /**
         * Init search forms
         */
        $searches.each(function (i) {
            let $s = $(this),
                $sId = $s.attr('data-active-form-serach')
            ;

            $s.keyup(ajaxSubmitForm);
            $s.submit(function (e) {
                e.preventDefault();
            });

            $searches[i]['$list'] = $('[data-active-form-serach-list = "' + $sId +'"]');
            $searches[i]['$jQObject'] = $s;
            $searches[i]['$searchInput'] = $($s.find('input[name=search]'));
        });
    })
})(jQuery);