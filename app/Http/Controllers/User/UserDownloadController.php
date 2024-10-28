<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Packages\User\Usecase\UserDownloadUsecase;

/**
 * UserDownload Controller
 */
class UserDownloadController extends Controller
{
    /**
     * CSVヘッダー
     * @var string[]
     */
    private const CSV_HEADER = ['id', 'name', 'email', 'created_at', 'updated_at'];

    /**
     * CSVファイル名
     * @var string
     */
    private const CSV_FILENAME = 'users.csv';

    /**
     * @param UserDownloadUsecase $usecase
     */
    public function __construct(
        private UserDownloadUsecase $usecase
    ) {}

    /**
     * ユーザーデータをCSVでダウンロード
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function __invoke(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // ユーザーデータ取得
        $users   = $this->usecase->exec();
        $csvData = $users->toArray();

        // ダウンロード用一時ファイル作成
        $tempFile = $this->createDownloadFile($csvData);

        // ファイルをストリームで返す
        return response()
            ->download($tempFile, self::CSV_FILENAME, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . self::CSV_FILENAME . '"',
            ])
            ->deleteFileAfterSend(true);
    }

    /**
     * @param array $csvData
     * @return 一時ファイル名
     */
    private function createDownloadFile(array $csvData): string
    {
        // タイムスタンプを使用して一時ファイルの名前を決定
        $timestamp = now()->format('YmdHis');
        $tempFile = sys_get_temp_dir() . "/users_{$timestamp}.csv";

        // 一時ファイルを開く
        $handle = fopen($tempFile, 'w');

        // CSVヘッダーを書き込む
        fputcsv($handle, self::CSV_HEADER);

        // CSVデータを書き込む
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        // ファイルハンドルを閉じる
        fclose($handle);

        return $tempFile;
    }
}
