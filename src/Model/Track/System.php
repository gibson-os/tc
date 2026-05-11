<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Model\Track;

use GibsonOS\Core\Attribute\Install\Database\Column;
use GibsonOS\Core\Attribute\Install\Database\Constraint;
use GibsonOS\Core\Attribute\Install\Database\Table;
use GibsonOS\Core\Model\AbstractModel;
use GibsonOS\Module\Tc\Enum\TrainStrategy;
use GibsonOS\Module\Tc\Model\Track;

/**
 * @method getTrack(): Track
 * @method setTrack(Track $track): System
 */
#[Table]
class System extends AbstractModel
{
    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED], autoIncrement: true)]
    private ?int $id = null;

    #[Column]
    private TrainStrategy $strategy;

    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED])]
    private int $trackId;

    #[Constraint]
    protected Track $track;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): System
    {
        $this->id = $id;

        return $this;
    }

    public function getStrategy(): TrainStrategy
    {
        return $this->strategy;
    }

    public function setStrategy(TrainStrategy $strategy): System
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function getTrackId(): int
    {
        return $this->trackId;
    }

    public function setTrackId(int $trackId): System
    {
        $this->trackId = $trackId;

        return $this;
    }
}
