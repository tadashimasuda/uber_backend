### Backend(API)
Frontend( [github]:https://github.com/tadashimasuda/uber_frontend )

## 作った理由
    自分自身のuber配達経験とTwitterで配達履歴を報告するユーザーが多数見かけられたので制作。Uber配達は収入増加のため効率よく回りたいのでそれなりの情報がほしい。よって、情報共有可能なサービスを制作。

## アプリ概要
Uber配達員の配達報告・管理サービス
1. ユーザーがアプリにアクセス
2. NuxtからLaravelのAPIを実行
3. AWS S3への投稿された画像の保存
4. フロントエンドのツイートリンクからツイート
5. TwitterからS3にアクセス

![uber](https://user-images.githubusercontent.com/51233312/103137855-29b97180-4710-11eb-9367-079a3fc00a69.png)


## 注力した点（Laravel）
- NuxtからBase64で画像がデコードされているのでエンコードした。
- エンコードされたデータのS３へのアップロード
- Corsの改善、理解

## 機能
- ログイン機能
- 新規登録機能
- ユーザー情報編集機能
- ユーザー詳細（投稿履歴、過去五日間のグラフデータ、これまでの獲得金額）
- ユーザー一覧
- 投稿機能
- 投稿一覧
- ページネーション

## 使用した言語、技術、サービス
- 言語
    - Frontend : Nuxt.js
    - Backend : Laravel

- DB
    -Mysql

- 技術
    - 認証周り
        jwt(json web token),Nuxt Auth module
    
    - Cors
        laravel-cors
    
    - 画像生成
        html2canvas

- サービス
    - ストレージサービス
        AWS S3
