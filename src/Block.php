<?php


namespace App;


abstract class Block
{
    private $x;
    private $y;
    private $units;

    const COLOR = 'grey';
    /**
     * Block constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y = 0)
    {
        $this->setUnits($this->generateUnits($x));
        $this->setX($x);
        $this->setY($y);
        $this->setColorToUnits(static::COLOR ?? self::COLOR);
    }

    private function setColorToUnits(string $color) :void
    {
        foreach($this->getUnits() as $unit)
        {
            $unit->setColor($color);
        }
    }

    abstract protected function generateUnits(int $x);

    private function getRotationPoint() :?Unit
    {
        foreach($this->getUnits() as $unit) {
            if ($unit->getRotationPoint()) {
                return $unit;
            }
        }

        return null;
    }


    public function rotate(int $direction, bool $makeRotation = false) :array
    {
        $rotationPoint = $this->getRotationPoint();
        if($rotationPoint) {
            foreach ($this->getUnits() as $unit) {
                $xDistance = $unit->getX() - $rotationPoint->getX();
                $yDistance = $unit->getY() - $rotationPoint->getY();
                if ($makeRotation) {
                    $unit->setY($rotationPoint->getY() + $xDistance*$direction);
                    $unit->setX($rotationPoint->getX() - $yDistance*$direction);
                }
                $coords[] = [$rotationPoint->getX() - $yDistance, $rotationPoint->getY() + $xDistance];

            }
        }

        return $coords ?? [];
    }

    public function moveDown(): void
    {
        foreach ($this->units as $unit) {
            $unit->setY($unit->getY() + 1);
        }
    }

    /**
     * @return mixed
     */
    public function getY(): int
    {
        return max($this->getUnitsY());
    }

    public function getUnitsY() :array {
        $unitsY = [];
        foreach ($this->units as $unit) {
            $unitsY[] = $unit->getY();
        }
        rsort($unitsY);
        return $unitsY;
    }

    /**
     * @param mixed $y
     * @return Block
     */
    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function moveRight(): void
    {
        foreach ($this->units as $unit) {
            $unit->setX($unit->getX() + 1);
        }
    }

    /**
     * @return mixed
     */
    public function getX(int $direction): int
    {
        $unitsX = [];
        foreach ($this->units as $unit) {
            $unitsX[] = $unit->getX();
        }
        if ($direction>0) {
            return max($unitsX);
        }
        return min($unitsX);
    }


    /**
     * @param mixed $x
     * @return Block
     */
    public function setX($x): self
    {
        $this->x = $x;

        return $this;
    }

    public function moveLeft(): void
    {
        foreach ($this->units as $unit) {
            $unit->setX($unit->getX() - 1);
        }
    }

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param mixed $units
     * @return Block
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }

    public function removeUnit($key): self
    {
        unset($this->units[$key]);

        return $this;
    }

    public function __toString()
    {
        return str_replace(__NAMESPACE__.'\\', '', static::class);
    }


}