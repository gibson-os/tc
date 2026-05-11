<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Store;

use GibsonOS\Core\Store\AbstractDatabaseStore;
use GibsonOS\Module\Tc\Model\Track;
use Override;

/**
 * @extends AbstractDatabaseStore<Track>
 */
class TrackStore extends AbstractDatabaseStore
{
    #[Override]
    protected function getModelClassName(): string
    {
        return Track::class;
    }
}
