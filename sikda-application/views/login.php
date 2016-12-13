<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>SIKDA Generik</title>
	
	<link href="<?=base_url()?>assets/images/icon-kemkes.png" rel="shortcut icon" type="text/css" />
	<link href="<?=base_url()?>assets/achtung/ui.achtung-mins.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url()?>assets/jquery-ui-1.9.0.custom/css/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" media="screen" />
	
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/achtung/ui.achtung-min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/achtung/achtung.js"></script>	
	<script type="text/javascript" src="<?=base_url()?>assets/jquery-ui-1.9.0.custom/js/jquery-ui-1.9.0.custom.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-validation/dist/jquery.validate.js"></script>	
	<style>
		html,body 
		{
			font-family:helvetica,tahoma,arial;
			width:100%;
			height:100%;
			margin:0px;
			padding:0px;
			background:#F0F8FF;
		}
		#dialog-form{
			width:355px;
			position:fixed;
			align:left;
			text-align:center;
			top: 50%;
			left: 50%;
			height:16em;
			margin-top: -5em; /*set to a negative number 1/2 of your height*/
			margin-left: -15em; /*set to a negative number 1/2 of your width*/
			padding:15px;
			background-image:url(<?=base_url()?>assets/images/bg-midle.png);
			background-position:bottom right;
			font-size:.9em;
			color:#000000;
			-webkit-border-radius: 7px;
			-moz-border-radius: 7px;
			border-radius: 7px;;
		}
		#dialog-form label, input,select {margin:7px 0 0 3px;padding:0 0 0 0; }
        #dialog-form input.text, select { margin-bottom:3px; width:65%; padding: 3px;}
        #dialog-form fieldset { padding:0; border:0; margin-top:1px; }
		
		#dialog-form label {
			display: block;
			font-weight: bold;
			text-align: left;
			float: left;
			width:99px;
		}
		#dialog-form label.error {
			float: none;
			font-size: 11px;
			color: white;
			width:100%;
			margin: -3px 0px 0px 109px;
		}
		
		.header{ 
			height:125px;
			padding-top:0px;
			background-repeat:repeat-x;
			width:auto;
			background-image:url(<?=base_url()?>assets/images/repeat.png);
			background-position:bottom right;
			text-align: left;
			overflow:hidden;
		}
		#footer {
		   position:absolute;
		   bottom:0;
		   width:100%;
		   height:15px;		   		   		   
		   background-color:#006699;;
		   padding:5px 0 5px 0;		   
		}
		.footertext{		
			font-size:.7em;
			color:#FFFFFF;
			width:255px;
			padding:5px 0 5px 9px;
		}
		.sikda_button{
			background-image: -moz-linear-gradient(center top , #FFFFFF, #DBDBDB);
			border-radius: 18px 18px 18px 18px;
			box-shadow: 0 0 4px rgba(0, 0, 0, 0.4);
			color: #597390;
			font-size: 1.23em;
			font-weight: bold;
			line-height: 24px;
			padding: 5px 7px!important;
			text-decoration: none;
			text-shadow: 0 1px 0 #FFFFFF;
		}
		#button-login:hover{
			cursor:pointer;
		}
		#p_patch{
			font-size:12px;
			float:right;
			margin: 10px;
		}
	</style>
<script>
$('document').ready(function() {	
	$("#kd_puskesmas").val('');     
	$("#form-login").validate({focusInvalid:true});     
		
	$( "#name" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				if($(this).valid()){
					$('#password').focus();
				}
				return false;				
			}
	});
	
	$( "#password,#kd_puskesmas" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				if($("#form-login").valid()) {	
					$('#form-login').ajaxForm({
						beforeSend: function() {
							achtungShowLoader();
						},
						uploadProgress: function(event, position, total, percentComplete) {
						},
						complete: function(xhr) {			
							var res = xhr.responseText.split('_');
							if(res[0]!=='OK'){
								$.achtung({message: xhr.responseText, timeout:5});
							}else{
								if(res[1]!='')$.achtung({message: res[1], timeout:10});
								setTimeout(function(){window.location = '<?=site_url('dashboard')?>';},1000);
							}
							achtungHideLoader();
						}
					});
				}
				$("#form-login").submit();
			}
	});
	
	$( "#button-login" )
		.on("click",function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
				if($("#form-login").valid()) {	
					$('#form-login').ajaxForm({
						beforeSend: function() {
							achtungShowLoader();
						},
						uploadProgress: function(event, position, total, percentComplete) {
						},
						complete: function(xhr) {			
							var res = xhr.responseText.split('_');
							if(res[0]!=='OK'){
								$.achtung({message: xhr.responseText, timeout:5});
							}else{
								if(res[1]!='')$.achtung({message: res[1], timeout:10});
								setTimeout(function(){window.location = '<?=site_url('dashboard')?>';},1000);
							}
							achtungHideLoader();
						}
					});
				}
				$("#form-login").submit();
			
	});
	
	$("#form-login input:text").first().focus();
	
	//var errmsg = '<?php echo $this->session->flashdata('errmsg')?$this->session->flashdata('errmsg'):"";?>';
	//if(errmsg)$.achtung({message: errmsg, timeout:7});
});
</script>
</head>
<body>
<div class="header">
<img src="<?=base_url()?>assets/images/left-front.png" alt="logo-sikda" />
<span style="float:right"><img src="<?=base_url()?>assets/images/right.png" alt="logo-kemkes" /></span>
</div>
<!------------------------------------------------------LOGIN FORM ---------------------------------------------------------------->
<!-- <p id="p_patch">Lakukan hanya sekali: <a href="login/patchdatabase" id="link_patch">patch database 1.0</a></p> -->
<div id="dialog-form" title="Login">
    <p class="validateTips">Silahkan Mengisi Username dan Password Anda.</p> 
    <form id="form-login" action="login/mlogin" method="post">
    <fieldset>
		<p>
		<label for="username">Username</label>
        <input type="text" name="username" id="name" class="text ui-widget-content ui-corner-all" value="" required />
        </p>
		<p>
		<label for="password">Password</label>
        <input type="password" name="password" id="password" class="text ui-widget-content ui-corner-all" value="" required />		
		</p>
		<p>
		<label for="kd_puskemas">Puskesmas</label>
        <select name="kd_puskesmas" id="kd_puskesmas" class="">
			<option value="" selected>Silahkan Pilih</option>
			<?php foreach($pusk as $psk){?>
				<option value="<?=$psk->kd_puskesmas?>"><?=$psk->NAMA_PUSKESMAS?></option>
			<?php }?>
		</select>

		<input type="button" name="bt1" id="button-login" style="float:right;margin-right:5px;padding:3px" value="Login" class="ui-widget-content ui-corner-all" >
		
        </p>
	</fieldset>
    </form>
</div>
<div id="footer"><span class="footertext">&copy; 2014 SIKDA Generik - All Rights Reserved</span></div>
<!------------------------------------------------------END LOGIN FORM ---------------------------------------------------------------->
</body>
</html>
