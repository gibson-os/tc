<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Install;

use Generator;
use GibsonOS\Core\Dto\Install\Success;
use GibsonOS\Core\Exception\CreateError;
use GibsonOS\Core\Exception\Model\SaveError;
use GibsonOS\Core\Exception\Repository\SelectError;
use GibsonOS\Core\Install\AbstractInstall;
use GibsonOS\Core\Service\InstallService;
use GibsonOS\Core\Service\PriorityInterface;
use JsonException;
use MDO\Exception\ClientException;
use MDO\Exception\RecordException;
use Override;
use ReflectionException;

class ImagePathInstall extends AbstractInstall implements PriorityInterface
{
    /**
     * @throws CreateError
     * @throws SaveError
     * @throws SelectError
     * @throws JsonException
     * @throws ClientException
     * @throws RecordException
     * @throws ReflectionException
     */
    #[Override]
    public function install(string $module): Generator
    {
        yield $imagePathInput = $this->getSettingInput(
            'tc',
            'imagePath',
            'What is the TC directory for Images?',
        );
        $imagePath = $this->dirService->addEndSlash($imagePathInput->getValue() ?? '');

        if (!file_exists($imagePath)) {
            $this->dirService->create($imagePath);
        }

        $this->setSetting('tc', 'imagePath', $imagePath);

        yield new Success('TC image directory set!');
    }

    #[Override]
    public function getPart(): string
    {
        return InstallService::PART_CONFIG;
    }

    #[Override]
    public function getModule(): string
    {
        return 'tc';
    }

    #[Override]
    public function getPriority(): int
    {
        return 500;
    }
}
