<?php

namespace Packages\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Packages\Project\Http\Libraries\FileDownload;
use Packages\Project\Usecase\ProjectDownloadByCursorUsecase;
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
        private ProjectDownloadUsecase $usecase,
        private ProjectDownloadByCursorUsecase $usecaseByCursor,
        private FileDownload $fileDownload,
    ) {}

    /**
     * プロジェクトデータをCSVでダウンロード
     */
    public function download(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // プロジェクトデータ取得
        $projects = $this->usecase->exec();

        // ダウンロード用一時ファイル作成
        $tempFile = $this->fileDownload->createDownloadFile(self::CSV_HEADER, $projects->toArray());

        // ファイルをストリームで返す
        return response()
            ->download($tempFile, self::CSV_FILENAME, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.self::CSV_FILENAME.'"',
            ])
            ->deleteFileAfterSend(true);
    }

    /**
     * プロジェクトデータをCSVでダウンロード
     */
    public function lazy(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // プロジェクトデータ取得
        $projects = $this->usecase->lazy();

        // ダウンロード用一時ファイル作成
        $tempFile = $this->fileDownload->createDownloadFileWithLazyCollection(self::CSV_HEADER, $projects);

        // ファイルをストリームで返す
        return response()
            ->download($tempFile, self::CSV_FILENAME, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.self::CSV_FILENAME.'"',
            ])
            ->deleteFileAfterSend(true);
    }

    /**
     * プロジェクトデータをCSVでダウンロード（Cursor）
     */
    public function logic(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // プロジェクトデータ取得
        $projects = $this->usecaseByCursor->exec();

        // ダウンロード用一時ファイル作成
        $tempFile = $this->fileDownload->createDownloadFileWithLazyCollection(self::CSV_HEADER, $projects);

        // ファイルをストリームで返す
        return response()
            ->download($tempFile, self::CSV_FILENAME, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.self::CSV_FILENAME.'"',
            ])
            ->deleteFileAfterSend(true);
    }
}
