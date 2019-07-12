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
<button id="export" data-export="export" class="btn btn-info">Export to CSV</button>
<br>
<div class="col-xs-2 pull-right">
  <input type="number" class="form-control" id="min" name="min">
</div>
<div class="col-xs-1 pull-right">
  GP Filter:
</div>
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
	<tfoot>
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
	</tfoot>
	<tbody>
		<?php
		
		$counter = 1;
			foreach ($positions as $position)
        {
            print("<tr>");
            print("<td>" . $counter . "</td>");
            print("<td>" . $position["name"] . "</td>");
            print("<td>" . $position["age"] . "</td>");
            print("<td>" . $position["team"] . "</td>");
            print("<td>" . $position["position"] . "</td>");
            print("<td>" . $position["gp"] . "</td>");
            print("<td>" . $position["poolpoints"] . "</td>");
            print("<td>" . $position["pp82"] . "</td>");
            print("</tr>");
            $counter++;
        }
		
		?>
	</tbody>
</table>
<script type="text/javascript">
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = parseInt( $('#min').val(), 10 );
        var max = parseInt( $('#max').val(), 10 );
        var age = parseFloat( data[5] ) || 0; // use data for the age column
 
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }
        return false;
    }
);

$(document).ready(function(){
    var t = $('#allTable').DataTable({
    	"pageLength": 50,
    	"columnDefs": [
    		{ "orderable": false, "targets": 0 }
  		]
    });
    
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    
    $('#min, #max').keyup( function() {
        table.draw();
    } );
});
</script>

<script type="text/javascript">
		$("#export").click(function(){
  	$("#allTable").tableToCSV();
	});
</script>