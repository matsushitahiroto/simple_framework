<?php
namespace App\Exception;

use App\Request\MessageBag;

final class ValidationException extends \Exception
{
    /**
     * errorを格納
     * @var array
     */
    private $errors;

    /**
     * @param MessageBag $errorList
     */
    public function __construct(MessageBag $errorList) {
        $this->errors = $errorList;
        parent::__construct(null, 422);
    }

    /**
     * errorを取得
     *
     * @return MessageBag
     */
    public function getErrors(): MessageBag {
        return $this->errors;
    }
}
