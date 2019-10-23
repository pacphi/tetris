<?php


namespace App;


class LeftSkewBlock extends Block
{
    const COLOR = 'red';

    protected function generateUnits(int $x) :array
    {
        $units[] =  new Unit($x-1, -1);
        $units[] =  new Unit($x, -1);
        $units[] =  new Unit($x, 0, true);
        $units[] =  new Unit($x+1, 0);

        return $units;
    }

}