<?php

namespace Packages\ProjectExport\Infra\Query;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

/**
 * プロジェクト一覧取得クエリ（JOIN）
 */
class ProjectListJoinQuery
{
    /**
     * プロジェクト一覧取得（プロジェクトごとにグループ化）
     */
    public function groupByProject(): LazyCollection
    {
        $cursor = LazyCollection::make($this->query()->cursor());

        // プロジェクトごとにグループ化
        return LazyCollection::make(function () use ($cursor) {
            $currentProjectId = null;
            $currentProject = null;

            foreach ($cursor as $row) {
                if ($row->id !== $currentProjectId) {
                    if ($currentProject !== null) {
                        yield $currentProject;
                    }

                    $currentProjectId = $row->id;
                    $currentProject = (object) [
                        'id' => $row->id,
                        'name' => $row->name,
                        'description' => $row->description,
                        'created_at' => $row->created_at,
                        'updated_at' => $row->updated_at,
                        'tasks' => [],
                    ];
                }

                if ($row->task_id !== null) {
                    $currentProject->tasks[] = (object) [
                        'id' => $row->task_id,
                        'name' => $row->task_name,
                        'description' => $row->task_description,
                    ];
                }
            }

            if ($currentProject !== null) {
                yield $currentProject;
            }
        });
    }

    /**
     * プロジェクト一覧取得クエリ生成
     */
    private function query(): Builder
    {
        return DB::table('projects')
            ->select([
                'projects.*',
                'tasks.id as task_id',
                'tasks.name as task_name',
                'tasks.description as task_description',
            ])
            ->leftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->orderBy('projects.id')
            ->orderBy('task_id');
    }
}
