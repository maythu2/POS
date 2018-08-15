<?php 
include("master.php");
include("Confs/config.php");
include("Public/css/rep_style.css");
include("Model/Invoice.php");
$Invoice = new Invoice_class();
if (isset($_GET['id'])) {

    $inv_name=$Invoice->select_invoice_name($_GET['id']);

    $menu = $Invoice->select_invoice($_GET['id']);
    $set_all_menu=array();
    foreach ($menu as $key => $value) {
        if ($value["is_itemset"]==1) {
            $setmenu_name = $Invoice->select_set_menu($value["item_id"]);
        }else{
            $setmenu_name= '0';
        }
        $setmenu_arr= [
                        'set_menu'=>$setmenu_name,
                        'menu'=>$value,
                    ];
        array_push($set_all_menu, $setmenu_arr);
    }
}

$arr=array();

foreach ($set_all_menu as $key => $value) {
   $arr['sum'] += $value["menu"]["price"]*$value["menu"]["qty"];
   $arr['discount'] = $value['menu']['discount'];
   $arr['total'] = $value['menu']['total'];
}
?>
<div class="col-md-12 invoice">
    <h5>KOBEBUSSAN Myanmar</h5>
    <p>Yangon City</p> 
    <p>Gamonpwint Condo,</p>
    <p>Myanmar</p>
    
    <div>
    	<label>Receipt No - <?php echo $inv_name['id']; ?></label>
    	<p style="text-align: left;float: right;">Temp- Temp_<?php echo $inv_name['id']; ?></p>
    </div>
    <div>
        <label>Cashier:DDD</label>
        <p style="text-align: left;float: right;"> Name - <?php echo $inv_name['inv_name'] ?></p>
    </div>
    <div>	
    	<label>Shift No.<?php echo $inv_name['id']; ?></label>
    	<p style="text-align: left;float: right;"><?php echo date("d-m-Y"); ?></p>
    </div>
    <div>
    	<div align="center">
        	<table class="table table-hover">
        		<thead class="thead">
        			<tr>
                        <td>NO</td>
        				<td>Menu</td> 
        				<td>QTY</td> 
        				<td style="text-align:center;">AMOUNT</td> 
        			</tr>
        		</thead>
        		<?php foreach ($set_all_menu as $key => $value): ?>
        		<?php if ($value["set_menu"] == '0'){?>
        			<tbody>
	                    <tr>
                            <td><?php echo $key+1;?></td>
                            <td><?php echo $value["menu"]["name"]; ?></td> 
	                        <td><?php echo $value["menu"]["qty"]; ?></td>
	                        <td style="text-align:center;"><?php echo $value["menu"]["price"]*$value["menu"]["qty"]; ?></td> 
	                    </tr>
                	</tbody>
                <?php }else{  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $key+1;?></td>
                            <td><?php echo $value["menu"]["name"]; ?></td> 
                            <td><?php echo $value["menu"]["qty"]; ?></td>
                            <td style="text-align:center;"><?php echo $value["menu"]["price"]*$value["menu"]["qty"]; ?></td> 
                        </tr>
                    </tbody>
                    <?php foreach ($value['set_menu'] as $key => $set_name) { ?>
                        <tbody>
                            <tr>
                                <td colspan="1"></td>
                                <td style="padding-left: 25px !important;padding-top: 0px !important;color: #919FB1;"><?php echo $set_name["name"]; ?></td> 
                                <td colspan="1"></td>
                                <td style="padding-left: 25px !important;padding-top: 0px !important;color: #919FB1;text-align:center;"><?php echo $set_name["price"]; ?></td> 
                            </tr>
                        </tbody>
                    <?php } ?>   
        		<?php } ?>
        		<?php endforeach ?>
                <tfoot class="tfoot">
                <tr>
                    <td colspan="2"></td> 
                    <td>Subtotal</td> 
                    <td style="text-align:center;"><?php echo $arr["sum"]; ?></td>
                </tr> 
                <tr>
                    <td colspan="2"></td> 
                    <td>Discount %</td> 
                    <td style="text-align:center;"><?php echo $arr["discount"]; ?>%</td>
                </tr> 
                <tr>
                    <td colspan="2"></td> 
                    <td>Total</td> 
                    <td style="text-align:center;"><?php echo $arr["total"]; ?></td>
                </tr> 

                </tfoot>           
    		</table>
    	</div>
	</div>
<script type="text/javascript">
$(document).ready( function () {
    // $('.main_table').DataTable();
} );
</script>