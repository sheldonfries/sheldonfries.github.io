<form action="all.php" method="post" class="form-inline">
		<div class="form-group">
			<label for="valueOfPoints">Goals/Points:</label>
			<input type="number" class="form-control" name="valueOfPoints" placeholder="Value (Forwards)">
		</div>
		<div class="form-group">
			<input type="number" class="form-control" name="valueOfDPoints" placeholder="Value (Defensemen)">
		</div>
		<div class="form-group">
			<label for="valueOfWins">Wins:</label>
			<input type="number" class="form-control" name="valueOfWins" placeholder="Value (Goalies)">
		</div>
		<br>
		<div class="form-group">
			<label for="valueOfAssists">Assists:</label>
			<input type="number" class="form-control" name="valueOfAssists" placeholder="Value (Forwards)">
		</div>
		<div class="form-group">
			<input type="number" class="form-control" name="valueOfDAssists" placeholder="Value (Defensemen)">
		</div>
		<div class="form-group">
			<label for="valueOfOTLs">OTLs:</label>
			<input type="number" class="form-control" name="valueOfOTLs" placeholder="Value (Goalies)">
		</div>
		<br>
		<div class="form-group">
			<label for="valueOfPIMs">Penalty Minutes:</label>
			<input type="number" step="0.1" class="form-control" name="valueOfPIMs" placeholder="Value (Forwards)">
		</div>
		<div class="form-group">
			<input type="number" step="0.1" class="form-control" name="valueOfDPIMs" placeholder="Value (Defensemen)">
		</div>
		<div class="form-group">
			<label for="valueOfShutouts">Shutouts:</label>
			<input type="number" class="form-control" name="valueOfShutouts" placeholder="Value (Goalies)">
		</div>
		<br>
		<small>(Note: If your pool counts goals and assists equally, set <mark>Goals</mark> to the value for <mark>Points</mark> and <mark>Assists</mark> to '1'.)</small>
		<br>
	<button type="submit" id="submit" class="btn btn-primary">Submit</button>
</form>
<table class="table table-striped table-bordered" id="allTable" cellspacing="0">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Age</th>
			<th>Team</th>
			<th>Pos</th>
			<th>GP</th>
			<th>Pool Points</th>
			<th><abbr title="Pool Points per 82 games">PP/82</abbr></th>
		</tr>
	</thead>
</table>