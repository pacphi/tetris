<?php


namespace App;


class LineBlock extends Block
{

    const COLOR = 'cyan';

    protected function generateUnits(int $x): array
    {
        $units[] = new Unit($x, 0);
        $units[] = new Unit($x, -1, true);
        $units[] = new Unit($x, -2);
        $units[] = new Unit($x, -3);

        return $units;
    }


}