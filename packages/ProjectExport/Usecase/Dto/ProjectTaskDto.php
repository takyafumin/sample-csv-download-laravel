<?php

namespace Packages\ProjectExport\Usecase\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

/**
 * プロジェクトデータ DTO(タスクを含む)
 */
class ProjectTaskDto implements Arrayable
{
    /**
     * @param  int  $id  ID
     * @param  string  $name  プロジェクト名
     * @param  string  $description  プロジェクトの説明
     * @param  string  $created_at  作成日時
     * @param  string  $updated_at  更新日時
     * @param  array<\stdclass>  $tasks  タスクのリスト
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $created_at,
        public readonly string $updated_at,
        private array $tasks,
    ) {}

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
            ...Arr::flatten(array_map(function ($task) {
                if ($task instanceof Arrayable) {
                    return $task->toArray();
                } elseif ($task instanceof \stdClass) {
                    // 正式には出力形式にあわせて配列形式を実装しないといけないが、サンプルのため
                    return (array) $task;
                }

                return $task;
            }, $this->tasks)),
        ];
    }
}
