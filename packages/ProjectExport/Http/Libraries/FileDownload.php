<?php

namespace Packages\ProjectExport\Http\Libraries;

use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Packages\ProjectExport\Usecase\Dto\ProjectTaskDto;

/**
 * ファイルダウンロード
 *
 * - Project/Libraries/FileDownloadと冗長だが、サンプルのため
 */
class FileDownload
{
    /**
     * ダウンロード用一時ファイル作成
     *
     * @param  array<string>  $header  CSVヘッダー
     * @param  LazyCollection<ProjectTaskDto>  $csvDataCollection  出力データCollection
     * @return 一時ファイル名
     */
    public function createDownloadFile(
        array $header,
        LazyCollection $csvDataCollection
    ): string {
        $tempFile = $this->generateTempFileName();

        // 一時ファイルを開く
        $handle = fopen($tempFile, 'w');

        // CSVヘッダーを書き込む
        fputcsv($handle, $header);

        // CSVデータを書き込む
        $csvDataCollection
            ->each(function (ProjectTaskDto $dto) use ($handle) {
                fputcsv($handle, $dto->toArray());
            });

        // ファイルハンドルを閉じる
        fclose($handle);

        return $tempFile;
    }

    /**
     * 一時ファイル名生成
     */
    private function generateTempFileName(): string
    {
        return sys_get_temp_dir().'/'.(string) Str::uuid().'.csv';
    }
}
