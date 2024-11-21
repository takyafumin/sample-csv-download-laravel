<?php

namespace Packages\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use Packages\Project\Usecase\ProjectDownloadUsecase;

/**
 * ProjectDownload Controller
 */
class ProjectDownloadDataController extends Controller
{
    public function __construct(
        private ProjectDownloadUsecase $usecase
    ) {}

    /**
     * ユーザーデータをCSVでダウンロード
     */
    public function __invoke()
    {
        // プロジェクトデータ取得
        $projects = $this->usecase->exec();

        // レスポンス
        return response('OK', 200);
    }
}
