<form action="goalies.php" method="post" class="form-inline">
		<div class="form-group">
			<label for="valueOfWins">Wins:</label>
			<input type="number" class="form-control" name="valueOfWins" placeholder="Value">
		</div>
		<div class="form-group">
			<label for="valueOfOTLs">OTLs:</label>
			<input type="number" class="form-control" name="valueOfOTLs" placeholder="Value">
		</div>
		<div class="form-group">
			<label for="valueOfShutouts">Shutouts:</label>
			<input type="number" class="form-control" name="valueOfShutouts" placeholder="Value">
		</div>
	<button type="submit" id="submit" class="btn btn-primary">Submit</button>
</form>
<br>
<table class="table table-striped table-bordered" id="goalieTable" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Pos</th>
			<th>Age</th>
			<th>Team</th>
			<th>GP</th>
			<th>W</th>
			<th>L</th>
			<th>OTL</th>
			<th>Sv%</th>
			<th>SO</th>
			<th>Pool Points</th>
			<th><abbr title="Pool Points per 70 games">PP/70</abbr></th>
		</tr>
	</thead>
</table>