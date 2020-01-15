<?php
namespace App\Request;

class MessageBag
{
    private $errors = [];

    /**
     * 指定したキー名のエラーの1件目を取得
     *
     * @return string
     */
    public function first($name): string {
        return $this->errors[$name][0];
    }

    /**
     * 指定したキー名でエラーを取得
     *
     * @return array
     */
    public function get($name): array {
        return $this->errors[$name];
    }

    /**
     * 全てのエラーを配列で取得
     *
     * @return array
     */
    public function all(): array {
        $messages = [];
        foreach ($this->errors as $error) {
            foreach ($error as $value) {
                $messages[] = $value;
            }
        }
        return $messages;
    }

    /**
     * 指定したキー名でエラーが存在するか
     *
     * @return bool
     */
    public function has($name): bool {
        return isset($this->errors[$name]);
    }

    /**
     * エラーをセット
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function set($name, $value) {
        $this->errors[$name][] = $value;
    }

    /**
     * エラーが存在するか
     *
     * @return bool
     */
    public function isEmpty(): bool {
        return empty($this->errors);
    }
}
