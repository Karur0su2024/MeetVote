<?php

namespace App\Enums;

enum PollStatus: string
{
    case ACTIVE = 'active';
    case CLOSED = 'closed';
}
