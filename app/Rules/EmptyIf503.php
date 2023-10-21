<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmptyIf503 implements Rule
{
    public function passes($attribute, $value)
    {
        return $value !== '+503';
    }

    public function message()
    {
        return 'Este campo es requerido.';
    }
}
