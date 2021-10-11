<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JsonRequest extends FormRequest
{
    public function getInt(string $key, int $default = 0): int
    {
        return (int)$this->json($key, $default);
    }

    public function getString(string $key, string $default = ''): string
    {
        return (string)$this->json($key, $default);
    }
}
