<?php


namespace App;


class MiddleBlock extends Block
{
    const COLOR = 'purple';

    protected function generateUnits(int $x) :array
    {
        $units[] =  new Unit($x-1, 0);
        $units[] =  new Unit($x, 0, true);
        $units[] =  new Unit($x, -1);
        $units[] =  new Unit($x+1, 0);

        return $units;
    }

}