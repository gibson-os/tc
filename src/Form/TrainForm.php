<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Form;

use GibsonOS\Core\Dto\Form\Button;
use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Dto\Parameter\EnumParameter;
use GibsonOS\Core\Dto\Parameter\FileParameter;
use GibsonOS\Core\Dto\Parameter\StringParameter;
use GibsonOS\Core\Form\AbstractModelForm;
use GibsonOS\Core\Manager\ReflectionManager;
use GibsonOS\Module\Tc\Enum\TrainStrategy;
use GibsonOS\Module\Tc\Model\Train;
use Override;

/**
 * @extends AbstractModelForm<Train>
 */
class TrainForm extends AbstractModelForm
{
    public function __construct(private readonly ReflectionManager $reflectionManager)
    {
    }

    #[Override]
    protected function getFields(ModelFormConfig $config): array
    {
        return [
            'name' => new StringParameter('Name'),
            'image' => new FileParameter('Bild', 'Auswählen'),
            'strategy' => new EnumParameter($this->reflectionManager, 'System', TrainStrategy::class),
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
