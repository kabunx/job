<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\InputBag;

interface FilterInterface
{

    public function filter(): void;

    public function setBuilder(Builder $builder): void;

    public function setQuery(InputBag $query): void;
}
