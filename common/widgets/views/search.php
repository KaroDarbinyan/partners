<?php
/**
 * @var $page boolean
 * @var $elementId string
 * @var $class string
 * @var $url string
 * @var $placeholder string
 */

use yii\helpers\Html;

?>

<?= Html::input('text', 'search', "", ['id' => $elementId, 'class' => $class, 'placeholder' => $placeholder]); ?>
<?php

if ($page) {
    $js = <<<JS
        let selectObjPage = $("#{$elementId}");
        if (selectObjPage.length) {
            let dataPage;
            let urlPage = '{$url}';
            let optionsPage = {
                url: urlPage,

                ajaxSettings: {
                    dataType: "json",
                    method: "POST",
                    data: {
                        dataType: "json"
                    }
                },

                requestDelay: 500,

                preparePostData: function (data) {
                    data.search = selectObjPage.val();
                    return data;
                },

                getValue: function (e) {
                    return e.navn;
                },

                listLocation: function (req) {
                    for(let i = 0; i < req.length; i++){
                        let split = req[i]["navn"].split("+");
                        req[i]["navn"] = split[0];
                    }
                    dataPage = req;
                    return req;
                },

                list: {
                    showAnimation: {
                        type: "fade", //normal|slide|fade
                        time: 400,
                        callback: function () {
                        }
                    },

                    hideAnimation: {
                        type: "slide", //normal|slide|fade
                        time: 400,
                        callback: function () {

                        }
                    },

                    match: {
                        enabled: true
                    },

                    onSelectItemEvent: function () {
                        let selectedItemValue = selectObjPage.getSelectedItemData().navn.split("<span");
                        selectObjPage.val(selectedItemValue[0])
                    },

                    onLoadEvent: function () {
                        let autocomplete_container = $('.easy-autocomplete .easy-autocomplete-container');
                        autocomplete_container.nextAll('.easy-autocomplete-container').remove();
                        if (dataPage.length === 0) {
                            autocomplete_container.after($('<div>', {
                                class: 'easy-autocomplete-container'
                            }).append('<ul class="show"><li><div class="eac-item">Ingen funnet</div></li></ul>'));
                        } else {
                            autocomplete_container.children('ul').each(function (i) {
                                if (i < dataPage.length) {
                                    $(this)
                                        .find('.eac-item')
                                        .prepend('<i class="icon-' + dataPage[i].type + '"></i>')
                                        //.append('<span> (' + Math.abs(dataPage[i].count) + ')</span>');
                                }
                            });
                        }
                    },

                    onChooseEvent: function (e) {
                        let selected = selectObjPage.getSelectedItemData();
                        selectObjPage.val(selected.navn.split("<span")[0]);
                        window.open(selected["href"]);
                    }
                },

                theme: "dark"
            };

            selectObjPage.easyAutocomplete(optionsPage);
        }
JS;
} else {
    $js = <<<JS
        let selectObj = $("#{$elementId}");
        if (selectObj.length) {
            let data;
            let url = '{$url}';
            let options = {
                url: url,

                ajaxSettings: {
                    dataType: "json",
                    method: "POST",
                    data: {
                        dataType: "json"
                    }
                },

                requestDelay: 500,

                preparePostData: function (data) {
                    data.search = selectObj.val();
                    return data;
                },

                getValue: function (e) {
                    return e.navn;
                },

                listLocation: function (req) {
                    data = req;
                    return req;
                },

                list: {
                    showAnimation: {
                        type: "fade", //normal|slide|fade
                        time: 400,
                        callback: function () {
                        }
                    },

                    hideAnimation: {
                        type: "slide", //normal|slide|fade
                        time: 400,
                        callback: function () {
                        }
                    },

                    match: {
                        enabled: true
                    },

                    onSelectItemEvent: function () {
                        let selectedItemValue = selectObj.getSelectedItemData().navn;
                        selectObj.val(selectedItemValue)
                    },

                    onLoadEvent: function () {
                        let autocomplete_container = $('.easy-autocomplete .easy-autocomplete-container');
                        autocomplete_container.nextAll('.easy-autocomplete-container').remove();
                        if (data.length === 0) {
                            autocomplete_container.after($('<div>', {
                                class: 'easy-autocomplete-container'
                            }).append('<ul class="show"><li><div class="eac-item">Ingen funnet</div></li></ul>'));
                        } else {
                            autocomplete_container.children('ul').children('li').each(function (i) {
                                if (i < data.length) {
                                    $(this)
                                        .find('.eac-item')
                                        .prepend('<i class="fa fa-' + data[i].type + '"></i>');
                                    if (data[i].type !== 'broker') $(this).find('.eac-item').append('<span> (' + Math.abs(data[i].count) + ')</span>')
                                        //.append('<span> (' + Math.abs(data[i].count) + ')</span>');
                                }
                            });
                        }
                    },

                    onHideListEvent: function () {
                        // $("input[name=search]").val("").trigger("change");
                    },

                    onChooseEvent: function (e) {
                        let selected = selectObj.getSelectedItemData();
                        selectObj.val(selected.navn);
                        location.replace(selected["href"]);
                    }
                },

                theme: "dark"
            };

            selectObj.easyAutocomplete(options);
        }
JS;
}
$this->registerJs($js, \yii\web\View::POS_END);

$this->registerJs($js, \yii\web\View::POS_READY);
