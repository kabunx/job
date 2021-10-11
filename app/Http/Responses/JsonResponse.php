<?php
declare(strict_types=1);

namespace App\Http\Responses;

use Kabunx\Hydrate\Entity;

class JsonResponse extends Entity
{
    public bool $success = true;

    public int $code = 0;

    public string $message = 'success';

    public array $data = [];
}
