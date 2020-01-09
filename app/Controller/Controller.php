<?php
namespace App\Controller;

use App\Request\Request;
use App\Exception\MethodNotAllowedException;
use App\Exception\ValidationException;

class Controller {

    /**
     * 指定された名前の画面を描画
     *
     * @param string $route
     * @param array $attribute
     * @return void
     */
    protected function view(string $route, array $attribute = []) {
        foreach ($attribute as $key => $value) {
            $this->$key = $value;
        }
        $request = new Request();
        $old = $request->session('old', 'post');
        $request->session('unset', 'old');
        $errors = $request->session('errors');
        $request->session('unset', 'errors');
        $csrf = '<input type="hidden" name="token" value="' . $request->session('get', 'token') . '">';
        include(VIEWS_PATH . $route . '.php');
    }

    /**
     * 指定されたパスへリダイレクト
     *
     * @param string $path
     * @return void
     */
    protected function redirect($path) {
        header('Location: ' . SITE_URL . $path);
    }

    /**
     * バリデーション処理
     * flagがtrueなら入力画面に戻る。画面では$errorsの名前で配列でエラー内容を取得できる
     *
     * @param array $attribute
     * @param array $rules
     * @param array $message
     * @param bool $flag
     * @throws ValidationException
     * @return array $errors
     */
    protected function validation(array $attribute, array $rules, array $message = [], bool $flag = false): array {
        $errors = [];
        foreach ($rules as $key => $rule) {
            foreach ($rule as $value) {
                switch ($value) {
                    case 'required':
                        if (!isset($attribute[$key]) || $attribute[$key] === '') {
                            $errors[$key][$value] = '必須項目が入力されていません！';
                        }
                        break;
                    default:
                        if (!$value($attribute[$key])) {
                            $errors[$key][$value] = isset($message[$key]) ? $message[$key] : '不正な値';
                        }
                        break;
                }
            }
        }
        if ($flag && !empty($errors)) {
            unset($_POST);
            throw new ValidationException($errors);
        } else {
            return $errors;
        }
    }

    public function __call($method,$args){
        throw new MethodNotAllowedException();
    }

    public function welcomeView()
    {
        return $this->view('welcome');
    }
}
