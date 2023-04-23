<?php

namespace App\Data\Resource;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class UserData extends Data
{
    public function __construct(
        public string $id,
        public string $email,
        public string $name,
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public ?Carbon $created_at,
        public bool $is_admin
    ) {
    }
}
