<?php

namespace App\Enums;

use App\Traits\EnumListTrait;

enum PlayerTransferStatus: string
{
    use EnumListTrait;

    case Active = 'active';

    case Completed = 'completed';
}
