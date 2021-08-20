# comedy-sns-docker

## バージョン

Laravel6.8

## 環境構築

### Laravel 導入

docker-compose build

docker-compose up -d

docker-compose exec app bash

composer create-project --prefer-dist "laravel/laravel=6.8.*" comedy-sns

.env
docker-compose.ymlのdbコンテナの設定と合わせる

http://localhost:8000/
にアクセスし確認する

### Vue 導入

docker-compose exec app bash

cd comedy-sns

COMPOSER_MEMORY_LIMIT=-1 composer require laravel/ui:^1.0 --dev

php artisan ui vue --auth

npm install vue-router
npm install --save-dev vuex
npm install

npm run dev
エラー解消
$npm uninstall --save-dev sass-loader
$npm install --save-dev sass-loader@7.1.0

npm run watch

npm install --save-dev vuex

npm install vee-validate@3.* --save



## Laravel その他

composer require laravel/helpers

composer メモリエラー
COMPOSER_MEMORY_LIMIT=-1 何かあれば
