<?php
declare(strict_types=1);

namespace Tc\Strategy\Train;

use GibsonOS\Core\Dto\Parameter\StringParameter;
use Override;
use Tc\Model\Train;

class MouldKingStrategy implements TrainStrategyInterface
{
    public function __construct()
    {
    }

    #[Override]
    public function getMaxSpeed(): int
    {
        return 10;
    }

    #[Override]
    public function send(Train $train): void
    {
    }

    #[Override]
    public function getConfigFields(): array
    {
        return [
            'apiUrl' => new StringParameter('API URL'),
            'deviceId' => new StringParameter('Device ID'),
        ];
    }
}
