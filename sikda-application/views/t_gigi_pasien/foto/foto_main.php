<script type="text/javascript">
$(function(){
	
	 $("input[name='fotoRadio']").change(function(){
	 	var radios = $("input[name='fotoRadio']:checked").val();
	 	if(radios==2){
			$("#main-foto-right").load("t_gigi_pasien/table_foto_pasien/foto_xray_pasien",{
				"url": 'foto_xray_pasien'
			},function(data){
				$('#main_foto').html('');
				$('#no_record_foto').hide();
			});

	 	}else{
			$("#main-foto-right").load("t_gigi_pasien/table_foto_pasien/foto_oral_pasien",{
				"urls": 'foto_oral_pasien'
			},function(data){
				$('#main_foto').html('');
				$('#no_record_foto').hide();
			});
	 	}
	 }).change();
}) 
</script>

<style type="text/css">
	#main_foto_css{
		overflow: hidden;	
		padding: 5px;
	}
	#main-foto-left{
		float: left;
		position: relative;
		width: 420px;
		height: 350px;
		border: 1px solid grey;
		margin-top: 5px;
		background: #000;
	}
	#main-foto-right{
		overflow: hidden;
	}
	#main_foto{
		text-align: center;
		color: white;
	}
	#main_form_gigi_pasien{
		position: absolute;
		bottom: 0px;
		left: 0px;
		right: 0px;
		background: white;
		border-top: 1px solid grey;
		padding: 10px;
	}
	#main_form_gigi_pasien label{
		width: 120px;
	}
	#no_record_foto{
		position: absolute;
		margin-top: 35%;
		left: 0px;
		right: 0px;
		
		font-size: 11px;
		line-height: 1.8;
		padding: 10px;
		color: white;
		text-align: center;
	}
</style>
<fieldset>
	<span>
		<label class="declabel2">Jenis Foto</label>
		<input type="radio" name="fotoRadio" value="1" checked="checked"> Oral		
		<input type="radio" name="fotoRadio" value="2"> X-Ray
	</span>
</fieldset>

<div id="main_foto_css">
	<div id="main-foto-left">
		<div id="main_foto"></div>
		<div id="no_record_foto">Foto tidak ditemukan.<br/>Silahkan upload foto gigi pasien.</div>
		<div id="main_form_gigi_pasien"></div>
	</div>
	<div id="main-foto-right"></div>		
</div>

