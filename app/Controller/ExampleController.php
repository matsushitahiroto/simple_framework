<?php
namespace App\Controller;

use App\Request\Request;

final class ExampleController extends Controller
{
    /**
     * validation用
     */
    const RULES = [
        'post-string' => ['required', 'is_string']
    ];

    /**
     * 画面表示
     *
     * @param Request $request
     * @return void
     */
    public function exampleView(Request $request)
    {
        $string = $request->session('get', 'string');

        return $this->view('example', [
            'string' => $string
        ]);
    }

    /**
     * post
     *
     * @param Request $request
     * @throws ValidationException
     * @return void
     */
    public function post(Request $request)
    {
        $this->validation($request->request('all'), self::RULES, [], true);
        $string = $request->request('get', 'post-string');
        $request->session('set', 'string', $string);
        return $this->redirect('/example');
    }

    /**
     * reset
     *
     * @return void
     */
    public function delete()
    {
        session_destroy();
        return $this->redirect('/example');
    }
}
