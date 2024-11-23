<?php

namespace Packages\Project\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Packages\Project\Exports\Dto\CsvRowDto;
use Packages\Project\Infra\Query\ProjectListJoinQuery;

/**
 * プロジェクトのエクスポート（ロジックあり）
 *
 * メモリ使用量: 229MB
 */
class ProjectsExportWithLogic implements FromCollection, WithHeadings
{
    public function __construct(
        protected ProjectListJoinQuery $query
    ) {}

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // クエリ実行
        $projects = $this->query->get();

        /** @var \Illuminate\Support\Collection<CsvRowDto|[]> */
        $list = collect([]);
        /** @var CsvRowDto|null */
        $csvRow = null;
        foreach ($projects as $idx => $project) {
            if ($idx === 0 || $csvRow !== null && $project->id !== $csvRow->id) {
                // 最初のデータの場合と$projectのidが$csvRow->idと異なる場合は、$csvRowを新たに生成する
                $csvRow = new CsvRowDto(
                    $project->id,
                    $project->name,
                    $project->description,
                    $project->created_at,
                    $project->updated_at,
                    $project->task_id,
                    $project->task_name,
                    $project->task_description,
                );
                $list->push($csvRow);
            } else {
                // $projectのidが$prevProjectIdと同じ場合は、addTask()する
                $csvRow->addTask($project->task_id, $project->task_name, $project->task_description);
            }
        }

        return $list;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Created At',
            'Updated At',
            'Tasks',
        ];
    }
}
