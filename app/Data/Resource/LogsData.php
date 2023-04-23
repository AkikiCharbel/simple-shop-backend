<?php

namespace App\Data\Resource;

use App\Data\Transformers\CartProductTransformer;
use App\Data\Transformers\JsonTransformer;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

class LogsData extends Data
{
    public function __construct(
        public int $id,
        #[WithTransformer(CartProductTransformer::class)]
        public $description,
        public ?string $event_type,
        #[WithTransformer(JsonTransformer::class)]
        #[MapOutputName('user')]
        public string $causer,
        public Carbon $created_at,
        public Carbon $updated_at,
    ) {
    }

    public static function fromModel(Activity $activity): self
    {
        return new self(
            $activity->id,
            $activity->description,
            $activity->event,
            $activity->causer,
            $activity->created_at,
            $activity->updated_at,
        );
    }
}
