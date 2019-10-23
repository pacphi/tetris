<?php


namespace App;


class LeftLBlock extends Block
{
    const COLOR = 'blue';

    protected function generateUnits(int $x) :array
    {
        $units[] =  new Unit($x, 0);
        $units[] =  new Unit($x, -1, true);
        $units[] =  new Unit($x, -2);
        $units[] =  new Unit($x-1, 0);

        return $units;
    }

}