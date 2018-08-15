<?php 
include("master.php");
include("Public/css/style.css");
include("Confs/config.php");
include("Model/Invoice.php");
$Invoice = new Invoice_class();
$invoice = $Invoice->select_all_invoice();
?>
<div class="container">
	<h2>Report</h2>
	<div class="row">
        <div class="c4">
            <div class="row">
                <div class="c2">
                </div>
            </div>
        </div>
        <div class="c4">
        </div>
        <div class="c2">
        </div>
        <div class="c2">
            <a href="index.php"><button>Back</button></a>
        </div>
    </div>
	</br>
	<table class="table table-bordered main_table">
		<thead>
		        <tr>
		            <th>No</th>
		            <th>Invoice Name</th>
		            <th>Price</th>
		            <th>Discount</th>
		            <th>Detail</th>
		        </tr>
		</thead>
		<tbody id="t_body">
			<?php foreach ($invoice as $key => $value): ?>
				<tr>
			        <td colspan="1" style="text-align: center;"><?php echo $value['id']; ?></td>
			        <td colspan="1" style="text-align: center;"><?php echo $value["inv_name"]; ?></td>
			        <td colspan="1" style="text-align: center;"><?php echo $value["total"]; ?></td>
			        <td colspan="1" style="text-align: center;"><?php echo $value["discount"]; ?></td>
			        <td colspan="1" style="text-align: center;"><a href="inv_detail_report.php?id=<?php echo $value['id'] ?>"><button>Detail</button></a></td>
			    </tr>		
			<?php endforeach ?>      
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(document).ready( function () {
    // $('.main_table').DataTable();
} );
</script>