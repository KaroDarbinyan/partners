<?php

namespace common\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use yii\base\Model;


/**
 * This is the model class for table "forms".
 *
 * @property string $phone
 * @property string $message
 * @property string $from
 */
class Sms extends Model
{

    public $phone;
    public $message;
    public $from;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'message', 'from'], 'required'],
            [['phone', 'message'], 'string'],
            [['phone'], PhoneInputValidator::class],
        ];
    }

    public function beforeValidate()
    {
        $this->phone = preg_replace(['/\s+/'], '', $this->phone);
        $this->from = preg_replace(['/\s+/'], '', $this->from);
        $this->phone = ((strlen($this->phone) === 8) && (strpos($this->phone, '+') === false)) ? "+47{$this->phone}" : $this->phone;
        return parent::beforeValidate();
    }


}
