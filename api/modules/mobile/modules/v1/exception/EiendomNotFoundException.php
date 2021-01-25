<?php

namespace api\modules\mobile\modules\v1\exception;

use yii\web\HttpException;
use Exception;
use yii\web\Response;

class EiendomNotFoundException extends HttpException
{

    /**
     * UserNotFoundException constructor.
     * @param null $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        parent::__construct(404, $message, $code, $previous);
    }


    /**
     * @return string the eiendom-friendly name of this exception
     */
    public function getName()
    {
        return 'Eiendom not found';
    }

}