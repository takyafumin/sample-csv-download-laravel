<?php

namespace Packages\ProjectExport\Http\Controllers;

use App\Http\Controllers\Controller;
use Packages\ProjectExport\Http\Libraries\FileDownload;
use Packages\ProjectExport\Usecase\ProjectDownloadUsecase;

/**
 * プロジェクト一括出力 Controller
 */
class ProjectExportController extends Controller
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
    private const CSV_FILENAME = 'projects-export.csv';

    /**
     * @param  ProjectDownloadUsecase  $usecase  プロジェクト一括出力 Usecase
     * @param  FileDownload  $fileDownload  ファイルダウンロード Libraly
     */
    public function __construct(
        private ProjectDownloadUsecase $usecase,
        private FileDownload $fileDownload,
    ) {}

    /**
     * プロジェクトデータをCSVでダウンロード
     */
    public function cursor()
    {
        ini_set('memory_limit', '512M');

        // 出力データ取得
        $projects = $this->usecase->exec();

        // ダウンロード用一時ファイル作成
        $tempFile = $this->fileDownload->createDownloadFile(self::CSV_HEADER, $projects);

        // ファイルをストリームで返す
        return response()
            ->download($tempFile, self::CSV_FILENAME, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.self::CSV_FILENAME.'"',
            ])
            ->deleteFileAfterSend(true);
    }
}
