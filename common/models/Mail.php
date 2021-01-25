<?php

namespace common\models;

use yii\base\Model;
use yii\validators\EmailValidator;

class Mail extends Model
{
    public $from;
    public $subject;
    public $message;
    public $email;
    public $emails;

    const SCENARIO_BEFARING_CALENDAR_SELGER = 'befaring_calendar_selger';
    const SCENARIO_BEFARING_CALENDAR = 'befaring_calendar';
    const SCENARIO_LEAD = 'lead';

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [],
            self::SCENARIO_LEAD => ['subject', 'message', 'email', 'from'],
            self::SCENARIO_BEFARING_CALENDAR => ['subject', 'message', 'email', 'from'],
            self::SCENARIO_BEFARING_CALENDAR_SELGER => ['subject', 'message', 'from', 'emails'],
        ];
    }

    public function rules()
    {
        return [
            [['subject', 'message', 'from'], 'required'],
            [['subject', 'message', 'email', 'from'], 'string'],
            [['email'], 'required', 'on' => [self::SCENARIO_LEAD, self::SCENARIO_BEFARING_CALENDAR]],
            [['email'], EmailValidator::class, 'on' => [self::SCENARIO_LEAD, self::SCENARIO_BEFARING_CALENDAR]],
            [['emails'], 'notEmpty', 'skipOnEmpty' => false, 'skipOnError' => false, 'on' => self::SCENARIO_BEFARING_CALENDAR_SELGER],
        ];
    }

    public function notEmpty($attribute, $params)
    {
        if (!is_array($this->{$attribute}))
            $this->addError($attribute, 'Du må velge minst en e-post');
    }
}
