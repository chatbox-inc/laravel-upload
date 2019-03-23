# Laravel Image 

非認証で画像の一時アップロードを担当する API の作成

アプリケーション外部に設置したアップロード機構をベースに
アプリケーションは アップロード済みファイルの処理のみを取り扱うことができる。

## Functions

- [ ] Supply Upload API 
- [ ] Upload Validator
- [ ] 


## Configuration

```php
<?php
return [
    "routes" => [
        [
            "preifx" => "api/image",
            "driver" => "cache",
            "middleware" => ["api"]
        ]
    ],
    "drivers" => [
        "cache" => [
            "driver" => "cache",
            "options" => []
        ],
    ]
];
``` 

- routes : API のルート設定
- driver : File 処理で利用するドライバ

### Drivers

デフォルトの キャッシュドライバは、 Storage と Cache を使って実装がされています。






Laravel における画像処理API を自動化

POST /api/images
>
  file: base64 binary string
<
  file: 
    name: ファイル名
    dir: ファイルパス
    url: URL（あれば
    size: サイズ
    mime: MIME情報
    ext: MIME情報
  upload:
    status: processing/complete
    message: なにかしらのメッセージ
  
https://ja.wikipedia.org/wiki/Base64

Image を作成して DB に記録

アプリケーションからは slug を利用して問い合わせが可能

UploadService::byCode($code) // code を利用してファイル情報を取得

UploadService::cleanup($time) // 古いファイル情報を削除



