<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Enum;

use GibsonOS\Module\Tc\Strategy\Train\MouldKingStrategy;
use GibsonOS\Module\Tc\Strategy\Train\TrainStrategyInterface;

enum TrainStrategy: string
{
    case MOULD_KING = 'Mould King';

    /**
     * @return class-string<TrainStrategyInterface>
     */
    public function getStrategyClass(): string
    {
        return match ($this) {
            self::MOULD_KING => MouldKingStrategy::class,
        };
    }
}
