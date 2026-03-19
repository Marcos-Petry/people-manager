<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf ?? ''),
            'phone' => preg_replace('/\D/', '', $this->phone ?? ''),
            'email' => strtolower($this->email ?? ''),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $person = $this->route('person');

        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => [
                'required',
                'digits:11',
                Rule::unique('people', 'cpf')->ignore($person->id),
            ],
            'type' => ['required', 'in:fisica,juridica'],
            'phone' => ['required', 'digits_between:10,11'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('people', 'email')->ignore($person->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.digits' => 'O CPF deve conter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',

            'type.required' => 'O tipo é obrigatório.',
            'type.in' => 'O tipo deve ser física ou jurídica.',

            'phone.required' => 'O telefone é obrigatório.',
            'phone.digits_between' => 'O telefone deve conter entre 10 e 11 dígitos.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O e-mail deve ter no máximo 255 caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado.',
        ];
    }
}