<?php
// Quick settings
set_time_limit(2);
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Include the Reversi class
include 'libs/Core/Reversi.class.php';

// How big (wide and tall) should the playing board be?
$gridSize = 8;

// Create the game!
$reversi = new Core_Reversi($gridSize);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Language" content="en-gb" />
    <title>Reversi Othelio - PHP com JavaScript</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <link rel="stylesheet" type="text/css" href="./assets/css/reversi.css" media="screen" />
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/reversi.js"></script>
    <script type="text/javascript" src="./assets/js/str_split.js"></script>
    <script type="text/javascript">
    // Set variables
    var gridSize           = <?php echo $gridSize; ?>,
        boardContent       = new Object,
        boardContentString = "<?php echo $reversi->getBoardAfterTurn(); ?>",
        turnInPlay         = "<?php echo $reversi->getTurn(); ?>",
        turnNext           = turnInPlay == 'b' ? 'w' : 'b',
        coords             = null,
        x                  = false,
        y                  = false,
        xTemp              = false,
        yTemp              = false,
        next               = false,
        continueOn         = true,
        disksChanged       = new Array;
        
    // Setup the board
    setBoardContent();
    </script>
</head>
<body>
    <div style="float:left">
        <table id="board">
            <?php echo $reversi->getBoard(); ?>
        </table>
    </div>
    
    <div style="float:left;margin-left:30px">
        <h1>Estatísticas do Jogo Atual</h1>
        
        <!-- Set the stats //-->
        <?php
            
            // Get the stats
            $reversiScore  = $reversi->getScore();
            $reversiStatus = $reversi->getGameStatus();
        
        ?>
        
        <!-- Is the game still ongoing? //-->
        <?php if ($reversiScore['empty'] <= 0) { ?>
            <!-- Game has finished //-->
            <p><strong>O Jogo Acabou!!</strong></p>
            
            <p>
                <strong>Jogador das peças <?php echo $reversi->getFullColor($reversiStatus, true); ?></strong> venceu,
                the score being
                <strong><?php echo $reversiScore['white']; ?></strong>-<strong><?php echo $reversiScore['black']; ?></strong>
            </p>
            
            <p><a href="/">Play again, why not?!</a></p>
        <?php } else { ?>
            <!-- Game is in progress //-->
            <!-- Is it a tie? //-->
            <?php if ($reversiStatus == 'tie') { ?>
                <!-- Tie //-->
                <p>
                    <strong>O Jogo está empatado!</strong>
                    <strong>Brancas <?php echo $reversiScore['white']; ?></strong> x <strong><?php echo $reversiScore['black']; ?> Pretas</strong>
                    restando <strong><?php echo $reversiScore['empty']; ?></strong> peças para jogar.
                </p>
            <?php } else { ?>
                <!-- Someone is winning //-->
                <p>
                    <strong>As peças <?php echo $reversi->getFullColor($reversiStatus, true); ?></strong> estão vencendo,
                    <strong>Brancas <?php echo $reversiScore['white']; ?></strong> x <strong><?php echo $reversiScore['black']; ?> Pretas</strong>
                    restando <strong><?php echo $reversiScore['empty']; ?></strong> peças para jogar.
                </p>
            <?php } ?>
            
            <!-- Which players turn is it? //-->
            <p><strong>Jogador das peças <?php echo $reversi->getFullColor($reversi->getTurn(), true); ?></strong>, é a sua vez de jogar. Escolha sua jogada!</p>
            
            <!-- How many disks were flipped? //-->
            <?php if ($reversi->getDisksFlipped() >= 1) { ?>
                <!-- Some were flipped //-->
                <p><?php echo $reversi->getDisksFlipped(); ?> discos foram virados na jogada anterior!</p>
            <?php } else if (isset($_GET['x'])) { ?>
                <!-- No disks were flipped //-->
                <div class="error">
                    <p>Você não virou nenhum disco! Se você deseja pular sua jogada,  <a href="/reversi?=<?php echo (int)$_GET['x']; ?>&y=<?php echo (int)$_GET['x']; ?>&turn=<?php echo $_GET['turn'] == 'b' ? 'w' : 'b'; ?>&board=<?php echo htmlentities($_GET['board']); ?>">clique aqui!</a>.</p>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div style="float:right;margin-left:30px;background-color: gray;padding: 10px 10px;border-radius:10px;color:aliceblue">
        <center><h1>Chat do Jogo...</h1></center>
        <iframe src="chat/chat.html" frameborder="0" height="600"></iframe>       
    </div>
    
</body>
</html>