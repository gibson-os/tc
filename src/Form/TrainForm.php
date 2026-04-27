<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Form;

use GibsonOS\Core\Dto\Form\Button;
use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Dto\Parameter\FileParameter;
use GibsonOS\Core\Dto\Parameter\OptionParameter;
use GibsonOS\Core\Dto\Parameter\StringParameter;
use GibsonOS\Core\Form\AbstractModelForm;
use GibsonOS\Module\Tc\Model\Train;
use GibsonOS\Module\Tc\Provider\TrainProvider;
use GibsonOS\Module\Tc\Strategy\Train\TrainStrategyInterface;
use Override;

/**
 * @extends AbstractModelForm<Train>
 */
class TrainForm extends AbstractModelForm
{
    public function __construct(private readonly TrainProvider $trainProvider)
    {
    }

    #[Override]
    protected function getFields(ModelFormConfig $config): array
    {
        return [
            'name' => new StringParameter('Name'),
            'imageFile' => new FileParameter('Bild', 'Auswählen'),
            'strategy' => new OptionParameter(
                'Strategie',
                array_map(
                    static fn (TrainStrategyInterface $strategy): string => $strategy::class,
                    $this->trainProvider->getStrategies(),
                ),
            ),
        ];
    }

    #[Override]
    protected function getButtons(ModelFormConfig $config): array
    {
        $train = $config->getModel();

        return [
            'save' => new Button(
                'Speichern',
                'tc',
                'train',
                '',
                ['id' => $train?->getId()],
            ),
        ];
    }

    #[Override]
    protected function supportedModel(): string
    {
        return Train::class;
    }
}
