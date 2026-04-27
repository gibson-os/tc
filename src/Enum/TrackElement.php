<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Enum;

enum TrackElement: int
{
    case STRAIGHT = 0;
    case CURVE = 1;
    case LEFT_SWITCH = 2;
    case RIGHT_SWITCH = 3;
    case CROSSING_SWITCH = 4;
    case THREE_WAY_SWITCH = 5;
    case BUFFER_STOP = 7;
}
