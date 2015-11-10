<?php

session_start();

unset($_SESSION['beeSlap']);

include_once("classes/BeesSlap.php");

function printRowHeader()
{
	?>
	<tr>
		<th>Bee number</th>
		<th>Points</th>
		<th>Status</th>
		<th>&nbsp;</th>
	</tr>
	<?php
}

function printRow($bees, $beeKind)
{
	foreach($bees[$beeKind]['lineUp'] as $key => $value):
	?>
		<tr>
			<td id="<?php echo "bee-".$beeKind."-".$key."-numbers"; ?>"><?php echo $key ?></td>
			<td id="<?php echo "bee-".$beeKind."-".$key."-points"; ?>"><?php echo $value ?></td>
			<td id="<?php echo "bee-".$beeKind."-".$key."-status"; ?>">
				<?php echo ($value < $bees['queen']['hitPoints']) ? 'Dead' : '<span style="color: green">Alive</span>'; ?>
			</td>
			<td id="<?php echo "bee-".$beeKind."-".$key."-hitit"; ?>">
				<form action="hit.php" method="post" class="frmHitIt">
					<div>
						<input type="hidden" name="beeKind" value="<?php echo $beeKind ?>">
						<input type="hidden" name="beeNumber" value="<?php echo $key ?>">
						<button type="button" class="btn btn-primary hitItButton">Hit it!</button>
					</div>
				</form>
			</td>
		</tr>
	<?php
	endforeach;
}

$beesSplap = new BeesSlap();

$bees = $beesSplap->getBees();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bee slap game">
	<meta name="keywords" content="bee, slap, game, browser, php">
	<meta name="author" content="Andrea Fiori">

	<title>Bee Slap</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
	
	<div class="text-center">
		<h1>Bee slap</h1>
	</div>

	<p>Welcome to the <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg">bee slap game</a>.</p>

	<p><strong>Note:</strong> if you refresh the browser, the game will restart.</p>

	<!-- Modal -->
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Bee slap game rules</h4>
				</div>
				<div class="modal-body">
					<h3>Initial Rules</h3>

					<p>You have 15 Bees. 3 of these bees are Queen Bees, 5 are Worker Bees and 7 are Drone Bees.</p>

					<h3>Queen Bees</h3>
					<ul>
						<li>Each Queen Bee initially has 100 hit points</li>
						<li>When they are hit 7 hit points are deducted</li>
						<li>A bee dies when it has 0 or fewer hit points remaining</li>
						<li>When all the queens are dead – all other bees left (workers, drones) automatically die</li>
					</ul>

					<div class="row">
						<div class="col-md-6">
							<h3>Worker Bees</h3>
							<ul>
								<li>Each worker Bee initially has 75 hit points</li>
								<li>When they are hit 12 hit points are deducted</li>
							</ul>
						</div>
						<div class="col-md-6">
							<h3>Drone Bees</h3>
							<ul>
								<li>Each Drone Bee initially has 50 hit points</li>
								<li>When they are hit 18 hit points are deducted</li>
							</ul>
						</div>
					</div>

					<h3>Actions</h3>

					<p>Selecting "hit" should randomly pick a bee and "hit it" deducting the hit value from their current amount of hit points, following the rules above for each type of bee. When a bee has run out of hit points it should no longer be available to pick when the user presses/selects hit, (i.e. that bee is dead). When the last queen dies – all bees should die.</p>

					<h3>Display</h3>

					<p>Each time "hit" has been pressed you must display in the browser each individual bee with their details (queen, worker etc), how many hit points it has, whether they are alive or dead and the result of the hit status (i.e. what bee was hit and how many hit points were deducted from it). You should be able to reset the bees at any time to start again.</p>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-4">
			<h2>Queen</h2>
			<table class="table table-bordered table-responsive" width="100%">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'queen'); ?>
			</table>
		</div>
		<div class="col-md-4">
			<h2>Workers</h2>
			<table class="table table-bordered table-responsive" width="100%">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'workers'); ?>
			</table>
		</div>
		<div class="col-md-4">
			<h2>Drones</h2>
			<table class="table table-bordered table-responsive" width="100%">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'drone'); ?>
			</table>
		</div>
	</div>

	<div class="text-center">
		<form action="javascript:void(0)" method="post" role="form">
			<button type="button" id="hit-button" class="btn btn-primary">Hit!</button>
			<button type="button" id="reset-button" class="btn btn-danger">Reset</button>
		</form>
	</div>

	<br>

	<div id="result"></div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
		$("#hit-button").click(function(event) {
			$.post("hit.php", function(data) {
				$('#result').html(data);
			});
		});

		$(".hitItButton").click(function(event) {
			event.preventDefault();

			var form = $(this).parents('form:first');

			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				data: $(form).serialize()
			})
			.done(function (data) {
				$("#result").empty().append(data);
			});
		});

		$("#reset-button").click(function(event) {
			$.post("reset.php", function(data) {
				window.location.reload(true);
			});
		});
	});
</script>

</body>
</html>