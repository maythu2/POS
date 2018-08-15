<?php 
	include("master.php");
	include("Public/css/style.css");
 ?>
 <div class="container">
 	<h2>Food and Beverage Point of Sales Systems</h2>
    <div class="row">
        <div class="c4">
            <div class="row">
                Invoice Name: 
                <div class="c2">
                <input type="text" value="" class="inv" id="invoice_name">
                </div>
            </div>
        </div>
        <div class="c4">
            <select class="js-example-basic-single menu" name="state">
                <option value=""></option>
            </select>
        </div>
        <div class="c2">
       		<a href="menu_list.php"><button>Menu List</button></a>
        </div>
        <div class="c2">
            <a href="inv_report.php"><button>Report</button></a>
        </div>
    </div>
    <div id="row" style="padding-top: 30px;">
    	<table class="table table-bordered main_table">
    		<thead>
                    <tr>
                        <th>No</th>
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
            </thead>
            <tbody id="t_body">
                    
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;"> Sub Total</td>
                    <td colspan="5"><input type="text" value="0" class="subtotal allowint"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">Discount %</td>
                    <td colspan="5"><input type="text" value="0" class="discount allowint"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">Total</td>
                    <td colspan="5"><input type="text" value="0" class="grandtotal" disabled="true"></td>
                </tr>
            </tfoot>
    	</table>
    	<button class="save" style="margin-left: 85%;"> Save</button> 
    </div>
 </div>
<script type="text/javascript">
	var j=1;
	var index=[];
	$('document').ready(function(){
        $('.save').prop('disabled', true);
    })
    // for menu with select2-container
    $('.menu').select2({
         ajax: {
            type: 'get',
            url: "Controller/item.php",
            data: {data:"all_menu"},
            dataType : 'json',
            processResults: function (data) {
             //console.log(typeof(data));
                var arr = [];
                data.map(function(e){
                    var obj = {
                        'id':e.id,
                        'text':e.name
                    }
                    arr.push(obj); 
                })
                return {
                   results: arr
                };
           }
         }
    });
    // for retrieve menu
    $('.menu').change(function(){
        var menu_id=$(this).val();
        $.ajax({
            type:'get',
            url:'Controller/item.php/',
            data: {id:menu_id},
            dataType:'json',
            success:function(results){
            	console.log(results);
                var name = results.name;
                var price = results.price;
                var tr ="<tr class='tr_clone'>"
                        +
                        "<td class='id' indexof= '"+j+"'>"+j+"</td>"+
                        "<td><input type='text' class='menu_name' menu_id='"+ results.id+"'value='"+ name +"'></td>"+
                        "<td><input type='number' class='qty'></td>"+
                        "<td><input type='text' class='price' disabled=true value='"+ price +"'></td>"+
                        "<td><input type='text' class='total' disabled=true></td>"+
                        "<td><button class='delete_row'>Remove</button></td>"
                        +
                        "</tr>";
                if (index.length>0) {
                    console.log(index);
                    if (index.indexOf(results.id) == -1) {
                        $('#t_body').append(tr);
                        index.push(results.id);
                        j++;
                        refresh_Table();
                    }else{
                        alert('menu already selected,please update qty');
                    }
                }else{  
                    $('#t_body').append(tr);
                    index.push(results.id);
                    j++;
                    refresh_Table();
                }
                console.log(index);
                
            }
        })
        $('.save').prop('disabled', false);
    });
	// for delete menu row
    $('#t_body').delegate('.delete_row','click',function(){
        var del_row=$(this).closest('tr');
        del_row.remove();
        var del_id = del_row.find('td .menu_name').attr('menu_id');
        console.log(del_id);
        console.log(index);
        // var del_index = index.indexOf(parseInt(del_id));
        console.log(del_index);
        index.splice(del_index,1);
        console.log(index);
        if (index.length==0){
            $('.save').prop('disabled',true);
        }
        refresh_Table();
        subtotal();
        discount();
    });
    $('body').delegate('.qty','keyup',function(){
        var x=$(this).parent().parent();
        var textValue1 = x.find('.qty').val();
        var textValue2 =x.find('.price').val();
        calc =textValue1*textValue2;
        x.find('.total').val(calc);
        subtotal();
        discount();
    });
    function subtotal(){
            var sum = 0;
            $('.total').each(function(){
            sum += +$(this).val();                           
            });                       
            $('.subtotal').val(sum);      
    }
    // for discount
    $('tfoot').delegate('.discount','keyup',function(){
       discount();
    });
    function discount(){
        var discount= $('.discount').val();
        var sub_total=$('.subtotal').val();
        var grandtotal=sub_total *(1-(discount/100));
        $('.grandtotal').val(grandtotal);
    }
    function refresh_Table(){
        var i=1;
        $('.main_table >tbody>tr').each(function(){
            // var item_id=$(this).find('.item_id').text();
            var menu_name=$(this).find('.menu_name').val();
            var qty=$(this).find('.qty').val();
            var price=$(this).find('.price').val();
            var total=$(this).find('.total').val();
            $(this).find('.id').html(i);
            $(this).find('.menu_name').val(menu_name);
            $(this).find('.qty').val(qty);
            $(this).find('.price').val(price);
            $(this).find('.total').val(total);
            i++;
        });
    }   
    $('.save').click(function(){
        var menus = [];
        $('.tr_clone').each(function(){
            arr={
                menu_id: $(this).find('.menu_name').attr('menu_id'),
                qty: $(this).find('.qty').val(),
                menu_name: $(this).find('.menu_name').val(),
                menu_price: $(this).find('.price').val(),
                is_setmenu: $(this).find('.setmenu').val(),
            };
            menus.push(arr);
        });
        var invoice_name=$('#invoice_name').val();
        if (invoice_name==''){
            alert("Please Insert Invoice name");
            return false;
        }
        var subtotal =$('.subtotal').val();
        var total =$('.grandtotal').val();
        var discount = $('.discount').val();
        $.ajax({
            url : "Controller/invoice.php",
            type : "post",
            data : {
                    data:"invoice",
                    invoice_name:invoice_name,
                    menu : menus,
                    total:total,
                    discount:discount,
                    subtotal:subtotal,
                    },
            dataType: "json",
            success:function(result){
               if (result==1) {
                window.location.href ="inv_report.php";
               }else{
                alert(result.qty);
               };
            }
        });
    }); 
    $(".allowint").on("keypress keyup blur",function (event) {    
               $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
    });
</script>
