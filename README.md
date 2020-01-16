# 簡易フレームワーク

## 概要  
何か作る時の土台に使ってください

## 開発  
### configの設定  
  参照するindex.phpとcssまでのPATHの設定をする

### routeの設定  
  config/route.phpにURLとリクエストメソッドと使うコントローラー名とメソッド名を配列で記述

#### app  
  各クラスはapp配下に作成する

#### resources  
  画面のhtmlはここに配置する

#### csrf  
  フォーム内に以下を記述

    <?= $csrf; ?>

#### xss  
  エスケープ処理はh()を記述

    <p><?= h($string) ?></p>

### リクエスト　セッション　バリデーション　の主要機能

  引数で配列の階層を指定する場合はドットつなぎ
  第二引数でデフォルト値指定可能

    $inputtext = session()->get('flash.old.inputtext', 'default');


### リクエストクラス  

#### 全入力データの取得  
  全リクエストを「配列」として受け取りたい場合  

    $input = $request->all();

#### 入力値の取得  
  全入力を「配列」として受け取りたい場合  

    $input = $request->input();

  キー名を指定、または配列でキー名を指定して受け取りたい場合  

    $post = $request->input('post');
    $list = $request->input(['post','token']);

#### 直前の入力  
  現在の入力をセッションへ、アプリケーションに要求される次のユーザーリクエストの処理中だけ利用できるフラッシュデータとして保存  

    $request->flash();

  セッションへ入力の一部をフラッシュデータとして保存  

    $request->flashOnly(['username', 'email']);

  リダイレクト時に保存  

    return redirect('form', ['name'=>'taro']);

#### 直前のデータを取得  
  フラッシュデータとして保存されている入力を取り出す  

    $username = $request->old('username');

    <input type="text" name="username" value="{?= h(old('username')) ?}">

### session  

#### データ取得

    $value = $request->session()->get('key');
    $value = session()->get('key');

### バリデーション  

#### ロジック
  処理の結果を欲しい場合

    $validatedData = $request->validate([
        'body' => 'required|is_string'
    ], false);

  エラーがあった場合にリダイレクトしてほしい場合

    $request->validate([
        'body' => 'required|is_string'
    ]);

  独自エラーメッセージをセットしたい場合

    $request->setMessage([
      'body.required' => '必須です',
      'body.is_string' => '文字列だけ'
    ])->validate([
      'body' => 'required|is_string'
    ]);

#### 画面表示
  全件表示

    <?php foreach ($errors->all() as $error) {?>
        <p><?= h($error) ?></p>
    <?php } ?>

  指定したキー名でエラーが存在するか

    $errors->has('body')

  エラーが存在するか

    $errors->isEmpty()

  指定したキー名のエラーの1件目を取得

    $errors->first('body')

  指定したキー名でエラーを取得

    $errors->get('body')
