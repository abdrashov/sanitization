<?php

function data_get(array $data, string $key, string $default = ''): mixed
{
    if (!array_key_exists($key, $data)) {
        return $default;
    }

    return $data[$key];
}

function message(string $keys, string $attribute = ''): string
{
    $messages = include __DIR__ . '/../message/message.php';

    foreach (explode('.', $keys) as $key) {
        $messages = data_get($messages, $key);

        if (is_string($messages)) {
            break;
        }
    }

    return str_replace(':attribute', $attribute, $messages);
}
