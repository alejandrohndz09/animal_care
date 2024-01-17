<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;


class TokenExist implements Rule
{
    public function passes($attribute, $value)
    {
        return Usuario::where('token', Hash::make($value))->exists();;
    }

    public function message()
    {
        return 'El código ingresado no es válido.';
    }
}
