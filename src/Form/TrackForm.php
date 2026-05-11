<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Form;

use GibsonOS\Core\Dto\Form\Button;
use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Dto\Parameter\EnumParameter;
use GibsonOS\Core\Dto\Parameter\StringParameter;
use GibsonOS\Core\Form\AbstractModelForm;
use GibsonOS\Core\Manager\ReflectionManager;
use GibsonOS\Module\Tc\Enum\TrainStrategy;
use GibsonOS\Module\Tc\Model\Track;
use Override;

/**
 * @extends AbstractModelForm<Track>
 */
class TrackForm extends AbstractModelForm
{
    public function __construct(private readonly ReflectionManager $reflectionManager)
    {
    }

    #[Override]
    protected function getFields(ModelFormConfig $config): array
    {
        return [
            'name' => new StringParameter('Name'),
            'trainSystems[]' => new EnumParameter($this->reflectionManager, 'Systeme', TrainStrategy::class)
                ->setMultiple(true),
        ];
    }

    #[Override]
    protected function getButtons(ModelFormConfig $config): array
    {
        $track = $config->getModel();

        return [
            'save' => new Button(
                'Speichern',
                'tc',
                'track',
                '',
                ['id' => $track?->getId()],
            ),
        ];
    }

    #[Override]
    protected function supportedModel(): string
    {
        return Track::class;
    }
}
