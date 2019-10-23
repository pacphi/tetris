<?php


namespace App;


class SquareBlock extends Block
{
    const COLOR = 'yellow';

    protected function generateUnits(int $x) :array
    {
        for($y=0; $y>-2; $y--) {
            $units[] =  new Unit($x-1, $y);
            $units[] =  new Unit($x, $y);
        }

        return $units;
    }

}