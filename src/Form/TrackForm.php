<?php
declare(strict_types=1);

namespace Tc\Form;

use GibsonOS\Core\Dto\Form\Button;
use GibsonOS\Core\Dto\Form\ModelFormConfig;
use GibsonOS\Core\Dto\Parameter\StringParameter;
use GibsonOS\Core\Form\AbstractModelForm;
use Override;
use Tc\Model\Track;

/**
 * @extends AbstractModelForm<Track>
 */
class TrackForm extends AbstractModelForm
{
    public function __construct()
    {
    }

    #[Override]
    protected function getFields(ModelFormConfig $config): array
    {
        return [
            'name' => new StringParameter('Name'),
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
