<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('unique_with_state', function ($attribute, $value, $parameters, $validator) {
            // Obtén los parámetros necesarios para la validación
            $table = $parameters[0]; // Nombre de la tabla
            $stateColumn = $parameters[1]; // Nombre de la columna de estado
            $stateValue = $parameters[2]; // Valor de estado deseado (en este caso, 1)
            $exceptId = $parameters[3]; // ID a excluir (puede ser nulo)

            // Realiza la consulta para verificar la unicidad
            $query = DB::table($table)
                ->where($attribute, $value)
                ->where($stateColumn, $stateValue);

            // Excluye el ID especificado, si se proporciona
            if (!is_null($exceptId)) {
                $query->where('idMiembro', '!=', $exceptId);
            }

            return $query->count() === 0;
        });
    }
}
