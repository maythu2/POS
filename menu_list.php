<?php 
include("master.php");
include("Confs/config.php");
include("Public/css/style.css");
include("Model/Menu.php");
$Menu = new Menu_class();
$menu = $Menu->select_set_menu($conn);
?>
<div class="container" >
	<h2>Menu List</h2>
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
       		<a href="index.php"><button>Back</button></a>
        </div>
        <div class="c2">
            <a href="create_menu.php"><button>Create Menu</button></a>
        </div>
    </div>
	</br>
	<table class="table table-bordered main_table">
		<thead>
		        <tr>
		            <th>No</th>
		            <th>Menu Name</th>
		            <th>Price</th>
		            <th>Description</th>
		            <th>is_itemset</th>
		            <th>Detail</th>
		        </tr>
		</thead>
		<tbody id="t_body">
			<?php foreach ($menu as $key => $value): ?>
				<tr>
			        <td colspan="1" style="text-align: center;"><?php echo $value['id']; ?></td>
			        <td colspan="1" style="text-align: center;"><?php echo $value['name']; ?></td>
			        <td colspan="1" style="text-align: center;"><?php echo $value['price']; ?></td>
			        <td colspan="1" style="text-align: center;"><?php echo $value['description']; ?></td>
			        <td colspan="1" style="text-align: center;"><?php echo $value['is_itemset']; ?></td>
			        <td colspan="1" style="text-align: center;"><a href="menu_detail.php?id=<?php echo $value['id'] ?>"><button>Detail</button></a></td>
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