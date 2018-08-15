<?php 
class Menu_class {
	function select_set_menu($conn){
		$sql = "SELECT * FROM items WHERE is_deleted!=1";
		$menu_name = mysql_query($sql);
		$array = [];
		if (mysql_num_rows($menu_name) > 0) {
		    while($row = mysql_fetch_assoc($menu_name)) {
		       $array[] = $row;     
		    }
		} else {
		    echo "0 results";
		}
		return $array;
	}
	//for autocomplete use select2
  	function select_all_menu() {
	    $sql = "SELECT * FROM items WHERE is_deleted!=1";
		$menu_name = mysql_query($sql);
		$array = [];
		if (mysql_num_rows($menu_name) > 0) {
		    while($row = mysql_fetch_assoc($menu_name)) {
		       $array[] = $row;     
		    }
		} else {
		    echo "0 results";
		}
		return json_encode($array);
  	}
  	// for add menu
  	function select_menu_name($id){
  		$sql = "SELECT * FROM items WHERE id = $id AND is_deleted!=1";
		$menu = mysql_query($sql);
		if (mysql_num_rows($menu) > 0) {
		    while($row = mysql_fetch_assoc($menu)) {
		         return json_encode($row);
		    }
		} else {
		    echo "0 results";
		}
		
  	}
  	// for create set menu
  	function select_not_set(){
  		$sql = "SELECT * FROM items WHERE is_itemset!=1 AND is_deleted!=1";
		$menu = mysql_query($sql);
		$array = [];
		if (mysql_num_rows($menu) > 0) {
		    while($row = mysql_fetch_assoc($menu)) {
		       $array[] = $row;     
		    }
		} else {
		    echo "0 results";
		}
		return json_encode($array);
  	}
  	//for save menu
  	function save_menu($name,$price,$desc){
  		$sql="INSERT INTO  items(name,price,description,is_itemset,is_deleted) 
			VALUES ('$name','$price','$desc','0','0') ";
		$result=mysql_query($sql);

		echo $result;
  	}
  	//for save set menu
  	function save_set_menu($name,$price,$desc,$menu_id,$conn){
  		$sql="INSERT INTO  items(name,price,description,is_itemset,is_deleted) 
			VALUES ('$name','$price','$desc','1','0') ";
		$result=mysql_query($sql);

		$set_id = mysql_insert_id($conn);

		$query = "INSERT INTO  items_set(item_id,set_id,is_deleted) VALUES";
		foreach($menu_id as $value) {
			$query .= "('".$value."', '".$set_id."', '0'),";
		}

		$mysql = rtrim($query, ',');

		$result=mysql_query($mysql);

		echo $result;
  	}
  	// for menu detail
  	function select_menu_detail($id){
  		$sql = "SELECT * FROM items WHERE id = $id AND is_deleted!=1";
		$menu = mysql_query($sql);
		if (mysql_num_rows($menu) > 0) {
		    while($row = mysql_fetch_assoc($menu)) {
		         return $row;
		    }
		} else {
		    echo "0 results";
		}
  	}

}

?>