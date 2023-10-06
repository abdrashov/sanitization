<?php

function data_get(array $data, string|int $key, string|int|float|null $default = null): mixed
{
    if (!array_key_exists($key, $data)) {
        return $default;
    }

    return $data[$key];
}

function validation_message(string $rule, string $field = ''): mixed
{
    $validations = include __DIR__ . '/Validation/message.php';

    $message = data_get($validations, $rule);

    $message = str_replace(':field', $field, $message);

    return $message;
}