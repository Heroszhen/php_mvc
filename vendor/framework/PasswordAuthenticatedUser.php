<?php

namespace vendor\framework;

class PasswordAuthenticatedUser
{
    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function hash(string $data): string
    {
        return password_hash($data . $this->key, PASSWORD_DEFAULT);
    }

    public function verify(string $data, string $hash): bool
    {
        return password_verify($data . $this->key, $hash);
    }
}