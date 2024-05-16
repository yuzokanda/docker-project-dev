<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTodoRequest extends FormRequest
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
        // $dueDateTime = $this->input('due_date') . ' ' . $this->input('due_time');

        return [
            'task' => ['required', 'max:50'],
            'description' => ['required', 'max:255'],
            'due_date' => ['required'],
            'due_time' => ['required'],
            // 'due_date_time' => Rule::requiredIf(function () use ($dueDateTime) {
            //     return strtotime($dueDateTime) !== false;
            // }), 'after_or_equal:now'
        ];
    }
}
