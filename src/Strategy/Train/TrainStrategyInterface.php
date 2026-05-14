<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Strategy\Train;

use GibsonOS\Core\Dto\Form\Button;
use GibsonOS\Core\Dto\Parameter\AbstractParameter;
use GibsonOS\Module\Tc\Model\Train;

interface TrainStrategyInterface
{
    public function getMaxSpeed(): int;

    public function send(Train $train, Train $originalTrain, ?string $action = null): void;

    /**
     * @return array<string, AbstractParameter>
     */
    public function getConfigFields(Train $train): array;

    /**
     * @return array<string, Button>
     */
    public function getConfigButtons(Train $train): array;
}
