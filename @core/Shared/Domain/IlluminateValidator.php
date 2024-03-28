<?php

namespace Core\Shared\Domain;

use Illuminate\Support\Facades\Validator;

class IlluminateValidator implements ValidatorContract
{
    public function validate(Notification $notification, array $data, array $rules): bool
    {
        $validator = Validator::make($data, $rules);
        $fails = $validator->fails();

        if ($fails) {
            foreach ($validator->errors()->toArray() as $field => $errors) {
                foreach ($errors as $error) {
                    $notification->addError($error, $field);
                }
            }
        }

        return $fails;
    }
}
