<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Criteria\Criterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * @mixin Builder
 * @method Builder filter(InputBag $query)
 */
class Model extends EloquentModel
{
    /**
     * @param Builder $builder
     * @param InputBag $query
     * @return Builder
     */
    public function scopeFilter(Builder $builder, InputBag $query): Builder
    {
        $criterion = $this->newCriterion();
        if ($criterion instanceof FilterInterface) {
            $criterion->setBuilder($builder);
            $criterion->setQuery($query);
            $criterion->filter();
        }

        return $builder;
    }


    /**
     * @return FilterInterface
     */
    public function newCriterion(): FilterInterface
    {
        return new Criterion();
    }
}
