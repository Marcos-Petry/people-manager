<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'filters' => $this->normalizeFilters($this->input('filters', [])),
        ]);
    }

    public function rules(): array
    {
        return [
            'filters' => ['nullable', 'array'],

            'filters.*.field' => [
                'nullable',
                'in:name,cpf,type,phone,email',
            ],

            'filters.*.operator' => [
                'nullable',
                'in:contains,equals,starts_with,ends_with',
            ],

            'filters.*.value' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    private function normalizeFilters(mixed $filters): array
    {
        if (!is_array($filters)) {
            return [];
        }

        $normalized = [];

        foreach ($filters as $filter) {
            $normalized[] = $this->normalizeFilter($filter);
        }

        return $normalized;
    }

    private function normalizeFilter(mixed $filter): array
    {
        $field = $filter['field'] ?? null;
        $operator = $filter['operator'] ?? null;
        $value = $this->normalizeValue($field, $filter['value'] ?? null);

        return [
            'field' => $field,
            'operator' => $operator,
            'value' => $value,
        ];
    }

    private function normalizeValue(?string $field, mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        if (in_array($field, ['cpf', 'phone'], true)) {
            return preg_replace('/\D/', '', $value);
        }

        if ($field === 'type') {
            return $this->normalizeTypeValue($value);
        }

        return $value;
    }

    private function normalizeTypeValue(string $value): string
    {
        $value = mb_strtolower($value);

        return match ($value) {
            'física' => 'fisica',
            'jurídica' => 'juridica',
            default => $value,
        };
    }
}