<?php

namespace Packages\Project\Http\Libraries;

use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Packages\Project\Exports\Dto\CsvRowDto;

/**
 * ファイルダウンロード
 */
class FileDownload
{
    /**
     * ダウンロード用一時ファイル作成
     *
     * @param  array  $header  CSVヘッダー
     * @param  array  $csvData  CSVデータ
     * @return 一時ファイル名
     */
    public function createDownloadFile(
        array $header,
        array $csvData
    ): string {
        $tempFile = $this->generateTempFileName();

        // 一時ファイルを開く
        $handle = fopen($tempFile, 'w');

        // CSVヘッダーを書き込む
        fputcsv($handle, $header);

        // CSVデータを書き込む
        foreach ($csvData as $row) {
            fputcsv($handle, (array) $row);
        }

        // ファイルハンドルを閉じる
        fclose($handle);

        return $tempFile;
    }

    /**
     * ダウンロード用一時ファイル作成
     *
     * @param  array  $header  CSVヘッダー
     * @param  LazyCollection<\Packages\Project\Exports\Dto\CsvRowDto>  $csvDataCollection  CSVデータCollection
     * @return 一時ファイル名
     */
    public function createDownloadFileWithLazyCollection(
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
            ->each(function (CsvRowDto $dto) use ($handle) {
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
