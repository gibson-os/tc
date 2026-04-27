<?php
declare(strict_types=1);

namespace Tc\Model;

use GibsonOS\Core\Attribute\Install\Database\Column;
use GibsonOS\Core\Attribute\Install\Database\Constraint;
use GibsonOS\Core\Attribute\Install\Database\Table;
use GibsonOS\Core\Model\AbstractModel;
use JsonSerializable;
use Override;
use Tc\Model\Track\Layout;

/**
 * @method getTrains(): Train[]
 * @method setTrains(Train[] $trains): Track
 * @method addTrains(Train[] $trains): Track
 * @method getLayouts(): Layout[]
 * @method setLayouts(Layout[] $layouts): Track
 * @method addLayouts(Layout[] $layouts): Track
 */
#[Table]
class Track extends AbstractModel implements JsonSerializable
{
    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED], autoIncrement: true)]
    private ?int $id = null;

    #[Column(length: 64)]
    private string $name;

    #[Constraint('track', Train::class)]
    protected array $trains = [];

    #[Constraint('track', Layout::class)]
    protected array $layouts = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Track
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Track
    {
        $this->name = $name;

        return $this;
    }

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
