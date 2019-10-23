<?php


namespace App;


class Game
{
    // TODO

    const DIRECTIONS = [
        'down'  => [0, 1],
        'right' => [1, 0],
        'left'  => [-1, 0],
    ];

    const BLOCK_SCORE = 10;
    const LINE_SCORE = 100;

    const WIDTH = 10;
    const HEIGHT = 22;
    const LEVEL_INCREMENT = 10;

    private $blocks;
    private $score = 0;
    private $level = 1;
    private $lines = 0;
    private $nextBlock;

    public function __construct(?Game $game = null)
    {
        if ($game instanceof Game) {
            $this->setBlocks($game->getBlocks());
            $score = $game->getScore();
            $lines = $game->getLines();
            $level = $game->getLevel();
            $nextBlock = $game->getNextBlock();
        } else {
            $this->generateBlock();
        }

        $this->setScore($score ?? 0);
        $this->setLevel($level ?? 1);
        $this->setLines($lines ?? 0);
        $this->setNextBlock($nextBlock ?? null);
    }

    /**
     * @return mixed
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @param mixed $blocks
     * @return Game
     */
    public function setBlocks(array $blocks): self
    {
        $this->blocks = $blocks;

        return $this;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     * @return Game
     */
    public function setScore(int $score): Game
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return int
     */
    public function getLines(): int
    {
        return $this->lines;
    }

    /**
     * @param int $lines
     * @return Game
     */
    public function setLines(int $lines): Game
    {
        $this->lines = $lines;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return Game
     */
    public function setLevel(int $level): Game
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNextBlock(): ?Block
    {
        return $this->nextBlock;
    }

    /**
     * @param mixed $nextBlock
     * @return Game
     */
    public function setNextBlock(?Block $nextBlock = null): self
    {
        $this->nextBlock = $nextBlock ?? BlockFactory::getBlock(round(self::WIDTH / 2));

        return $this;
    }

    public function generateBlock(): self
    {
        $block = $this->getNextBlock() ?? BlockFactory::getBlock(round(self::WIDTH / 2));

        $this->setNextBlock();
        $this->addBlock($block);

        if (!$this->isSpawnPlaceFree()) {
            throw new \LogicException('Game lost');
        }

        return $this;
    }

    public function addBlock(Block $block): self
    {
        $this->blocks[] = $block;

        return $this;
    }

    private function isSpawnPlaceFree(): bool
    {
        return
            !$this->searchUnit(round(self::WIDTH / 2), 1) instanceof Unit;
    }

    public function searchUnit(int $x, int $y): ?Unit
    {
        foreach ($this->getBlocks() as $block) {
            foreach ($block->getUnits() as $unit) {
                if ($unit->getX() === $x && $unit->getY() === $y) {
                    return $unit;
                }
            }
        }

        return null;
    }

    public function moveDown()
    {
        $allowedMove = $this->move('down');
        if (!$allowedMove) {
            $this->removeLineIfExists();

            $this->setScore($this->getScore() + self::BLOCK_SCORE);
            $this->generateBlock();
        }

    }

    private function move(string $direction): bool
    {
        $block = $this->getLastBlock();

        if ($this->allowedMove($direction)) {
            $block->{'move' . ucfirst($direction)}();
            $moveAllowed = true;
        }

        return $moveAllowed ?? false;
    }

    public function getLastBlock(): Block
    {
        if (empty($this->getBlocks())) {
            $this->generateBlock();
        }

        foreach ($this->getBlocks() as $key => $value) {

        }

        return $this->getBlocks()[$key];
    }

    private function allowedMove(string $direction): bool
    {
        $isAllowed = true;
        foreach ($this->getLastBlock()->getUnits() as $unit) {
            $x = $unit->getX(self::DIRECTIONS[$direction][0]) + self::DIRECTIONS[$direction][0];
            $y = $unit->getY() + self::DIRECTIONS[$direction][1];

            $isAllowedUnit =
                $y < self::HEIGHT &&
                $x >= 0 &&
                $x < self::WIDTH &&
                (in_array($this->searchUnit($x, $y), $this->getLastBlock()->getUnits()) || $this->searchUnit($x, $y) === null);
            if (!$isAllowedUnit) {
                $isAllowed = false;
            }
        }

        return $isAllowed;
    }

    private function removeLineIfExists(): void
    {
        $unitsY = $this->getLastBlock()->getUnitsY();
        foreach ($unitsY as $lineY) {
            while ($this->checkLine($lineY)) {
                foreach ($this->getBlocks() as $block) {
                    foreach ($block->getUnits() as $key => $unit) {
                        if ($unit->getY() === $lineY) {
                            $block->removeUnit($key);
                        }
                    }
                }

                for ($i = $lineY - 1; $i > 0; $i--) {
                    foreach ($this->getBlocks() as $block) {
                        foreach ($block->getUnits() as $unit) {
                            if ($unit->getY() == $i) {
                                $unit->moveDown();
                            }
                        }
                    }
                }
                $this->setScore($this->getScore() + self::LINE_SCORE);
                $this->setLines($this->getLines() + 1);
                $this->checkLevelUp();
            }
        }
    }

    private function checkLine(int $y): bool
    {
        for ($x = 0; $x < self::WIDTH; $x++) {
            if (!$this->searchUnit($x, $y)) {
                return false;
            }
        }

        return true;
    }

    private function checkLevelUp()
    {
        if ($this->getLines() - ($this->getLevel() - 1) * self::LEVEL_INCREMENT === ($this->getLevel()) * self::LEVEL_INCREMENT) {
            $this->setLevel($this->getLevel() + 1);
        }

    }

    public function rotate(int $direction = 1): void
    {
        $block = $this->getLastBlock();

        $rotationCoords = $block->rotate($direction);
        $allowedRotation = true;
        if (!empty($rotationCoords)) {
            foreach ($rotationCoords as $coord) {
                if (
                ($this->searchUnit($coord[0], $coord[1]) ||
                    $coord[0]<0 || $coord[0] >= self::WIDTH || $coord[1]<0 || $coord[1]>=self::HEIGHT ) &&
                    !in_array($this->searchUnit($coord[0], $coord[1]), $this->getLastBlock()->getUnits())
                ) {
                    $allowedRotation = false;
                }
            }
        }

        if ($allowedRotation) {
            $block->rotate($direction, true);
        }
    }

    public function moveRight()
    {
        $this->move('right');
    }

    public function moveLeft()
    {
        $this->move('left');
    }


}