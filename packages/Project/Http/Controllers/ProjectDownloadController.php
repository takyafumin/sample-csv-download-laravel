<?php

namespace Packages\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Packages\Project\Usecase\ProjectDownloadUsecase;

/**
 * ProjectDownload Controller
 */
class ProjectDownloadController extends Controller
{
    /**
     * CSVヘッダー
     *
     * @var string[]
     */
    private const CSV_HEADER = ['id', 'name', 'description', 'created_at', 'updated_at', 'tasks'];

    /**
     * CSVファイル名
     *
     * @var string
     */
    private const CSV_FILENAME = 'projects.csv';

    public function __construct(
        private ProjectDownloadUsecase $usecase
    ) {}

    /**
     * プロジェクトデータをCSVでダウンロード
     */
    public function __invoke(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // プロジェクトデータ取得
        $projects = $this->usecase->exec();
        $csvData = $projects->toArray();

        // ダウンロード用一時ファイル作成
        $tempFile = $this->createDownloadFile($csvData);

        // ファイルをストリームで返す
        return response()
            ->download($tempFile, self::CSV_FILENAME, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.self::CSV_FILENAME.'"',
            ])
            ->deleteFileAfterSend(true);
    }

    /**
     * @return 一時ファイル名
     */
    private function createDownloadFile(array $csvData): string
    {
        // タイムスタンプを使用して一時ファイルの名前を決定
        $timestamp = now()->format('YmdHis');
        $tempFile = sys_get_temp_dir()."/projects_{$timestamp}.csv";

        // 一時ファイルを開く
        $handle = fopen($tempFile, 'w');

        // CSVヘッダーを書き込む
        fputcsv($handle, self::CSV_HEADER);

        // CSVデータを書き込む
        foreach ($csvData as $row) {
            fputcsv($handle, (array) $row);
        }

        // ファイルハンドルを閉じる
        fclose($handle);

        return $tempFile;
    }
}
