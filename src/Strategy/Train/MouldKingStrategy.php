<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Strategy\Train;

use GibsonOS\Core\Dto\Form\Button;
use GibsonOS\Core\Dto\Parameter\EnumParameter;
use GibsonOS\Core\Dto\Parameter\IntParameter;
use GibsonOS\Core\Dto\Parameter\StringParameter;
use GibsonOS\Core\Manager\ReflectionManager;
use GibsonOS\Module\Tc\Client\MouldKingClient;
use GibsonOS\Module\Tc\Enum\MouldKingType;
use GibsonOS\Module\Tc\Enum\TrainDirection;
use GibsonOS\Module\Tc\Model\Train;
use Override;

class MouldKingStrategy implements TrainStrategyInterface
{
    public function __construct(
        private readonly MouldKingClient $mouldKingClient,
        private readonly ReflectionManager $reflectionManager,
    ) {
    }

    #[Override]
    public function getMaxSpeed(): int
    {
        return 10;
    }

    #[Override]
    public function send(Train $train, ?Train $originalTrain, ?string $action = null): void
    {
        $host = $train->getConfiguration()['apiUrl'];
        $port = (int) $train->getConfiguration()['apiPort'];

        $deviceId = $train->getConfiguration()['type'] === MouldKingType::HUB4 ? 3 : 0;
        $deviceId += $train->getConfiguration()['number'] - 1;

        if ($action === 'connect') {
            $this->mouldKingClient->connect($host, $port, $deviceId);

            return;
        }

        $speed = $train->getSpeed();
        $direction = $train->getDirection();
        $power = $speed / 10;

        if ($direction === TrainDirection::BACKWARD) {
            $power = -$power;
        }

        $changed = false;

        if ($originalTrain?->getSpeed() !== $speed) {
            $changed = true;
        }

        if ($originalTrain?->getDirection() !== $direction) {
            $changed = true;
        }

        if ($changed) {
            $this->mouldKingClient->control($host, $port, $deviceId, 0, $power);
        }
    }

    #[Override]
    public function getConfigFields(Train $train): array
    {
        return [
            'apiUrl' => new StringParameter('API URL')
                ->setValue($train->getConfiguration()['apiUrl'] ?? null),
            'apiPort' => new StringParameter('API Port')
                ->setValue($train->getConfiguration()['apiPort'] ?? null),
            'type' => new EnumParameter($this->reflectionManager, 'Typ', MouldKingType::class)
                ->setValue($train->getConfiguration()['type'] ?? null),
            'number' => new IntParameter('Nummer')->setRange(1, 3)
                ->setValue($train->getConfiguration()['number'] ?? null),
        ];
    }

    #[Override]
    public function getConfigButtons(Train $train): array
    {
        return [
            'connect' => new Button(
                'Verbinden',
                'tc',
                'train',
                '',
                [
                    'id' => $train->getId(),
                    'action' => 'connect',
                ],
            ),
        ];
    }
}
