<?php

namespace Core\Shared\Domain;

use Illuminate\Support\Facades\Validator;

class IlluminateValidator implements ValidatorContract
{
    /**
     * @param  Entity  $entity
     */
    public function validate(object $entity, array $rules): void
    {
        $validator = Validator::make($entity->toArray(), $rules);
        $fails = $validator->fails();

        if ($fails) {
            foreach ($validator->errors()->toArray() as $field => $errors) {
                foreach ($errors as $error) {
                    $entity->notification->addError($error, $field);
                }
            }
        }
    }
}
