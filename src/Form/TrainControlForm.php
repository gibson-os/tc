<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Form;

use GibsonOS\Core\Dto\Form\SubmitOnChange;
use GibsonOS\Core\Dto\Parameter\BoolParameter;
use GibsonOS\Core\Dto\Parameter\SliderParameter;
use GibsonOS\Module\Tc\Model\Train;
use GibsonOS\Module\Tc\Provider\TrainProvider;

class TrainControlForm
{
    public function __construct(private readonly TrainProvider $trainProvider)
    {
    }

    public function getForm(Train $train): array
    {
        return [
            'fields' => $this->getFields($train),
        ];
    }

    protected function getFields(Train $train): array
    {
        $strategy = $this->trainProvider->getStrategy($train);
        $configFields = $strategy->getConfigFields();
        $trainConfig = $train->getConfiguration();

        foreach ($configFields as $fieldName => $field) {
            $field->setValue($trainConfig[$fieldName] ?? null);
        }

        $submitOnChange = new SubmitOnChange(
            'tc',
            'train',
            'send',
        );

        return [
            'speed' => new SliderParameter('Geschwindigkeit', 0, $strategy->getMaxSpeed(), 1)
                ->setValue($train->getSpeed())
                ->setSubmitOnChange($submitOnChange),
            'direction' => new BoolParameter('Vorwärts')
                ->setValue($train->getDirection())
                ->setSubmitOnChange($submitOnChange),
        ] + $configFields;
    }
}
