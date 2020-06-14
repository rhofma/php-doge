<?php

function validate(array $data, array $rules, array $messages = []): void
{
    if (!valid($data, $rules, $messages)) {
        back();
    }
}

function valid(array $data, array $rules, array $messages = []): bool
{
    $validationRules = rules();

    $errors = [];
    foreach ($rules as $field => $rule) {
        if (!$validationRules[$rule]($field, $data)) {
            $errors[] = isset($messages[$field], $messages[$field][$rule])
                ? $messages[$field][$rule]
                : error_message($field, $rule);
        }
    }

    errors($errors);

    return count($errors) === 0;
}

function rules(): array
{
    $required = fn ($field, $data) => isset($data[$field])
        && !empty($data[$field])
        && !is_null($data[$field]);

    $email = fn ($field, $data) => !isset($data[$field])
        || (isset($data[$field])
            && filter_var($data[$field], FILTER_VALIDATE_EMAIL));

    return compact('required', 'email');
}

function error_message(string $field, string $rule): string
{
    $messages = [
        'required' => $field . ' is required.',
        'email' => $field . ' is not a valid email address'
    ];

    return $messages[$rule];
}

function has_errors(): bool
{
    return isset($_SESSION['_errors']);
}

function errors(array $errors = []): array
{
    if (!empty($errors)) {
        $_SESSION['_errors'] = $errors;
        return $errors;
    }

    $errors = has_errors() ? $_SESSION['_errors'] : [];

    unset($_SESSION['_errors']);

    return $errors;
}
