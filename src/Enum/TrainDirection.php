<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Enum;

enum TrainDirection: int
{
    case FORWARD = 1;
    case BACKWARD = 2;
}
