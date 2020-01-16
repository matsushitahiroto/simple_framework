<?php
namespace App\Controller;

use App\Request\Request;

final class ExampleController extends Controller
{
    /**
     * validation用
     */
    const RULES = [
        'post-string' => 'required|is_string'
    ];
    const MESSAGE = [
        'post-string.required' => '入力して！',
        'post-string.is_string' => '文字列だけ'
    ];

    /**
     * 画面表示
     *
     * @param Request $request
     * @return void
     */
    public function exampleView(Request $request)
    {
        return view('example', [
            'string' => $request->session()->old('string')
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
        $request->setMessage(self::MESSAGE)->validation(self::RULES);
        return redirect('/example', [
            'string' => $request->input('post-string')
        ]);
    }

    /**
     * reset
     *
     * @return void
     */
    public function delete()
    {
        session()->flush();
        return redirect('/example');
    }
}
