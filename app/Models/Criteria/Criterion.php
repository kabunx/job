<?php
declare(strict_types=1);

namespace App\Models\Criteria;

use App\Models\FilterInterface;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\InputBag;

class Criterion implements FilterInterface
{
    use GuessWhere;

    protected InputBag $query;

    protected Builder $builder;

    protected string $separator = ',';

    protected string $internalSeparator = ':';

    /**
     * 存在的索引，保证索引顺序
     *
     * @var array
     */
    protected array $indexes = [];

    protected array $columns = [];

    protected array $relations = [];

    protected array $withs = [];

    protected array $counts = [];

    protected array $sorts = [];

    public function filter(): void
    {
        $this->analyseQuery();
        $this->buildColumns();
        $this->buildRelations();
        $this->buildWiths();
        $this->buildCounts();
        $this->buildSorts();
    }

    /**
     * @param Builder $builder
     */
    public function setBuilder(Builder $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * @param InputBag $query
     */
    public function setQuery(InputBag $query): void
    {
        $this->query = $query;
    }

    protected function analyseQuery(): void
    {
        $queries = $this->query->all();
        foreach ($queries as $key => $value) {
            if ($key == 'withs') {
                $this->withs = explode($this->separator, $value);
            } elseif ($key == 'counts') {
                $this->counts = explode($this->separator, $value);
            } elseif ($key == 'sorts') {
                $sorts = explode($this->separator, $value);
                foreach ($sorts as $sort) {
                    [$column, $order] = array_pad(
                        explode($this->internalSeparator, $sort), 2, 'asc'
                    );
                    $this->sorts[$column] = $order;
                }
            } elseif (str_contains($key, '.')) {
                [$relation, $column] = explode('.', $key);
                $this->relations[$relation][$column] = $value;
            } else {
                $this->columns[$key] = $value;
            }
        }
    }

    protected function buildColumns()
    {
        foreach ($this->columns as $column => $value) {
            if ($method = $this->getCustomColumnQuery($column)) {
                $this->{$method}($value);
            } else {
                $this->guessWhere($this->builder, $column, $value);
            }
        }
    }

    protected function buildRelations()
    {
        foreach ($this->relations as $relation => $columns) {
            $this->builder->whereHas($relation, function (Builder $builder) use ($columns) {
                foreach ($columns as $column => $value) {
                    $this->guessWhere($builder, $column, $value);
                }
            });
        }
    }

    protected function buildWiths()
    {
        if ($this->withs) {
            $this->builder->with($this->withs);
        }
    }


    protected function buildCounts()
    {
        if ($this->counts) {
            $this->builder->withCount($this->counts);
        }
    }

    protected function buildSorts(): void
    {
        foreach ($this->sorts as $column => $direction) {
            $this->builder->orderBy($column, $direction);
        }
    }

    protected function getCustomColumnQuery(string $column): string
    {
        return '';
    }
}
