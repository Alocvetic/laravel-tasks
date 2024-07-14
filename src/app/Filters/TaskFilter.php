<?php

namespace App\Filters;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskFilter
{
    public function __construct(
        protected Request $request,
        protected Builder $query,
    )
    {
        $this->query = Task::query();
    }

    public function buildQuery(Request $request): Builder
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
        foreach ($filterParams as $field => $data) {
            foreach ($data as $operator => $value) {
                if (isset($operatorsList[$operator])) {
                    $this->query->where($field, $operatorsList[$operator], $value);
                    continue;
                }

                match ($operator) {
                    'in' => $this->query->whereIn($field, $value),
                    'notIn' => $this->query->whereNotIn($field, $value),
                    'null' => $this->query->whereNull($field, $value),
                    'notNull' => $this->query->whereNotNull($field, $value),
                    default => null
                };
            }
        }
    }

    protected function page(): void
    {
        $pageParams = $this->request->input('page');
        foreach ($pageParams as $param => $value) {
            if ($param === 'offset') {
                $this->query->offset($value);
            }

            if ($param === 'limit') {
                $this->query->limit($value);
            }
        }
    }

    protected function fields(): void
    {
        $fieldsParams = explode(',', $this->request->input('fields'));
        $this->query->select($fieldsParams);
    }
}
