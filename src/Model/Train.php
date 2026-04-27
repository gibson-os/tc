<?php
declare(strict_types=1);

namespace Tc\Model;

use GibsonOS\Core\Attribute\Install\Database\Column;
use GibsonOS\Core\Attribute\Install\Database\Constraint;
use GibsonOS\Core\Attribute\Install\Database\Table;
use GibsonOS\Core\Model\AbstractModel;
use JsonSerializable;
use Override;
use Tc\Enum\TrainDirection;
use Tc\Strategy\Train\TrainStrategyInterface;

/**
 * @method getTrack(): Track
 * @method setTrack(Track $track): Train
 */
#[Table]
class Train extends AbstractModel implements JsonSerializable
{
    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED], autoIncrement: true)]
    private ?int $id = null;

    #[Column(length: 64)]
    private string $name;

    #[Column(length: 64)]
    private ?string $image = null;

    #[Column(type: Column::TYPE_SMALLINT, attributes: [Column::ATTRIBUTE_UNSIGNED])]
    private int $speed = 0;

    #[Column]
    private TrainDirection $direction = TrainDirection::FORWARD;

    /**
     * @var class-string<TrainStrategyInterface>
     */
    #[Column(length: 255)]
    private string $strategy;

    #[Column]
    private array $configuration = [];

    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED])]
    private int $trackId;

    #[Constraint]
    protected Track $track;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Train
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Train
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): Train
    {
        $this->image = $image;

        return $this;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): Train
    {
        $this->speed = $speed;

        return $this;
    }

    public function getDirection(): TrainDirection
    {
        return $this->direction;
    }

    public function setDirection(TrainDirection $direction): Train
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return class-string<TrainStrategyInterface>
     */
    public function getStrategy(): string
    {
        return $this->strategy;
    }

    /**
     * @param class-string<TrainStrategyInterface> $strategy
     */
    public function setStrategy(string $strategy): Train
    {
        $this->strategy = $strategy;

        return $this;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function setConfiguration(array $configuration): Train
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function getTrackId(): int
    {
        return $this->trackId;
    }

    public function setTrackId(int $trackId): Train
    {
        $this->trackId = $trackId;

        return $this;
    }

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'image' => $this->getImage(),
            'speed' => $this->getSpeed(),
            'direction' => $this->getDirection(),
        ];
    }
}
