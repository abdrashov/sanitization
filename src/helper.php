<?php

function data_get(array $data, string $key, string $default = ''): mixed
{
    if (!array_key_exists($key, $data)) {
        return $default;
    }

    return $data[$key];
}

function message(string $values, string $attribute = ''): string
{
    $messages = include __DIR__ . '/../message/message.php';

    foreach (explode('.', $values) as $value) {
        $messages = data_get($messages, $value);

        if (is_string($messages)) {
            break;
        }
    }

    return str_replace(':attribute', $attribute, $messages);
}

function extract_class(string $className): string
{
    return str_replace(['/', '.php'], ['\\', ''],
        preg_replace('/^src\//', 'Abdrashov/Sanitization/', $className)
    );
}
