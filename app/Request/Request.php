<?php
namespace App\Request;

use App\Exception\ValidationException;

class Request {

    /**
     * 何かしらのメソッドが呼ばれたらここがよがれる
     *
     * @param string $method
     * @param array $args
     * @throws MethodNotAllowedException
     * @return mixed
     */
    public function __call(string $method, array $args) {
        switch ($method) {
            case 'session': return $this->_session($args);
            case 'request': return $this->_request($args);
            default: throw new MethodNotAllowedException();
        }
    }

    /**
     * sessionに関する処理
     *
     * @param array $args
     * @throws MethodNotAllowedException
     * @return mixed
     */
    private function _session(array $args) {
        switch ($args[0]) {
            case 'set': return $_SESSION[$args[1]] = $args[2];
            case 'get': return isset($_SESSION[$args[1]]) ? $_SESSION[$args[1]] : '';
            case 'all': return $_SESSION;
            case 'old': return isset($_SESSION['old'][$args[1]]) ? $_SESSION['old'][$args[1]] : '';
            case 'errors': return isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
            case 'unset':
                if (isset($_SESSION[$args[1]])) unset($_SESSION[$args[1]]);
                break;
            default: throw new MethodNotAllowedException();
        }
    }

    /**
     * requestに関する処理
     *
     * @param array $args
     * @throws MethodNotAllowedException
     * @return mixed
     */
    private function _request(array $args) {
        switch ($args[0]) {
            case 'set': return $_REQUEST[$args[1]] = $args[2];
            case 'get': return isset($_REQUEST[$args[1]]) ? $_REQUEST[$args[1]] : '';
            case 'all': return $_REQUEST;
            default: throw new MethodNotAllowedException();
        }
    }
}
