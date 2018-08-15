<?php 
include("master.php");
include("Confs/config.php");
include("Public/css/style.css");
include("Model/Menu.php");
include("Model/Invoice.php");
$Menu = new Menu_class();
$Invoice= new Invoice_class();
if (isset($_GET['id'])) {
	$detail_all_menu=array();
	$detail_menu=$Menu->select_menu_detail($_GET['id']);
	if ($detail_menu["is_itemset"]==1) {
		$setdetail_menu=$Invoice->select_set_menu($_GET['id']);
	}else{
        $setdetail_menu= '0';
    }
    $menu_detail_arr= [
                        'set_detail_menu'=>$setdetail_menu,
                        'menu'=>$detail_menu,
                    ];
    array_push($detail_all_menu, $menu_detail_arr);

}
// echo "<pre>";
// var_dump($detail_all_menu);
// echo "</pre>";
?>
<div class="container" align="center">
	<table class="table table-hover">
		<thead class="thead">
			<tr>
                <td>NO</td>
				<td>Menu</td> 
				<td>Description</td> 
				<td style="text-align:center;">AMOUNT</td> 
			</tr>
		</thead>
		<?php foreach ($detail_all_menu as $key => $value): ?>
		<?php if ($value["set_menu"] == '0'){?>
			<tbody>
                <tr>
                    <td><?php echo $key+1;?></td>
                    <td><?php echo $value["menu"]["name"]; ?></td> 
                    <td><?php echo $value["menu"]["description"]; ?></td>
                    <td style="text-align:center;"><?php echo $value["menu"]["price"]?></td> 
                </tr>
        	</tbody>
        <?php }else{  ?>
            <tbody>
                <tr>
                    <td><?php echo $key+1;?></td>
                    <td><?php echo $value["menu"]["name"]; ?></td> 
                    <td><?php echo $value["menu"]["description"]; ?></td>
                    <td style="text-align:center;"><?php echo $value["menu"]["price"]; ?></td> 
                </tr>
            </tbody>
            <?php foreach ($value['set_detail_menu'] as $key => $set_name) { ?>
                <tbody>
                    <tr>
                        <td colspan="1"></td>
                        <td style="color: #919FB1;text-align:center;"><?php echo $set_name["name"]; ?></td> 
                        <td colspan="1"></td>
                        <td style="color: #919FB1;text-align:center;"><?php echo $set_name["price"]; ?></td> 
                    </tr>
                </tbody>
            <?php } ?>   
		<?php } ?>
		<?php endforeach ?>         
	</table>
</div>