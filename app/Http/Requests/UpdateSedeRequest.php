<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSedeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cupo_motos' => 'required|integer|min:0',
            'cupo_carros' => 'required|integer|min:0',

            'tarifa_hora_motos' => 'required|decimal:0,2|min:0',
            'tarifa_hora_carros' => 'required|decimal:0,2|min:0',

            'tarifa_minutos_motos' => 'required|decimal:0,2|min:0',
            'tarifa_minutos_carros' => 'required|decimal:0,2|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            // Cupos
            'cupo_motos.required' => 'Debe ingresar la cantidad de cupos para motos.',
            'cupo_motos.integer'  => 'Los cupos para motos deben ser un número entero.',
            'cupo_motos.min'      => 'Los cupos para motos no pueden ser negativos.',

            'cupo_carros.required' => 'Debe ingresar la cantidad de cupos para carros.',
            'cupo_carros.integer'  => 'Los cupos para carros deben ser un número entero.',
            'cupo_carros.min'      => 'Los cupos para carros no pueden ser negativos.',

            // Tarifas por hora
            'tarifa_hora_motos.required' => 'Debe ingresar la tarifa por hora para motos.',
            'tarifa_hora_motos.decimal'  => 'La tarifa por hora para motos debe tener máximo 2 decimales.',
            'tarifa_hora_motos.min'      => 'La tarifa por hora para motos no puede ser negativa.',

            'tarifa_hora_carros.required' => 'Debe ingresar la tarifa por hora para carros.',
            'tarifa_hora_carros.decimal'  => 'La tarifa por hora para carros debe tener máximo 2 decimales.',
            'tarifa_hora_carros.min'      => 'La tarifa por hora para carros no puede ser negativa.',

            // Tarifas por minuto
            'tarifa_minutos_motos.required' => 'Debe ingresar la tarifa por minuto para motos.',
            'tarifa_minutos_motos.decimal'  => 'La tarifa por minuto para motos debe tener máximo 2 decimales.',
            'tarifa_minutos_motos.min'      => 'La tarifa por minuto para motos no puede ser negativa.',

            'tarifa_minutos_carros.required' => 'Debe ingresar la tarifa por minuto para carros.',
            'tarifa_minutos_carros.decimal'  => 'La tarifa por minuto para carros debe tener máximo 2 decimales.',
            'tarifa_minutos_carros.min'      => 'La tarifa por minuto para carros no puede ser negativa.',

        ];
    }
}
