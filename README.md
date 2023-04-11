# アプリ概要

## 2021年4月

#### URL:サービス終了しました。

レスポンシブ化(iPhone5 の横幅 320px まで対応)

## サービス概要

お笑いに特化した SNS です。お笑いに関する情報の共有や相方の募集、コンビの結成ができるサービスです。  
<img src="https://user-images.githubusercontent.com/67299659/114543595-5d56e200-9c94-11eb-8cf4-27647505a031.png" width="750">

## 制作背景

### コンセプトはお笑い

私の趣味はお笑い観賞であり、劇場に足を運ぶほどお笑いが好きです。
好きになった経緯は、子供から大人まで笑わせ、舞台からはけていく姿に憧れを抱いたからです。
落ち込んだ時にお笑いを見る事で何回も勇気づけられました。
お笑いへの恩返しができるようなサービスにしました。

### 相方募集ができるサービスに

高校時代に文化祭、行事で漫才やコントを披露するために相方を探していましたが、見つかりませんでした。  
同じように相方が見つからず、困っている人がいるのではないかと思いました。  
そういう背景から相方募集ができるように作成しました。

## この WEB サービスの強み

お笑いの相方募集に特化したサービスは掲示板形式のものが多く、メールアドレスや、LINE の ID などを書き込まないといけないが、
このサービスは**相方申請からコンビ結成までサービス上で完結**するので、安心して利用できます。  
掲示板だと相手が見えないが、プロフィール設定、タイムライン機能で**相手がどういう人物か知った上**で相方申請ができます。

# 画面一覧

## タイムライン

<img src="https://github.com/r-sugimoto/readme-folder/blob/master/comedy-sns/gif/post.gif">

## 相方募集投稿

<img src="https://github.com/r-sugimoto/readme-folder/blob/master/comedy-sns/gif/recruit.gif">

## マイページ

<img src="https://github.com/r-sugimoto/readme-folder/blob/master/comedy-sns/gif/mypage.gif">

## 相方申請管理

<img src="https://github.com/r-sugimoto/readme-folder/blob/master/comedy-sns/gif/partner.gif">

## チャット

<img src="https://github.com/r-sugimoto/readme-folder/blob/master/comedy-sns/gif/chat.gif">

## 設定

<img src="https://github.com/r-sugimoto/readme-folder/blob/master/comedy-sns/gif/setting.gif">

# 機能一覧

- ユーザー登録関連機能
- 新規登録、SNS ログイン機能(Twitter)
- ユーザー設定、退会機能
- 投稿機能
  - 相方募集の投稿、通常投稿(タイムライン)
    - 画像、動画アップロード(AWS S3 バケット)
    - Youtube 動画の埋め込み
- 相方申請機能
  - 相方申請の承認、否認
- 結成コンビ管理機能
  - コンビ名変更
  - コンビ解散
- 無限スクロール
  - 相方募集投稿、タイムライン一覧など
- タグ機能
  - プロフィール、各種投稿に設定可能
- 検索機能
  - フリーワード検索
  - タグ検索
  - 相方募集投稿検索(募集エリア、地域、世代検索)
- 通知機能(サイト内通知)
  - 相方申請、申請結果、コメント、DM の通知
- フラッシュメッセージ(投稿完了など)
- DM 機能
- フォロー機能
- いいね機能

# 使用技術

- フロントエンド
  - Javascript / Vue.js 2.6.12
  - HTML / CSS / Sass / Vuetify
  - VeeValidate(バリデーション)
  - vue-infinite-loading(無限スクロール)
- バックエンド
  - PHP 7.4.13 / Laravel 6.20.22
- インフラ
  - AWS(VPC、EC2、RDS、ACM、EBS、IAM、S3)
- その他使用ツール
  - Amazon SES (会員登録メール送信用)
  - circleci
  - Docker / docker-compose

# インフラ構成図

<img src="https://github.com/r-sugimoto/readme-folder/blob/master/comedy-sns/Untitled%20Diagram.png">

# 工夫した点

### 自分の募集条件にあったユーザー、気の合うユーザーを見逃さないように検索機能の充実化させました。

- フリーワード、タグ、募集条件（エリア、都道府県、年代）での絞り込み

### 検索機能のフローをシンプルにしました。

検索ボタンを押す  
 →VueRouter が URL のクエリを書き換える  
 → 親コンポーネントの watch が発火し、検索メソッドが実行するようにしました。  
 **小コンポーネントから親コンポーネントのメソッドを発火する必要がなくなり、シンプルに実装できました。**

### 動画アップロード機能、Youtube の埋め込みができるようにしました。

- 動画などを通してその人をより深く知る事ができ、コンビの結成に繋がりやすくなると思っています。

### フラッシュメッセージ、ローディングのくるくるを VueX で管理

- 毎回記述するのでは無く、VueX で管理する事でコード量の削減する事ができました。

### SNS から集客する想定だったので、Twitter ログインの実装しました。

### ページング機能で一覧ページを実装していましたが、ストレス無くご利用いただけるよう無限スクロールに変更しました。
