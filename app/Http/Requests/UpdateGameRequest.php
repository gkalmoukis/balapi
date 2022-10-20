<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "team_a_id" => ['required', 'numeric', 'exists:teams,id'],
            "team_b_id" => ['required', 'numeric', 'exists:teams,id'],
            "team_a_goals" => ['required', 'numeric'],
            "team_b_goals" => ['required', 'numeric'],
        ];
    }
}
