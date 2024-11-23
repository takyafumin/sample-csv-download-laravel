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
        // レスポンス
        return response()->view('projects.data');
    }
}
