<?php

session_start();

include_once("classes/BeesSlap.php");

$beesSplap = new BeesSlap( !empty($_SESSION['beeSlap']) ? $_SESSION['beeSlap'] : null );

$kind = isset($_POST['beeKind']) ? $_POST['beeKind'] : $beesSplap->recoverBeeKindToHit();
$number = isset($_POST['beeNumber']) ? $_POST['beeNumber'] : $beesSplap->recoverBeeNumber($kind);
$points = $beesSplap->deductHitPoints($kind, $number);
$status = ($beesSplap->isBeeDead($kind, $number)) ? '<span style="color: darkred">Dead</span>' : '<span style="color: darkgreen">Alive</span>';

$_SESSION['beeSlap'] = $beesSplap->getBees();

?>
<div class="alert alert-info" id="msgALertInfo">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h3>A <?php echo $kind ?> bee was hit!</h3>
	<p>Bee number: <?php echo $number ?></p>
	<p>Points: <?php echo $points ?></p>
	<p>Status: <?php echo $status ?></p>
	
	<?php if ($beesSplap->isQueenDead()): ?>
	<h3>A queen is dead!</h3>
	<h4>Game over</h4>
	<?php endif; ?>
</div>

<script>
	$('#<?php echo "bee-".$kind."-".$number."-points"; ?>').html('<span><?php echo $points ?></span>');
	$('#<?php echo "bee-".$kind."-".$number."-status"; ?>').html('<span><?php echo $status ?></span>');

	<?php if ($beesSplap->isBeeDead($kind, $number)): ?>
		$('#<?php echo "bee-".$kind."-".$number."-hitit"; ?>').find('.hitItButton').prop('disabled', true);
	<?php endif; ?>

	<?php if ($beesSplap->areAllQueeensDead()): ?>
	$('#hit-button').prop("disabled", true);
	$('.hitItButton').prop("disabled", true);
	<?php endif; ?>

	$("#msgALertInfo").delay(3200).fadeOut(300);
</script>
