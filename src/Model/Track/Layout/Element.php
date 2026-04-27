<?php
declare(strict_types=1);

namespace GibsonOS\Module\Tc\Model\Track\Layout;

use GibsonOS\Core\Attribute\Install\Database\Column;
use GibsonOS\Core\Attribute\Install\Database\Constraint;
use GibsonOS\Core\Attribute\Install\Database\Table;
use GibsonOS\Core\Model\AbstractModel;
use GibsonOS\Module\Tc\Enum\ElementDirection;
use GibsonOS\Module\Tc\Enum\TrackElement;
use GibsonOS\Module\Tc\Model\Track\Layout;

/**
 * @method getLayout(): Layout
 * @method setLayout(Layout $layout): Element
 */
#[Table]
class Element extends AbstractModel
{
    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED], autoIncrement: true)]
    private ?int $id = null;

    #[Column]
    private TrackElement $type;

    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED])]
    private int $width = 0;

    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED])]
    private int $height = 0;

    #[Column]
    private ElementDirection $direction = ElementDirection::NORTH;

    #[Column(type: Column::TYPE_SMALLINT, attributes: [Column::ATTRIBUTE_UNSIGNED])]
    private int $mode = 0;

    #[Column(attributes: [Column::ATTRIBUTE_UNSIGNED])]
    private int $layoutId;

    #[Constraint]
    protected Layout $layout;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Element
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): TrackElement
    {
        return $this->type;
    }

    public function setType(TrackElement $type): Element
    {
        $this->type = $type;

        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): Element
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): Element
    {
        $this->height = $height;

        return $this;
    }

    public function getDirection(): ElementDirection
    {
        return $this->direction;
    }

    public function setDirection(ElementDirection $direction): Element
    {
        $this->direction = $direction;

        return $this;
    }

    public function getLayoutId(): int
    {
        return $this->layoutId;
    }

    public function setLayoutId(int $layoutId): Element
    {
        $this->layoutId = $layoutId;

        return $this;
    }
}
