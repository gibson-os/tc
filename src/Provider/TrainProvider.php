<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Provider;

use GibsonOS\Core\Attribute\GetServices;
use GibsonOS\Module\Tc\Model\Train;
use GibsonOS\Module\Tc\Strategy\Train\TrainStrategyInterface;

class TrainProvider
{
    /** @var array<class-string<TrainStrategyInterface>, TrainStrategyInterface> */
    private readonly array $trainStrategies;

    /**
     * @param TrainStrategyInterface[] $trainStrategies
     */
    public function __construct(
        #[GetServices(['tc/src/Strategy/Train'], TrainStrategyInterface::class)]
        array $trainStrategies,
    ) {
        foreach ($trainStrategies as $trainStrategy) {
            $this->trainStrategies[$trainStrategy::class] = $trainStrategy;
        }
    }

    public function getStrategy(Train $train): TrainStrategyInterface
    {
        return $this->trainStrategies[$train->getStrategy()];
    }

    /**
     * @return array<class-string<TrainStrategyInterface>, TrainStrategyInterface>
     */
    public function getStrategies(): array
    {
        return $this->trainStrategies;
    }
}
