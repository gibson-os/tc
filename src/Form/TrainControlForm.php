<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Form;

use GibsonOS\Core\Dto\Form\SubmitOnChange;
use GibsonOS\Core\Dto\Parameter\BoolParameter;
use GibsonOS\Core\Dto\Parameter\SliderParameter;
use GibsonOS\Module\Tc\Enum\TrainDirection;
use GibsonOS\Module\Tc\Model\Train;
use GibsonOS\Module\Tc\Provider\TrainProvider;
use GibsonOS\Module\Tc\Strategy\Train\TrainStrategyInterface;

class TrainControlForm
{
    public function __construct(private readonly TrainProvider $trainProvider)
    {
    }

    public function getForm(Train $train): array
    {
        $strategy = $this->trainProvider->getStrategy($train);

        return [
            'fields' => $this->getFields($strategy, $train),
            'buttons' => $strategy->getConfigButtons($train),
        ];
    }

    private function getFields(TrainStrategyInterface $strategy, Train $train): array
    {
        $submitOnChange = new SubmitOnChange(
            'tc',
            'train',
            '',
            ['id' => $train->getId()],
        );

        $fields = [
            'speed' => new SliderParameter('Geschwindigkeit', 0, $strategy->getMaxSpeed(), 1)
                ->setValue($train->getSpeed())
                ->setSubmitOnChange($submitOnChange),
            'direction' => new BoolParameter('Vorwärts')
                ->setInputValue(TrainDirection::FORWARD->name)
                ->setUncheckedValue(TrainDirection::BACKWARD->name)
                ->setValue($train->getDirection() === TrainDirection::FORWARD)
                ->setSubmitOnChange($submitOnChange),
        ];

        foreach ($strategy->getConfigFields($train) as $name => $field) {
            $fields[sprintf('configuration[%s]', $name)] = $field;
        }

        return $fields;
    }
}
