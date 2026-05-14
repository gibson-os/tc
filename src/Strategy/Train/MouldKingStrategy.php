<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Strategy\Train;

use GibsonOS\Core\Dto\Parameter\EnumParameter;
use GibsonOS\Core\Dto\Parameter\IntParameter;
use GibsonOS\Core\Dto\Parameter\StringParameter;
use GibsonOS\Core\Manager\ReflectionManager;
use GibsonOS\Module\Tc\Client\MouldKingClient;
use GibsonOS\Module\Tc\Enum\MouldKingType;
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
    public function send(Train $train): void
    {
        $host = $train->getConfiguration()['apiUrl'];
        $power = $train->getSpeed() / 10;

        $this->mouldKingClient->connect($host, 3);
        $this->mouldKingClient->control($host, 3, 0, $power);
    }

    #[Override]
    public function getConfigFields(): array
    {
        return [
            'apiUrl' => new StringParameter('API URL'),
            'type' => new EnumParameter($this->reflectionManager, 'Typ', MouldKingType::class),
            'number' => new IntParameter('Nummer')->setRange(1, 3),
        ];
    }

    #[Override]
    public function getFunctionConfig(): array
    {
        return [
            [],
        ];
    }
}
