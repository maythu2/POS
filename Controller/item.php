<?php 
include("../Confs/config.php");
ini_set('display_errors', 1);
include ("../Model/Menu.php");

$Menu = new Menu_class();

// for add menu
if (isset($_GET['id'])) {
	$menu = $Menu->select_menu_name($_GET['id']);
	echo $menu;
}
//for autocomplete use select2
if (isset($_GET['data'])){
	$menu_name = $Menu->select_all_menu();
	echo $menu_name;
}
//for create set menu
if (isset($_GET['not_set'])) {
	$menu = $Menu->select_not_set();
	echo $menu;
}

//for save menu 
if (isset($_POST['menu_save'])) {

	$name = $_POST['name'];
	$price = $_POST['price'];
	$desc = $_POST['description'];
	if ($name=="" || $price==""||$desc=="") {
				$error=array();
				if ($name=="") {
					$item_error_sms = ["name"=>"menu name is required"];
					array_push($error, $item_error_sms);
				}
				if ($price=="") {
					$c_error_sms = ["price"=>"price is required"];
					array_push($error, $c_error_sms);
				}
				if ($desc=="") {
					$s_error_sms = ["desc"=>"desc is required"];
					array_push($error, $s_error_sms);
				}
				echo json_encode($error);
				exit;
	}	
	$menu = $Menu->save_menu($name,$price,$desc);
	echo $menu;
}
//for save set menu
if (isset($_POST['set_save'])) {
	$set_name = $_POST['name'];
	$set_price = $_POST['price'];
	$set_desc = $_POST['description'];
	$menu_id = $_POST['id'];

	if ($set_name=="" || $set_price==""||$set_desc=="" || $menu_id=="") {
				$error=array();
				if ($set_name=="") {
					$item_error_sms = ["set_name"=>"set name is required"];
					array_push($error, $item_error_sms);
				}
				if ($set_price=="") {
					$c_error_sms = ["set_prices"=>"set price is required"];
					array_push($error, $c_error_sms);
				}
				if ($set_desc=="") {
					$s_error_sms = ["set_desc"=>"set desc is required"];
					array_push($error, $s_error_sms);
				}
				if ($menu_id=="") {
					$m_error_sms = ["set_menu"=>"set menu is required"];
					array_push($error, $m_error_sms);
				}
				echo json_encode($error);
				exit;
	}	

	$set = $Menu->save_set_menu($set_name,$set_price,$set_desc,$menu_id,$conn);
	echo $set;
}

?>