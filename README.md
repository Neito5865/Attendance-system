# Atte（アット）
企業の勤怠管理システム。勤怠の打刻とユーザーの勤務時間の管理ができるアプリとなっています。

<img width="1015" alt="top-page" src="https://github.com/user-attachments/assets/0fe8401a-f106-4392-9627-430895a247ed">

## 作成した目的
人事評価のため。

## アプリケーションURL
デプロイのURLを貼り付ける。
ログインなどがあれば、注意事項など。

## 他のリポジトリ
関連するリポジトリがあれば記載する。

## 機能一覧
- 会員登録
- ログイン機能
- ログアウト機能
- 勤務開始
- 勤務終了
- 休憩開始
- 休憩終了
- 日付別勤怠情報の取得
- ページネーション

## 使用技術
- PHP 7.4.9
- Laravel 8.0
- MySQL 8.0.26

## テーブル設計
< --- テーブル設計の画像 --- >

## ER図
![er drawio](https://github.com/user-attachments/assets/119c15a9-e7f2-4e48-a318-91026a0b0e87)

## 環境構築
1. リポジトリのクローン
```
git clone git@github.com:Neito5865/Attendance-system.git
docker-compose up -d --build
```
＊MySQLは、OSによって起動しない場合があるので、それぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。

2. Dockerのビルド
```
cd contact-form app
docker-compose up -d --build
```

### Laravel環境構築
1. PHPコンテナへログイン
```
docker-compose exec php bash
```

2. パッケージのインストール
```
composer install
```

3. .env.exampleファイルから.envファイルを作成する
```
cp .env.example .env
```

4. 環境変数を変更する
.envファイルの11行目以降を以下のように編集する
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

5. キーを作成する
```
php artisan key:generate
```

### URL
- 勤怠打刻トップページ： http://localhost/  
＊アクセスするとログイン認証機能によりログイン画面へ遷移します。

- 管理画面： http://localhost/admin  
＊管理画面へアクセスするとログイン認証機能によりログイン画面へ遷移します。

- phpMyAdmin
http://localhost:8080

## その他
アカウントの種類（テストユーザーなど）
