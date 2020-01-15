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
