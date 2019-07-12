<?php 

	require("includes/helpers.php");
	require("includes/connectg.php");
	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		render("goalies_view.php", ["title" => "Goalies"]);
	}
	
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$positions = [];
		
		foreach($rows as $row)
		{
			$winsval = $row["wins"] * $_POST["valueOfWins"];
			$otval = $row["ot"] * $_POST["valueOfOTLs"];
			$soval = $row["so"] * $_POST["valueOfShutouts"];
			$poolpoints = $winsval + $otval + $soval;
			$pointsrate = $poolpoints / $row["gp"];
			
			$positions[] = [
				"name" => $row["name"],
				"pos" => $row["pos"],
				"age" => $row["age"],
				"team" => $row["team"],
				"gp" => $row["gp"],
				"wins" => $row["wins"],
				"losses" => $row["losses"],
				"ot" => $row["ot"],
				"svp" => $row["svp"],
				"so" => $row["so"],
				"poolpoints" => $poolpoints,
				"pp82" => number_format($pointsrate * 70, 0)
				];
		}
		
		/*$response = array(
			"success" => true,
    	"data" => $positions
		);
			
    echo json_encode($response);*/
		
		render("goalies_fullview.php", ["title" => "Goalies", "positions" => $positions]);
	}
?>