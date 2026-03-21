<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class PersonFilter
{
    public function apply(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $filter) {

            $field = $filter['field'] ?? null;
            $operator = $filter['operator'] ?? null;
            $value = $filter['value'] ?? null;

            if (!$field || !$operator || $value === null || $value === '') {
                continue;
            }

            switch ($operator) {

                case 'contains':
                    $query->where($field, 'like', "%{$value}%");
                    break;

                case 'equals':
                    $query->where($field, '=', $value);
                    break;

                case 'starts_with':
                    $query->where($field, 'like', "{$value}%");
                    break;

                case 'ends_with':
                    $query->where($field, 'like', "%{$value}");
                    break;
            }
        }

        return $query;
    }
}