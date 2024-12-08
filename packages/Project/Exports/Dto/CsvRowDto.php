<?php

namespace Packages\Project\Exports\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

/**
 * CSVの行データ
 */
class CsvRowDto implements Arrayable
{
    private array $tasks = [];

    /**
     * @param  int  $id  ID
     * @param  string  $name  プロジェクト名
     * @param  string  $description  プロジェクトの説明
     * @param  string  $created_at  作成日時
     * @param  string  $updated_at  更新日時
     * @param  array  $tasks  タスクのリスト
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $created_at,
        public readonly string $updated_at,
        array $tasks,
    ) {
        $this->tasks = $tasks;
    }

    /**
     * タスクを追加する
     */
    public function addTask(int $id, string $name, string $description): void
    {
        $this->tasks[] = [
            'id' => $id,
            'name' => $name,
            'description' => $description,
        ];
    }

    /**
     * 配列に変換
     *
     * @return array<string|int, mixed>
     */
    public function toArray()
    {
        // flatな配列に変換
        return [
            ...[
                $this->id,
                $this->name,
                $this->description,
                $this->created_at,
                $this->updated_at,
            ],
            ...Arr::flatten($this->tasks),
        ];
    }
}
