<?php


namespace App;


class Unit
{
    private $x;
    private $y;
    private $isRotationPoint;
    private $color;

    /**
     * Block constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y = 0, bool $isRotationPoint=false)
    {
        $this->setX($x);
        $this->setY($y);
        $this->isRotationPoint = $isRotationPoint;
    }

    public function getRotationPoint() :bool
    {
        return $this->isRotationPoint;
    }

    /**
     * @return mixed
     */
    public function getX() :int
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     * @return Block
     */
    public function setX($x) :self
    {
        $this->x = $x;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getY() :int
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     * @return Block
     */
    public function setY(int $y) :self
    {
        $this->y = $y;

        return $this;
    }

    public function moveDown() :void
    {
        $this->setY($this->getY() + 1);
    }

    public function moveRight() :void
    {
        $this->setX($this->getX() + 1);
    }

    public function moveLeft() :void
    {
        $this->setX($this->getX() - 1);
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     * @return Unit
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }



}