<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Store;

use GibsonOS\Core\Store\AbstractDatabaseStore;
use GibsonOS\Module\Tc\Model\Train;
use Override;

/**
 * @extends AbstractDatabaseStore<Train>
 */
class TrainStore extends AbstractDatabaseStore
{
    #[Override]
    protected function getModelClassName(): string
    {
        return Train::class;
    }
}
