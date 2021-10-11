<?php
declare(strict_types=1);

namespace App\Models\Criteria;

use Illuminate\Database\Eloquent\Builder;

trait GuessWhere
{

    protected string $pattern = '/\[(.*)\]/i';

    protected function guessWhere(Builder $builder, string $column, string $value)
    {
        preg_match_all($this->pattern, $value, $match);
        $search = $match[0][0] ?? '';
        $operator = $match[1][0] ?? '=';
        $value = str_replace($search, '', $value);
        if (in_array($operator, $builder->getQuery()->operators)) {
            $builder->where($column, $operator, $value);
        } else {
        }
    }

    protected function whereIn()
    {

    }
}
