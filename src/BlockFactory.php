<?php


namespace App;


class BlockFactory
{
    const BLOCK_TYPES = ['Line', 'Square', 'Middle', 'RightSkew', 'LeftSkew', 'RightL', 'LeftL'];

    /**
     * @return mixed
     */
    public static function getBlock(int $x) : Block
    {
        $type = self::BLOCK_TYPES[array_rand(self::BLOCK_TYPES)];
        $className = 'App\\' . $type . 'Block';
        return new $className($x);
    }
}