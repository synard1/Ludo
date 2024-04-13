<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class SuperAdminScope implements Scope
{
public function apply(Builder $builder, Model $model)
{
    if (!$this->isSuperAdmin()) {
        $this->excludeSoftDeletedRecords($builder, $model);
    }
}

private function isSuperAdmin()
{
    return Auth::check() && Auth::user()->hasRole('Super Admin');
}

private function excludeSoftDeletedRecords(Builder $builder, Model $model)
{
    $builder->whereNull($model->getQualifiedDeletedAtColumn());
}

}               