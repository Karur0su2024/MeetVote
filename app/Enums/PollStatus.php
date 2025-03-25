<?php

namespace App\Enums;

enum PollStatus: string
{
    case ACTIVE = 'active';
    case CLOSED = 'closed';

    public function toggle(): self
    {
        if($this === self::ACTIVE) {
            return self::CLOSED;
        }
        return self::ACTIVE;
    }
}
