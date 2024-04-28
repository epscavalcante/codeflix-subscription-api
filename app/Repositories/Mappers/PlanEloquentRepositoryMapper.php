<?php

namespace App\Repositories\Mappers;

use App\Models\Plan as PlanModel;
use Core\Plan\Domain\Plan;
use Core\Shared\Domain\Uuid;

class PlanEloquentRepositoryMapper
{
    /**
     * @param  Plan  $plan
     */
    public static function toModel(object $plan): PlanModel
    {
        $model = new PlanModel();
        $model->plan_id = $plan->getId()->getValue();
        $model->name = $plan->name;
        $model->description = $plan->description;

        return $model;
    }

    public static function toEntity(PlanModel $model): Plan
    {
        return new Plan(
            planId: new Uuid($model->plan_id),
            name: $model->name,
            description: $model->description,
        );
    }
}
