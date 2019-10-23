<?php

namespace Test;

use App\Block;
use App\Game;
use App\LineBlock;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    private $game;

    public function setUp(): void
    {
        $this->game = new Game();
        $blocks[] = new LineBlock(4, 4);
        $this->game->setBlocks($blocks);
//        $this->game->generateBlock();
    }

    public function testMoveDown()
    {
        $this->game->moveDown();
        $this->assertEquals(1, $this->game->getLastBlock()->getUnits()[0]->getY());
        $this->game->moveDown();
        $this->assertEquals(2, $this->game->getLastBlock()->getUnits()[0]->getY());
    }

    public function testMoveRight()
    {
        $this->game->moveRight();
        $this->assertEquals(5, $this->game->getLastBlock()->getUnits()[0]->getX());
    }

    public function testMoveLeft()
    {
        $this->game->moveLeft();
        $this->assertEquals(3, $this->game->getLastBlock()->getUnits()[0]->getX());
    }

    public function testMoveDownOtherBlock()
    {
        $this->game->moveDown();
        $this->game->moveDown();
        $this->assertEquals(2, $this->game->getLastBlock()->getUnits()[0]->getY());
        $this->game->moveDown();
        $this->assertEquals(3, $this->game->getLastBlock()->getUnits()[0]->getY());
        $this->game->moveDown();
        $this->assertEquals(0, $this->game->getLastBlock()->getUnits()[0]->getY());
        $this->game->moveDown();
        $this->game->moveDown();
        $this->assertEquals(2, $this->game->getLastBlock()->getUnits()[0]->getY());
        $this->game->moveDown();
        $this->assertEquals(0, $this->game->getLastBlock()->getUnits()[0]->getY());
    }

    public function testMoveAroundBlock()
    {
        $this->game->moveDown();
        $this->game->moveDown();
        $this->assertEquals(2, $this->game->getLastBlock()->getUnits()[0]->getY());
        $this->game->moveDown();
        $this->assertEquals(3, $this->game->getLastBlock()->getUnits()[0]->getY());
        $this->game->moveRight();
        $this->game->moveDown();
        $this->assertEquals(4, $this->game->getLastBlock()->getUnits()[0]->getY());
    }

    public function testNewLine()
    {
        $this->game->moveDown();
        $blocks[] = new LineBlock(0, 4);
        $blocks[] = new LineBlock(1, 4);
        $blocks[] = new LineBlock(2, 4);
        $blocks[] = new LineBlock(3, 4);
        $blocks[] = new LineBlock(4, 4);
        $blocks[] = new LineBlock(6, 4);
        $blocks[] = new LineBlock(7, 4);
        $blocks[] = new LineBlock(5, 3);
        $this->game->setBlocks($blocks);
        $this->assertInstanceOf(Block::class, $this->game->searchUnit(5,3));
        $this->game->moveDown();
        $this->assertNotInstanceOf(Block::class, $this->game->searchUnit(5,4));
        $this->assertNull($this->game->searchUnit(5,4));

    }

}