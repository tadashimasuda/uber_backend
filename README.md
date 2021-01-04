#README
## Backend(API)
Frontend( [github]:https://github.com/tadashimasuda/uber_frontend )

## 作った理由
    自分自身のuber配達経験とTwitterで配達履歴を報告するユーザーが多数見かけられたので制作。Uber配達は収入増加のため効率よく回りたいのでそれなりの情報がほしい。よって、情報共有可能なサービスを制作。

## アプリ概要 (URL:[ https://uber-post.netlify.app],DBサーバーの関係によりデータが上手く表示されないときがあります。各ページは下記に記載してあります。)
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
- ユーザーランキング表示（報酬額順）

## 各ページ
<img src="https://user-images.githubusercontent.com/51233312/103509556-bf8a9480-4ea6-11eb-9d7f-5e2b2aae2842.png" width="20%" ><img src="https://user-images.githubusercontent.com/51233312/103509562-c1545800-4ea6-11eb-8b7c-ae7325573cc9.png" width="20%" ><img src="https://user-images.githubusercontent.com/51233312/103509563-c1ecee80-4ea6-11eb-932d-eb018fbff442.png" width="20%" ><img src="https://user-images.githubusercontent.com/51233312/103509564-c2858500-4ea6-11eb-84e3-4bf36b982e0f.png" width="20%" ><img src="https://user-images.githubusercontent.com/51233312/103509567-c31e1b80-4ea6-11eb-9e31-d1f144d90af6.png" width="20%" ><img src="https://user-images.githubusercontent.com/51233312/103509568-c3b6b200-4ea6-11eb-9b7a-318fcdf641e7.png" width="20%" >

- 生成される画像イメージ(投稿機能)
<img src="https://uber-s3.s3-ap-northeast-1.amazonaws.com/post/13e343b9-fdc8-4f52-a6cf-d6bc2798e891" width="50%" height="50%">

## 使用した言語、技術、サービス
- 言語
    - Frontend : Nuxt.js
    - Backend : Laravel

- DB
    - Mysql

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
        
## 課題
   - Twitter連携の実装
   - デザインの修正
   - ドメインの取得
