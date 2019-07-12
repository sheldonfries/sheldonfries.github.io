<?php 

	require("includes/helpers.php");
	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		render("capsheet_view.php", ["title" => "Cap Sheet"]);
	}
	
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$positions = [];
		
		foreach($skaters as $skater)
		{
			if($skater["position"] == "D")
			{
				$spointsval = $skater["points"] * $_POST["valueOfDPoints"];
				$sassistsval = $skater["assists"] * $_POST["valueOfDAssists"];
				$spimsval = $skater["pims"] * $_POST["valueOfDPIMs"];
				$spoolpoints = $spointsval + $sassistsval + $spimsval;
				$spointsrate = $spoolpoints / $skater["gp"];
			}
			else
			{
				$spointsval = $skater["points"] * $_POST["valueOfPoints"];
				$sassistsval = $skater["assists"] * $_POST["valueOfAssists"];
				$spimsval = $skater["pims"] * $_POST["valueOfPIMs"];
				$spoolpoints = $spointsval + $sassistsval + $spimsval;
				$spointsrate = $spoolpoints / $skater["gp"];
			}
			
			$positions[] = [
				"name" => $skater["name"],
				"age" => $skater["age"],
				"team" => $skater["team"],
				"position" => $skater["position"],
				"gp" => $skater["gp"],
				"poolpoints" => $spoolpoints,
				"pp82" => number_format($spointsrate * 82, 0)
				];
		}
		
		foreach($goalies as $goalie)
		{
			$winsval = $goalie["wins"] * $_POST["valueOfWins"];
			$otval = $goalie["ot"] * $_POST["valueOfOTLs"];
			$soval = $goalie["so"] * $_POST["valueOfShutouts"];
			$gpoolpoints = $winsval + $otval + $soval;
			$gpointsrate = $gpoolpoints / $goalie["gp"];
			
			$positions[] = [
				"name" => $goalie["name"],
				"age" => $goalie["age"],
				"team" => $goalie["team"],
				"position" => $goalie["pos"],
				"gp" => $goalie["gp"],
				"poolpoints" => $gpoolpoints,
				"pp82" => number_format($gpointsrate * 70, 0)
				];
		}
		
		/*$response = array(
			"success" => true,
    	"data" => $positions
		);
			
    echo json_encode($response);*/
		
		render("all_fullview.php", ["title" => "Skaters", "positions" => $positions]);
	}
?>