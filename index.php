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
			<td id="<?php echo "bee-".$beeKind."-".$key."-status"; ?>"><?php echo ($value < $bees['queen']['hitPoints']) ? 'Dead' : '<span style="color: green">Alive</span>'; ?></td>
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
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Andrea Fiori">

	<title>Bee Slap</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
	
	<div class="text-center">
		<h1>Bee slap</h1>
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
			<button type="button" id="hit-button" class="btn btn-primary">Hit it!</button>
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
		
		$("#reset-button").click(function(event) {
			$.post("reset.php", function(data) {
				window.location.reload(true);
			});
		});
	});
</script>

</body>
</html>
