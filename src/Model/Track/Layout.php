<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Model\Track;

use GibsonOS\Core\Attribute\Install\Database\Column;
use GibsonOS\Core\Attribute\Install\Database\Constraint;
use GibsonOS\Core\Attribute\Install\Database\Table;
use GibsonOS\Core\Model\AbstractModel;
use GibsonOS\Module\Tc\Model\Track;
use GibsonOS\Module\Tc\Model\Track\Layout\Element;

/**
 * @method getTrack(): Track
 * @method setTrack(Track $track): Layout
 * @method getElements(): Element[]
 * @method setElements(Element[] $elements): Layout
 * @method addElements(Element[] $elements): Layout
 */
#[Table]
class Layout extends AbstractModel
{
    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED], autoIncrement: true)]
    private ?int $id = null;

    #[Column(length: 64)]
    private string $name;

    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED])]
    private int $trackId;

    #[Constraint]
    protected Track $track;

    #[Constraint('layout', Element::class)]
    protected array $elements = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Layout
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Layout
    {
        $this->name = $name;

        return $this;
    }

    public function getTrackId(): int
    {
        return $this->trackId;
    }

    public function setTrackId(int $trackId): Layout
    {
        $this->trackId = $trackId;

        return $this;
    }
}
