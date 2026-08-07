<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        // Si tu ruta es algo como: PUT /users/{user}
        // y usa route model binding: User $user
        $user = $this->route('user'); // instancia de App\Models\User

        return [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id), // ignora el actual
            ],
            'dni'     => [
                'required',
                'string',
                Rule::unique('users', 'dni')->ignore($user->id),
            ],
            'phone'   => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }
}
