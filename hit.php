<?php

session_start();

include_once("classes/BeesSlap.php");

$beesSplap = new BeesSlap( !empty($_SESSION['beeSlap']) ? $_SESSION['beeSlap'] : null );

$beeKind = $beesSplap->recoverBeeKindToHit();
$number = $beesSplap->recoverBeeNumber($beeKind);
$points = $beesSplap->deductHitPoints($beeKind, $number);
$status = ($beesSplap->isBeeDead($beeKind, $number)) ? '<span style="color: darkred">Dead</span>' : '<span style="color: darkgreen">Alive</span>';

$_SESSION['beeSlap'] = $beesSplap->getBees();

?>
<div class="alert alert-info">
	<h3>A <?php echo $beeKind ?> bee was hit!</h3>
	<p>Bee number: <?php echo $number ?></p>
	<p>Points: <?php echo $points ?></p>
	<p>Status: <?php echo $status ?></p>
	
	<?php if ($beesSplap->isQueenDead()): ?>
	<h3>A queen is dead!</h3>
	<h4>Game over</h4>
	<?php endif; ?>
</div>

<script>
	$('#<?php echo "bee-".$beeKind."-".$number."-points"; ?>').html('<span><?php echo $points ?></span>');
	$('#<?php echo "bee-".$beeKind."-".$number."-status"; ?>').html('<span><?php echo $status ?></span>');

	<?php if ($beesSplap->isQueenDead()): ?>
	$('#hit-button').prop("disabled", true);
	<?php endif; ?>
</script>
