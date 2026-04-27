<?php
declare(strict_types=1);

namespace Tc\Enum;

enum ElementDirection: int
{
    case NORTH = 1;
    case EAST = 2;
    case SOUTH = 3;
    case WEST = 4;
}
