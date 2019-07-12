<?php 

	require("includes/helpers.php");
	require("includes/connectp.php");
	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		render("skaters_view.php", ["title" => "Skaters"]);
	}
	
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$positions = [];
		
		foreach($rows as $row)
		{
			if($row["position"] == "D")
			{
				$pointsval = $row["points"] * $_POST["valueOfDPoints"];
				$assistsval = $row["assists"] * $_POST["valueOfDAssists"];
				$pimsval = $row["pims"] * $_POST["valueOfDPIMs"];
				$poolpoints = $pointsval + $assistsval + $pimsval;
				$pointsrate = $poolpoints / $row["gp"];
			}
			else
			{
				$pointsval = $row["points"] * $_POST["valueOfPoints"];
				$assistsval = $row["assists"] * $_POST["valueOfAssists"];
				$pimsval = $row["pims"] * $_POST["valueOfPIMs"];
				$poolpoints = $pointsval + $assistsval + $pimsval;
				$pointsrate = $poolpoints / $row["gp"];
			}
			
			$positions[] = [
				"name" => $row["name"],
				"age" => $row["age"],
				"team" => $row["team"],
				"position" => $row["position"],
				"gp" => $row["gp"],
				"goals" => $row["goals"],
				"assists" => $row["assists"],
				"points" => $row["points"],
				"pims" => $row["pims"],
				"poolpoints" => $poolpoints,
				"pp82" => number_format($pointsrate * 82, 0)
				];
		}
		
		/*$response = array(
			"success" => true,
    	"data" => $positions
		);
			
    echo json_encode($response);*/
		
		render("skaters_fullview.php", ["title" => "All Players", "positions" => $positions]);
	}
?>