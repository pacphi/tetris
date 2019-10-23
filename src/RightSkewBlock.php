<?php


namespace App;


class RightSkewBlock extends Block
{
    const COLOR = 'green';

    protected function generateUnits(int $x) :array
    {
        $units[] =  new Unit($x-1, 0);
        $units[] =  new Unit($x, 0, true);
        $units[] =  new Unit($x, -1);
        $units[] =  new Unit($x+1, -1);

        return $units;
    }

}