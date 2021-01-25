<?php

namespace common\widgets;

use yii\base\Widget;

class SearchWidget extends Widget
{
    public $elementId = 'header-search';
    public $url = '/search';
    public $placeholder = 'Søk: megler, adresse eller område';
    public $page = false;
    public $inputClass = '';

    public function run()
    {
        $url = $this->url;
        $elementId = $this->elementId;
        $class = $this->inputClass;
        $page = $this->page;
        $placeholder = $this->placeholder;

        return $this->render('search', compact('url', 'class', 'page', 'elementId', 'placeholder'));
    }
}