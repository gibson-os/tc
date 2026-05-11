<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Form;

use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Dto\Parameter\BoolParameter;
use GibsonOS\Core\Dto\Parameter\SliderParameter;
use GibsonOS\Core\Exception\FormException;
use GibsonOS\Core\Form\AbstractModelForm;
use GibsonOS\Module\Tc\Model\Train;
use GibsonOS\Module\Tc\Provider\TrainProvider;
use Override;

/**
 * @extends AbstractModelForm<Train>
 */
class TrainControlForm extends AbstractModelForm
{
    public function __construct(private readonly TrainProvider $trainProvider)
    {
    }

    #[Override]
    protected function getFields(ModelFormConfig $config): array
    {
        $train = $config->getModel();

        if (!$train instanceof Train) {
            throw new FormException('Train not set');
        }

        $strategy = $this->trainProvider->getStrategy($train);

        return [
            'speed' => new SliderParameter('Geschwinidigkeit', 0, $strategy->getMaxSpeed(), 1),
            'direction' => new BoolParameter('Vorwärts'),
        ];
    }

    #[Override]
    protected function getButtons(ModelFormConfig $config): array
    {
        return [];
    }

    #[Override]
    protected function supportedModel(): string
    {
        return Train::class;
    }
}
