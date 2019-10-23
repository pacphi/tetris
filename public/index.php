<?php

use App\Block;
use App\Game;
use App\Unit;

require_once '../vendor/autoload.php';
session_start();

if (!empty($_GET['reset'])) {
    session_destroy();
}


$game = new Game($_SESSION['game'] ?? null);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Tetris</title>

</head>
<body>
<h1>Tetris</h1>
<div class="keys">Move (arrows), turn (W/X), Pause/Unpause (P) - <a href="?reset=reset">Reset</a></div>

<?php
$move = $_GET['move'] ?? null;

try {
    if ($move) {
        $game->{'move' . ucfirst($move)}();
    }

    if (!empty($_GET['rotate'])) {
        $game->rotate($_GET['rotate']);
    }
} catch (LogicException $exception) {
    $error = $exception->getMessage();
}
?>
<div class="game" id="grid">
    <?php if (!empty($error)) : ?>
    <div class="error"><?= $error ?></div>
    <?php exit(); ?>
    <?php
    else :
    for ($y = 0; $y < Game::HEIGHT; $y++) : ?>
    <div>
        <?php for ($x = 0; $x < Game::WIDTH; $x++) :
        $unit = $game->searchUnit($x, $y); ?>
        <div class="tile
                        <?php if ($unit instanceof Unit) : ?>
                            block" style="--block-color:<?= $unit->getColor() ?>"
        <?php else: ?>
        "
        <?php endif; ?>
        >
    </div>
    <?php endfor; ?>
</div>
<?php endfor;
endif;
$_SESSION['game'] = $game;
?>
<aside class="infos">
    <div data-label="Next" class="next">
        <div>
            <?php  for ($y = -3; $y <= 0; $y++) : ?>

                <?php
                for ($x = round(Game::WIDTH/2)-2; $x < round(Game::WIDTH/2)+2; $x++) :  ?>
                    <div
                    <?php foreach($game->getNextBlock()->getUnits() as $nextUnit) :
                        if ($nextUnit->getX() == $x && $nextUnit->getY()== $y) : ?>
                        class="block" style="--block-color:<?= $nextUnit->getColor() ?>"
                    <?php endif;
                    endforeach; ?>
                    >
                </div>
                <?php endfor; ?>
            <?php endfor; ?>
        </div>
    </div>
    <div data-label="Score" class="score">
        <?= $game->getScore() ?>
    </div>
    <div data-label="Lines" class="lines">
        <?= $game->getLines() ?>
    </div>
    <div data-label="Level" id="level" class="level" data-level="<?= $game->getLevel() ?>">
        <?= $game->getLevel() ?>
    </div>
</aside>
</div>
<script src="move.js"></script>
</body>
</html>
