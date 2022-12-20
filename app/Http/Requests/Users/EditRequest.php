<?php

namespace App\Http\Requests\Users;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:15'],
            'img' => ['nullable', 'string'],
            'img_edit' => ['nullable', 'json'],
            'date' => ['nullable', 'date', function($attribute, $value, $fail) {
                $val = Carbon::createFromFormat('Y-m-d', $value);
                $min = Carbon::now();
                $res = $val->diff($min);

                if($res->invert == 0) {
                    if($res->y < 7) {
                        $fail('Возраст должен быть больше 7 лет.');
                    } elseif($res->y > 60) {
                        $fail('Возраст должен быть меньше 60 лет.');
                    }
                } else {
                    $fail('Возраст должен быть больше 7 лет.');
                }
            }],
            'floor' => ['required', 'numeric', 'min:0', 'max:1'],
            'description' => ['nullable', 'string', 'max:250'],
            'games' => ['nullable', 'array']
        ];
    }
}
