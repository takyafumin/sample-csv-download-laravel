# CSVダウンロード機能で検討すべきこと

CSVダウンロード機能実装時に考慮しておくべきことを検討するためのサンプル

## 環境

- php: 8.3.13
- DB: sqlite

## 使い方

- リポジトリをクローンする
- `composer install` でライブラリをインストールする
- `.env.example` をコピーして `.env` ファイルを作成する
- `php artisan migrate` で DB マイグレーションする
- `php artisan db:seed` でサンプルデータを作成する
- `php artisan ide-helper:generate` で開発用ヘルパーファイルを生成する
- `php artisan serve` で App サーバを起動する
- `http://localhost:8000/` にアクセスする

### ダウンロード機能

|          URL          |           機能           |                                    説明                                     |
| --------------------- | ------------------------ | --------------------------------------------------------------------------- |
| `/users/download`     | ユーザーダウンロード     | ユーザーデータをCSVでダウンロードする                                       |
| `/projects/data`      | プロジェクトダウンロード | プロジェクトデータを取得するがOKレスポンスだけを返す                        |
| `/projects/download`  | プロジェクトダウンロード | プロジェクトデータをCSVでダウンロードする                                   |
| `/projects/export`    | プロジェクトダウンロード | プロジェクトデータをCSVでダウンロードする(Laravel Export)                   |
| `/projects/chunk`     | プロジェクトダウンロード | プロジェクトデータをCSVでダウンロードする(Laravel Export with Chunk)        |
| `/projects/generator` | プロジェクトダウンロード | プロジェクトデータをCSVでダウンロードする(Laravel Export with Generator)    |
| `/projects/logic`     | プロジェクトダウンロード | プロジェクトデータをCSVでダウンロードする(Laravel Export with Custom Logic) |

## 考慮しておくべきこと

- 処理性能
- サーバ負荷
- 安定性
- 同時実行性
- セキュリティ

## 例えば・・・

- ユーザーデータが大きいとCSVを作るときにメモリが足りなくなる可能性がある
- 同時実行すると、一時ファイル名が重複する可能性がある
- エラー処理が不足している(ファイルハンドラの後処理が実行されない)
- 処理中にエラーが発生すると一時ファイルが残ってしまう
