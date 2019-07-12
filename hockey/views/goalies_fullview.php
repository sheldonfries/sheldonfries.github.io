<form action="goalies.php" method="post" class="form-inline">
		<div class="form-group">
			<label for="valueOfWins">Wins:</label>
			<input type="number" class="form-control" id="valueOfWins" placeholder="Value">
		</div>
		<div class="form-group">
			<label for="valueOfOTLs">OTLs:</label>
			<input type="number" class="form-control" id="valueOfOTLs" placeholder="Value">
		</div>
		<div class="form-group">
			<label for="valueOfShutouts">Shutouts:</label>
			<input type="number" class="form-control" id="valueOfShutouts" placeholder="Value">
		</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
<br>
<div><button id="export" data-export="export" class="btn btn-info">Export to CSV</button></div>
<br>
<div class="col-xs-2 pull-right">
  <input type="number" class="form-control" id="min" name="min">
</div>
<div class="col-xs-1 pull-right">
  GP Filter:
</div>
<table class="table table-striped table-bordered" id="goalieTable" cellspacing="0">
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
	<tbody>
		<?php
		
		$counter = 1;
		foreach ($positions as $position)
        {
            print("<tr>");
            print("<td>" . $counter . "</td>");
            print("<td>" . $position["name"] . "</td>");
            print("<td>" . $position["pos"] . "</td>");
            print("<td>" . $position["age"] . "</td>");
            print("<td>" . $position["team"] . "</td>");
            print("<td>" . $position["gp"] . "</td>");
            print("<td>" . $position["wins"] . "</td>");
            print("<td>" . $position["losses"] . "</td>");
            print("<td>" . $position["ot"] . "</td>");
            print("<td>" . $position["svp"] . "</td>");
            print("<td>" . $position["so"] . "</td>");
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
	var t = $('#goalieTable').DataTable({
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
  	$("#goalieTable").tableToCSV();
	});
</script>