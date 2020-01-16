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
    public function set(string $name, string $value) {
        $oldKey = null;
        $session = [];
        foreach (array_reverse(explode('.', $name)) as $key) {
            $session[$key] = $value;
            if ($oldKey) unset($session[$oldKey]);
            $oldKey = $key;
            $value = $session;
        }
        $_SESSION = array_merge_recursive($_SESSION, $session);
        return $this;
    }

    /**
     * 制定したセッションを取得
     *
     * @param string $name
     * @param string $default
     * @return string|array $target
     */
    public function get(string $name, string $default = '') {
        $target = $_SESSION;
        foreach (explode('.', $name) as $key) {
            if (isset($target[$key])) {
                $target = $target[$key];
            } else {
                return $default;
            }
        }
        return $target;
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
        return $this->get('flash.old.oldInput.' . $name);
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
        $this->set('errors', serialize($value));
    }

    /**
     * session破棄
     *
     * @param mixed $args
     * @throws MethodNotAllowedException
     * @return void
     */
    public function forget($args) {
        function array_del($array, $i, $hierarchy, $max) {
            $tmp = [];
            foreach($array as $key => $item) {
                if (is_array($item) && $key === $hierarchy[$i] && $max !== ($i + 1)) {
                    $tmp[$key] = array_del($item, $i + 1, $hierarchy, $max);
                } elseif (!empty($item) && $key === $hierarchy[$i] && $max === ($i + 1)) {
                    unset($tmp[$key]);
                } else {
                    $tmp[$key] = $item;
                }
            }
            return $tmp;
        }
        switch (gettype($args)) {
            case 'string':
                $hierarchy = explode('.', $args);
                $_SESSION = array_del($_SESSION, 0, $hierarchy, count($hierarchy));
                break;
            case 'array':
                foreach ($args as $value) {
                    $hierarchy = explode('.', $value);
                    $_SESSION = array_del($_SESSION, 0, $hierarchy, count($hierarchy));
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
    public function flash(string $name, string $value) {
        $this->set('flash.new.' . $name, $value);
        return $this;
    }

    /**
     * フラッシュセッションを取得
     *
     * @param string $name
     * @param string $default
     * @return string|array
     */
    public function old(string $name, string $default = '') {
        return $this->get('flash.old.' . $name, $default);
    }

    /**
     * requestに関する処理
     *
     * @param array $args
     * @return void
     */
    public function keep(array $args) {
        foreach ($args as $name) {
            $value = $this->old($name);
            $this->flash($name, $value);
        }
    }
}
