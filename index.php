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
		<tr class="highlightable-row-<?php echo $key ?>">
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
	<meta name="keywords" content="bee, slap, game, browser, php, bootstrap">
	<meta name="author" content="Andrea Fiori">

	<title>Bee Slap game</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/toastr.min.css" rel="stylesheet">
	<style>
	/* Space out content a bit */
	body {
		padding-top: 20px;
		padding-bottom: 20px;
	}

	/* Everything but the jumbotron gets side spacing for mobile first views */
	.header,
	.marketing,
	.footer {
		padding-right: 15px;
		padding-left: 15px;
	}

	/* Custom page header */
	.header {
		padding-bottom: 20px;
		border-bottom: 1px solid #e5e5e5;
	}

	/* Make the masthead heading the same height as the navigation */
	.header h3 {
		margin-top: 0;
		margin-bottom: 0;
		line-height: 40px;
	}
	</style>
</head>
<body>

<div class="container">
	
	<div class="header clearfix">
		<nav>
			<ul class="nav nav-pills pull-right">
				<li role="presentation">
					<a href="#" data-toggle="modal" data-target="#modalRules">Rules</a>
				</li>
				<li role="presentation"><a href="javascript:void(0)" id="hit-button">Random Hit</a></li>
				<li role="presentation" class="active">
					<a style="cursor: pointer" data-toggle="modal" data-target="#modalNewGame">New game</a>
				</li>
			</ul>
		</nav>
		<h3 class="text-muted">Bee slap game</h3>
	</div>

	<div class="row">
		<div class="col-md-12 col-md-12 col-lg-4">
			<h3 class="text-center">Queens</h3>
			<table class="table table-bordered table-responsive" width="100%" id="table-queen">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'queen'); ?>
			</table>
		</div>
		<div class="col-md-12 col-md-12 col-lg-4">
			<h3 class="text-center">Workers</h3>
			<table class="table table-bordered table-responsive" width="100%" id="table-workers">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'workers'); ?>
			</table>
		</div>
		<div class="col-md-12 col-md-12 col-lg-4">
			<h3 class="text-center">Drones</h3>
			<table class="table table-bordered table-responsive" width="100%" id="table-drone">
			<?php printRowHeader(); ?>
			<?php printRow($bees, 'drone'); ?>
			</table>
		</div>
	</div>

	<br>

	<div id="result"></div>
	
	<!-- Modal with rules -->
	<div class="modal fade bs-example-modal-lg" id="modalRules" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Rules</h4>
				</div>
				<div class="modal-body">

					<p>You have 15 Bees. 3 of these bees are Queen Bees, 5 are Worker Bees and 7 are Drone Bees.</p>

					<div class="row">
						<div class="col-md-4">
							<h3>Queen Bees</h3>
							<ul>
								<li>Each Queen Bee initially has 100 hit points</li>
								<li>When they are hit 7 hit points are deducted</li>
								<li>A bee dies when it has 0 or fewer hit points remaining</li>
								<li>When all the queens are dead – all other bees left (workers, drones) automatically die</li>
							</ul>
						</div>
						<div class="col-md-4">
							<h3>Worker Bees</h3>
							<ul>
								<li>Each worker Bee initially has 75 hit points</li>
								<li>When they are hit 12 hit points are deducted</li>
							</ul>
						</div>
						<div class="col-md-4">
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

	<!-- Modal confirm new game -->
	<div class="modal fade bs-example-modal-lg" id="modalNewGame" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">New game</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure to begin a new game? All results will be lost.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary reset-button" data-dismiss="modal">Confirm</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Game over modal -->
	<div class="modal fade bs-example-modal-lg" id="modalGameOver" tabindex="-1" role="dialog" aria-labelledby="myGameOverModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">The game is over!</h4>
				</div>
				<div class="modal-body">

					<h3>GAME OVER!</h3>

					<p>All Queens are dead! The game is over.</p>

					<div class="modal-footer">
						<!-- <button type="button" class="btn btn-default">Rules</button> -->
						<button type="button" class="btn btn-primary reset-button" data-dismiss="modal">New game</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/toastr.min.js"></script>
<script>
	// Toastr configuration
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-bottom-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

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

		$(".reset-button").click(function(event) {
			$.post("reset.php", function(data) {
				window.location.reload(true);
			});
		});
	});
</script>

</body>
</html>
