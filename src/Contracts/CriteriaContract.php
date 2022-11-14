<?php declare(strict_types=1);

namespace TarasovKrk\LaravelRepository\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CriteriaContract
{
    public function apply(Builder $query);
}
