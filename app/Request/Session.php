<?php
namespace App\Request;

use App\Exception\ValidationException;
use App\Request\MessageBag;

class Session
{
    /**
     * セッションに格納
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function set($name, $value) {
        $_SESSION[$name] = $value;
        return $this;
    }

    /**
     * 制定したセッションを取得
     *
     * @param string $name
     * @return $this
     */
    public function get($name) {
         return isset($_SESSION[$name]) ? $_SESSION[$name] : '';
    }

    /**
     * 全件取得
     *
     * @return $this
     */
    public function all(): array {
         return $_SESSION;
    }

    /**
     * 直前処理の入力値取得
     *
     * @param string $name
     * @return string
     */
    public function oldInput($name): string {
         return isset($_SESSION['flash']['old']['oldInput'][$name]) ? $_SESSION['flash']['old']['oldInput'][$name] : '';
    }

    /**
     * エラーの名前で取得
     *
     * @return MessageBag
     */
    public function errors(): MessageBag {
         return isset($_SESSION['errors']) ? unserialize($_SESSION['errors']) : new MessageBag();
    }

    /**
     * エラーの名前で格納
     * MessageBagをシリアライズ
     *
     * @param MessageBag $args
     */
    public function setErrors(MessageBag $value) {
        $_SESSION['errors'] = serialize($value);
    }

    /**
     * session破棄
     *
     * @param mixed $args
     * @throws MethodNotAllowedException
     * @return void
     */
    public function forget($args) {
        switch (gettype($args)) {
            case 'string':
                if (isset($_SESSION[$args])) unset($_SESSION[$args]);
                break;
            case 'array':
                foreach ($args as $value) {
                    if (isset($_SESSION[$value])) unset($_SESSION[$value]);
                }
                break;
            default:
                throw new MethodNotAllowedException();
        }
    }

    /**
     * session完全破棄
     *
     * @return $his
     */
    public function flush() {
        session_destroy();
        return $this;
    }

    /**
     * requestに関する処理
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function flash($name, $value) {
        $_SESSION['flash']['new'][$name] = $value;
        return $this;
    }

    /**
     * フラッシュセッションを取得
     *
     * @param string $name
     * @return string
     */
    public function old($name): string {
        return isset($_SESSION['flash']['old'][$name]) ? $_SESSION['flash']['old'][$name] : '';
    }

    /**
     * requestに関する処理
     *
     * @param array $args
     * @return void
     */
    public function keep(array $args) {
        foreach ($args as $name) {
            $value = isset($_SESSION['flash']['old'][$name]) ? $_SESSION['flash']['old'][$name] : '';
            $this->flash($name, $value);
        }
    }
}
