<?php
namespace App\Exception;

final class ValidationException extends \Exception
{
    /**
     * errorを格納
     * @var array
     */
    private $errors;

    /**
     * @param array $errorList
     */
    public function __construct(array $errorList) {
        $this->errors = $errorList;
        parent::__construct(null, 422);
    }

    /**
     * errorを取得
     *
     * @return array
     */
    public function getErrors(): array {
        return $this->errors;
    }
}
