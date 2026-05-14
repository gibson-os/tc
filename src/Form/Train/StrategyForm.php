<?php
declare(strict_types=1);

namespace src\Form\Train;

use GibsonOS\Core\Dto\Form\Button;
use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Dto\Parameter\AbstractParameter;
use GibsonOS\Core\Exception\FormException;
use GibsonOS\Core\Form\AbstractModelForm;
use GibsonOS\Module\Tc\Model\Train;
use GibsonOS\Module\Tc\Provider\TrainProvider;
use Override;

/**
 * @extends AbstractModelForm<Train>
 */
class StrategyForm extends AbstractModelForm
{
    public function __construct(private readonly TrainProvider $trainProvider)
    {
    }

    /**
     * @throws FormException
     *
     * @return array<string, AbstractParameter>
     */
    #[Override]
    protected function getFields(ModelFormConfig $config): array
    {
        $train = $config->getModel();

        if (!$train instanceof Train) {
            throw new FormException('Train not set');
        }

        return $this->trainProvider->getStrategy($train)->getConfigFields($train);
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
