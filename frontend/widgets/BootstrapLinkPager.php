<?php

namespace frontend\widgets;

use yii\helpers\Html;
use yii\widgets\LinkPager;

class BootstrapLinkPager extends LinkPager
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->prevPageCssClass = 'page-item';
        $this->nextPageCssClass = 'page-item';

        $this->options['class'] = 'pagination justify-content-center';

        $this->nextPageLabel = '<span class="d-none d-md-inline">Neste </span>»';
        $this->prevPageLabel = '«<span class="d-none d-md-inline"> Forrige</span>';

        $this->linkOptions['class'] = 'page-link';
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }

        if ($this->pagination->getPageCount() > 1) {
            echo Html::tag('nav', $this->renderPageButtons());
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => empty($class) ? 'page-item' : $class];
        $linkOptions = $this->linkOptions;

        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }

        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $linkOptions['tabindex'] = '-1';
        }

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}