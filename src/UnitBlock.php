<?php


namespace App;


class UnitBlock extends Block
{

    const COLOR = 'grey';

    protected function generateUnits(int $x): array
    {
        $units[] = new Unit($x, 0);

        return $units;
    }


}