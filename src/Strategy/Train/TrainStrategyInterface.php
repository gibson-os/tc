<?php
declare(strict_types=1);

namespace Tc\Strategy\Train;

use GibsonOS\Core\Dto\Parameter\AbstractParameter;
use Tc\Model\Train;

interface TrainStrategyInterface
{
    public function getMaxSpeed(): int;

    public function send(Train $train): void;

    /**
     * @return AbstractParameter[]
     */
    public function getConfigFields(): array;
}
