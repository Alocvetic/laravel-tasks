<?php

namespace App\Filters;

use App\Http\Requests\GetTasksRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;

class TaskFilter
{
    public function __construct(
        protected GetTasksRequest $request,
        protected Builder $query,
    ) {
        $this->query = Task::query();
    }

    public function buildQuery(GetTasksRequest $request): Builder
    {
        $this->request = $request;

        if ($request->has('sort')) {
            $this->sort();
        }

        if ($request->has('filter')) {
            $this->filter();
        }

        if ($request->has('page')) {
            $this->page();
        }

        if ($request->has('fields')) {
            $this->fields();
        }

        return $this->query;
    }

    protected function sort(): void
    {
        $sortParams = explode(',', $this->request->input('sort'));
        foreach ($sortParams as $sort) {
            if ($sort[0] === '-') {
                $this->query->orderBy(substr($sort, 1), 'desc');
            } else {
                $this->query->orderBy($sort);
            }
        }
    }

    protected function filter(): void
    {
        $operatorsList = [
            'lt' => '<',
            'lte' => '<=',
            'gt' => '>',
            'gte' => '>=',
            'eq' => '=',
            'ne' => '<>',
        ];

        $filterParams = $this->request->input('filter');
        foreach ($filterParams as $column => $data) {
            foreach ($data as $operator => $value) {
                if (isset($operatorsList[$operator])) {
                    $this->query->where($column, $operatorsList[$operator], $value);
                    continue;
                }

                $taskStatusUuidList = explode(',', $value);
                match ($operator) {
                    'in' => $this->query->whereIn($column, $taskStatusUuidList),
                    'notIn' => $this->query->whereNotIn($column, $taskStatusUuidList),
                    default => null
                };
            }
        }
    }

    protected function fields(): void
    {
        $fieldsParams = explode(',', $this->request->input('fields'));

        foreach ($fieldsParams as $key => $column) {
            if (str_contains($column, ':')) {
                $joinColumn = explode(':', $column);

                if ($joinColumn[0] === 'task_status_uuid') {
                    $fieldsParams[$key] = 'task_statuses.' . $joinColumn[1] . ' AS ' . 'task_status_' . $joinColumn[1];
                }
            } else {
                $fieldsParams[$key] = 'tasks.' . $column;
            }
        }

        $this->query->leftJoin('task_statuses', 'tasks.task_status_uuid', '=', 'task_statuses.uuid')
            ->select($fieldsParams);
    }

    protected function page(): void
    {
        $pageParams = $this->request->input('page');
        foreach ($pageParams as $param => $value) {
            if ($param === 'limit') {
                $this->query->limit((int)$value);
            }

            if ($param === 'offset') {
                $this->query->offset((int)$value);
            }
        }
    }

    /**
     * Получение данных для пагинации
     *
     * @return array|null
     */
    public function buildPaginateData(): array|null
    {
        $pageParams = $this->request->input('page');

        $paginateData = null;
        if (isset($pageParams['limit']) && isset($pageParams['number'])) {
            $paginateData['limit'] = (int)$pageParams['limit'];
            $paginateData['number'] = (int)$pageParams['number'];
        }

        return $paginateData;
    }
}
