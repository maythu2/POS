<?php 
include("../Confs/config.php");
ini_set('display_errors', 1);
include ("../Model/Invoice.php");

$invoice = new Invoice_class();
if (isset($_POST['data'])) {
	foreach ($_POST['menu'] as $key => $value) {
		if ($value['qty']=="") {
			$error = ["qty"=>"qty is required"];
			echo json_encode($error);
			exit;
		}
	}
	$invoice = $invoice->save_invoice($_POST,$conn);
	echo $invoice;
}
?>