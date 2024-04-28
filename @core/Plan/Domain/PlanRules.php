<?php

namespace Core\Plan\Domain;

class PlanRules
{
    const RULES = [
        'planId' => [
            'required',
            'string',
        ],
        'name' => [
            'required',
            'string',
            'max: 100',
        ],
        'description' => [
            'required',
            'string',
            'max: 255',
        ],
    ];
}
