<?php

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

	session_start();

	include_once("classes/BeesSlap.php");

	$beesSplap = new BeesSlap( !empty($_SESSION['beeSlap']) ? $_SESSION['beeSlap'] : null );

	$kind = isset($_POST['beeKind']) ? $_POST['beeKind'] : $beesSplap->recoverBeeKindToHit();
	$number = isset($_POST['beeNumber']) ? $_POST['beeNumber'] : $beesSplap->recoverBeeNumber($kind);
	$points = $beesSplap->deductHitPoints($kind, $number);
	$status = ($beesSplap->isBeeDead($kind, $number)) ? '<span style="color: darkred">Dead</span>' : '<span style="color: darkgreen">Alive</span>';

	$_SESSION['beeSlap'] = $beesSplap->getBees();

	?>
	

	<script>
		<?php if ($beesSplap->areAllQueeensDead()): ?>
		$('#modalGameOver').modal({
			backdrop: 'static',
			keyboard: false
		}); 
		<?php endif; ?>
	
		var notifMsg = '<?php echo ucfirst($kind) ?> has been hit! Points: <?php echo $points ?>. Status: <?php echo strip_tags($status) ?>';
		
		toastr.info(notifMsg);
	
		$('#table-queen tr').removeClass('bg-info');
		$('#table-workers tr').removeClass('bg-info');
		$('#table-drone tr').removeClass('bg-info');
		
		$('#table-<?php echo $kind ?> .highlightable-row-<?php echo $number ?>').addClass('bg-info').siblings().removeClass('bg-info');
		
		$('#<?php echo "bee-".$kind."-".$number."-points"; ?>').html('<span><?php echo $points ?></span>');
		$('#<?php echo "bee-".$kind."-".$number."-status"; ?>').html('<span><?php echo $status ?></span>');

		<?php if ($beesSplap->isBeeDead($kind, $number)): ?>
			$('#<?php echo "bee-".$kind."-".$number."-hitit"; ?>').find('.hitItButton').prop('disabled', true);
		<?php endif; ?>

		<?php if ($beesSplap->areAllQueeensDead()): ?>
		$('#hit-button').prop("disabled", true);
		$('.hitItButton').prop("disabled", true);
		<?php endif; ?>
	</script>
	<?php
}
