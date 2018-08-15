<?php
    ini_set('display_errors', 1);
	include("master.php");
    include("Confs/config.php");
	include("Public/css/style.css");
    include("Model/Menu.php");
?>
<div class="container" style="background-color:#dee2e6;padding-top: 1px;">
<h2>Create Menu</h2>
<div class="row">
        <input type="checkbox" value="yes" class="checkbox" id="is_setmenu">
        <label class="label">Set Menu</label>
</div>
<div id="menu">
    <div class="row">
        <div class="c4">
       	</div> 
        <div class="c2">
        	Name:
        </div>
        <div class="c2">
            <input type="text" value="" class="inv name">
        </div>
        <div class="c4">
    	</div>
    </div>
    </br>
    <div id="validation-errors-name" >
    </div>
	</br>
    <div class="row">
        <div class="c4">
       	</div> 
        <div class="c2">
        	Price:
        </div>
        <div class="c2">
            <input type="text" value="" class="inv price allowint">
        </div>
        <div class="c4">
    	</div>
    </div>
    </br>
    <div id="validation-errors-price">
    </div>
    </br>
    <div class="row">
        <div class="c4">
       	</div> 
        <div class="c2">
        	Description:
        </div>
        <div class="c2">
            <input type="text" value="" class="inv description">
        </div>
        <div class="c4">
    	</div>
    </div>
    </br>
    <div id="validation-errors-desc">
    </div>
    </br>
    <div>
        <button class="save" id="menu_save">Save</button> 
    </div>
</div>
</br>
<div id="setmenu">
    <div class="row">
        <div class="c4">
        </div> 
        <div class="c2">
            Menu Set Name:
        </div>
        <div class="c2">
            <input type="text" value="" class="inv set_name">
        </div>
        <div class="c4">
        </div>
    </div>
    </br>
    <div id="validation-errors-set_name">
    </div>
    </br>
    <div class="row">
        <div class="c4">
        </div> 
        <div class="c2">
            <label>Choose Menu:</label>
        </div>
        <div class="c2 checkitem">
        </div>
        <div class="c4">
        </div>
    </div>
    </br>
    <div id="validation-errors-set_menu">
    </div>
    </br>
    <div class="row">
        <div class="c4">
        </div> 
        <div class="c2">
            Menu Set Price:
        </div>
        <div class="c2">
             <input type="text" value="" class="inv set_price allowint">
        </div>
        <div class="c4">
        </div>
    </div>
    </br>
    <div id="validation-errors-set_prices">
    </div>
    </br>
    <div class="row">
        <div class="c4">
        </div> 
        <div class="c2">
            Description:
        </div>
        <div class="c2">
            <input type="text" value="" class="inv set_desc">
        </div>
        <div class="c4">
        </div>
    </div>
    </br>
    <div id="validation-errors-set_description">
    </div>
    </br>
    <div>
        <button class="save" id="set_save">Save</button> 
    </div>
</div>
</br>
</div>
<script type="text/javascript">
$(".allowint").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
});
var sum=0;
var index = [];
$('document').ready(function(){
     if($("#is_setmenu").is(":checked")) {
        $("#setmenu").show();
        $("#menu").hide();
    }else{
        $("#setmenu").hide();
        $("#menu").show();
    }
})
$('#is_setmenu').change(function() {
    if($(this).is(":checked")) {
        $("#setmenu").show();
        $("#menu").hide();
        $.ajax({
            type:'get',
            url:'Controller/item.php',
            data: {not_set:"not_set"},
            datatype:'json',
            success:function(result){
                var data=JSON.parse(result);
                // console.log(typeof(data));
                $(".checkitem").html('');
                data.map(function(e){
                    var check ="<div class='row'><input type='checkbox' name='"+e.name+"' price='"+e.price+"' id='checkbox1' value='"+ e.id +"'><label class='setlabel'>"+e.name+"</label></div>";
                    $(".checkitem").append(check);
                })
            }
        })      
    }else{
        $("#setmenu").hide();
        $("#menu").show();
    }
});
$('.checkitem').delegate('input:checkbox', 'change', function(){ 
    var price = $(this).attr('price');
    var id = parseInt($(this).val());
    var name = $(this).attr('name');
    if($(this).is(":checked") ) {
        sum += parseInt(price);
        index.push(id);
    }else{
        sum = parseInt(sum)- parseInt(price);
        var uncheck_id = index.indexOf(id);
        index.splice(uncheck_id , 1);
    }
    $(".set_price").val(sum);
});
$('#menu_save').click(function(){
        var name = $('.name').val();
        var price = $('.price').val();
        var desc = $('.description').val();
        console.log(index);
        $.ajax({
            type:'post',
            url:'Controller/item.php',
            datatype:'json',
            data:{
                menu_save:"menu_save",
                name:name,
                price:price,
                description:desc,
            },
            success:function(result){
                    console.log(result);
                    if (result==1) {
                        window.location.href ="menu_list.php";
                    }else{
                        var d=JSON.parse(result);

                        $('#validation-errors-name').html("");
                        $('#validation-errors-price').html("");
                        $('#validation-errors-desc').html("");
                        $.each(d, function( i, e ){
                            if (e.name != undefined) {
                                $('#validation-errors-name').append('<div style="margin-left: 507px;color:#a36104;" >'+e.name+'</div>');
                            };
                            if (e.price != undefined) {
                                $('#validation-errors-price').append('<div style="margin-left: 507px;color:#a36104;">'+e.price+'</div>');
                            };
                            if (e.desc != undefined) {
                                $('#validation-errors-desc').append('<div style="margin-left: 507px;color:#a36104;">'+e.desc+'</div>');
                            };
                        }); 
                    };
            }
        })
    })
$('#set_save').click(function(){
        var set_name = $('.set_name').val();
        var set_price = $('.set_price').val();
        var set_desc = $('.set_desc').val();
        console.log(index);
        $.ajax({
            type:'post',
            url:'Controller/item.php',
            datatype:'json',
            data:{
                set_save:"set_save",
                id:index,
                name:set_name,
                price:set_price,
                description:set_desc,
            },
            success:function(result){
                if (result==1) {
                    window.location.href ="menu_list.php";
                }else{
                    var d=JSON.parse(result);

                        $('#validation-errors-set_name').html("");
                        $('#validation-errors-set_menu').html("");
                        $('#validation-errors-set_prices').html("");
                        $('#validation-errors-set_description').html("");
                        $.each(d, function( i, e ){
                            if (e.set_name != undefined) {
                                $('#validation-errors-set_name').append('<div style="margin-left: 507px;color:#a36104;" >'+e.set_name+'</div>');
                            };
                            if (e.set_menu != undefined) {
                                $('#validation-errors-set_menu').append('<div style="margin-left: 507px;color:#a36104;">'+e.set_menu+'</div>');
                            };
                            if (e.set_prices != undefined) {
                                console.log(e.set_prices);
                                $('#validation-errors-set_prices').append('<div style="margin-left: 507px;color:#a36104;">'+e.set_prices+'</div>');
                            };
                            if (e.set_desc != undefined) {
                                $('#validation-errors-set_description').append('<div style="margin-left: 507px;color:#a36104;">'+e.set_desc+'</div>');
                            };
                        }); 
                    };
            }
        })
    })
</script>