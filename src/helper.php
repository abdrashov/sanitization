<?php

function data_get(array $data, string $key, string $default = ''): mixed
{
    if (!array_key_exists($key, $data)) {
        return $default;
    }

    return $data[$key];
}

function message(string $rule, string $field = ''): string
{
    $validations = include __DIR__ . '/message/message.php';

    return str_replace(':field', $field,
        data_get($validations, $rule)
    );
}