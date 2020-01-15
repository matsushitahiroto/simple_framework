<?php
namespace App\Request;

use App\Exception\ValidationException;
use App\Request\Session;
use App\Request\MessageBag;

class Request
{
    private $session;
    private $request;
    private $input;
    private $message = [];

    public function __construct() {
        $this->session = new Session();
        $this->request = $_REQUEST;

        $get = $_GET;
        $post = $_POST;
        $this->input = array_merge($get, $post);
        unset($this->input['csrf']);
    }

    /**
     * session
     *
     * @return Session
     */
    public function session():Session {
        return $this->session;
    }

    /**
     * 指定したkeyで取得
     *
     * @param $name
     * @return mixed
     */
    public function get($name) {
         return isset($this->request[$name]) ? $this->request[$name] : '';
    }

    /**
     * 全件取得
     *
     * @return mixed
     */
    public function all() {
         return $this->request;
    }

    /**
     * インプットの取得
     *
     * @return mixed
     */
    public function input($args = null) {
        switch (gettype($args)) {
            case 'string':
                 return isset($this->input[$args]) ? $this->input[$args] : '';
            case 'array':
                $input = [];
                foreach ($args as $value) {
                     $input[$value] = isset($this->input[$value]) ? $this->input[$value] : '';
                }
                return $input;
            case 'NULL':
                return $this->input;
                break;
            default:
                throw new MethodNotAllowedException();
        }
    }

    /**
     * インプットをフラッシュセッションに格納
     *
     * @return $his
     */
    public function flash() {
        foreach ($this->input() as $key => $value) {
            $this->session()->flash($key, $value);
        }
        return $this;
    }

    /**
     * 指定したインプットをフラッシュセッションに格納
     *
     * @return $his
     */
    public function flashOnly(array $args) {
        foreach ($this->input($args) as $key => $value) {
            $this->session()->flash($key, $value);
        }
        return $this;
    }

    /**
     * フラッシュセッションを取得
     *
     * @return mixed
     */
    public function old($name) {
         return $this->session()->old($name);
    }

    /**
     * バリデーションのメッセージ設定
     *
     * @param array $message
     * @return self
     */
    public function setMessage(array $message): self {
        $this->message = $message;
        return $this;
    }

    /**
     * バリデーション処理
     * flagがtrueなら入力画面に戻る。画面では$errorsの名前で配列でエラー内容を取得できる
     *
     * @param array $rules
     * @param bool $flag
     * @throws ValidationException
     * @return MessageBag $errors
     */
    public function validation(array $rules, bool $flag = true): MessageBag {
        $errors = new MessageBag();
        $message = $this->message;
        foreach ($rules as $key => $rule) {
            foreach ($rule as $value) {
                switch ($value) {
                    case 'required':
                        if ($this->input($key) === '') {
                            $error = isset($message[$key]['required']) ? $message[$key]['required'] : '必須項目が入力されていません！';
                            $errors->set($key, $error);
                        }
                        break;
                    default:
                        if (!$value($this->input($key))) {
                            $error = isset($message[$key][$value]) ? $message[$key][$value] : '不正な値';
                            $errors->set($key, $error);
                        }
                        break;
                }
            }
        }
        if ($flag && !$errors->isEmpty()) {
            throw new ValidationException($errors);
        } else {
            return $errors;
        }
    }
}
