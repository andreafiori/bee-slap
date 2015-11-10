<?php
session_start();

if (isset($_SESSION['beeSlap'])) {
	unset($_SESSION['beeSlap']);
}

session_destroy();
