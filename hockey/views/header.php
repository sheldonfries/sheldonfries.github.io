<!DOCTYPE html>

<html lang="en">
	
	<head>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery.dataTables.css">
		<link rel="stylesheet" href="css/styles.css">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<script src="js/jquery-1.11.3.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.tablesorter.js"></script>
		<script src="js/jquery.tabletoCSV.js"></script>
		<script src="js/scripts.js"></script>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<?php if (isset($title)): ?>
      <title>Hockey Calculator: <?= htmlspecialchars($title) ?></title>
    <?php else: ?>
      <title>Hockey Calculator</title>
    <?php endif ?>
	</head>
	
	<body>
		<div class="container">
			<div id="top">
				<nav class="navbar navbar-default">
					<div class="navbar-header">
						<a class="navbar-brand" href="/">Hockey Calculator</a>
					</div>
					<ul class="nav navbar-nav">
                        <li><a href="/all.php">All Players</a></li>
                        <li><a href="/skaters.php">Skaters</a></li>
                        <li><a href="/goalies.php">Goalies</a></li>
                    <!--    
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pool Points <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="/all.php">All Players</a></li>
								<li><a href="/skaters.php">Skaters</a></li>
								<li><a href="/goalies.php">Goalies</a></li>
							</ul>
						</li>
						<li class="disabled"><a href="/">Draft</a></li>
						<li class="disabled"><a href="/">Don Cherry Rating</a></li>
                     -->
					</ul>
				</nav>
			</div>
			
			<div id="middle">