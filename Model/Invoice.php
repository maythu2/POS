<?php 
class Invoice_class{
	function save_invoice($conn){
		$inv_name = $_POST['invoice_name'];
		$total = $_POST['total'];
		$discount = $_POST['discount'];

		$sql="INSERT INTO  invoice(inv_name,total,discount,is_deleted) 
			VALUES ('$inv_name','$total','$discount','0') ";

		$result=mysql_query($sql);

		$inv_id = mysql_insert_id();

		$query = "INSERT INTO inv_details(inv_id,item_id,qty,is_deleted) VALUES";
		foreach($_POST['menu'] as $value) {
			$query .= "('".$inv_id."','".$value['menu_id']."', '".$value['qty']."', '0'),";
		}

		$mysql = rtrim($query, ',');

		$result=mysql_query($mysql);

		echo $result;
	}
	function select_invoice_name($id){
		$sql = "SELECT * FROM invoice WHERE id=$id AND is_deleted!=1";
		$menu = mysql_query($sql);
		$array=[];
		if (mysql_num_rows($menu) > 0) {
		    while($row = mysql_fetch_assoc($menu)) {
		    	return $row;
		    }
		} else {
		    echo "0 results";
		}
	}
	function select_all_invoice(){
		$sql = "SELECT * FROM invoice WHERE is_deleted!=1";
		$menu = mysql_query($sql);
		$array=[];
		if (mysql_num_rows($menu) > 0) {
		    while($row = mysql_fetch_assoc($menu)) {
		    	$array[]=$row;
		    }
		} else {
		    echo "0 results";
		}
		return $array;
	}
	function select_invoice($id){
		$sql = "SELECT inv.*,inv_d.item_id,inv_d.qty,inv_d.inv_id,i.name,i.price,i.is_itemset
				FROM invoice inv 
				LEFT JOIN inv_details inv_d ON inv_d.inv_id=inv.id
				LEFT JOIN items i ON i.id=inv_d.item_id
				WHERE inv.id=$id AND inv.is_deleted !=1";
		$menu = mysql_query($sql);
		$array = [];
		if (mysql_num_rows($menu) > 0) {
		    while($row = mysql_fetch_assoc($menu)) {
		    	$array[] = $row;
		    }
		} else {
		    echo "0 results";
		}
		return $array;
	}
	function select_set_menu($id){
		$sql = "SELECT s.item_id,i.name,i.price
				FROM items_set s 
				LEFT JOIN items i ON i.id=s.item_id
				WHERE s.set_id='$id' AND s.is_deleted!=1";
		$menu = mysql_query($sql);
		$array = [];
		if (mysql_num_rows($menu) > 0) {
		    while($row = mysql_fetch_assoc($menu)) {
		    	$array[] = $row;
		    }
		} else {
		    echo "0 results";
		}
		return $array;
	}
}
?>