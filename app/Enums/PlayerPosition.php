<?php

namespace App\Enums;

use App\Traits\EnumListTrait;

enum PlayerPosition: string
{
    use EnumListTrait;

    case GoalKeeper = 'goalkeeper';

    case Defender = 'defender';

    case MidFielder = 'midfielder';

    case Striker = 'striker';
}
