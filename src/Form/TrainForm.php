<?php
declare(strict_types=1);

namespace Tc\Form;

use GibsonOS\Core\Dto\Form\Button;
use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Dto\Parameter\FileParameter;
use GibsonOS\Core\Dto\Parameter\OptionParameter;
use GibsonOS\Core\Dto\Parameter\StringParameter;
use GibsonOS\Core\Form\AbstractModelForm;
use Override;
use Tc\Model\Train;
use Tc\Provider\TrainProvider;
use Tc\Strategy\Train\TrainStrategyInterface;

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
