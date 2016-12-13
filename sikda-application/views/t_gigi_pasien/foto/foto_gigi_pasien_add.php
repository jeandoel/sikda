<script>
$(document).ready(function(){
		$('#formgigifotogigipasienadd').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				if(xhr.responseText!=='OK'){
					$.achtung({message: xhr.responseText, timeout:5});
				}else{
					$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
					$("#tabs").empty();
					$("#tabs").load('t_gigi_pasien'+'?_=' + (new Date()).getTime());
				}
			}
		});
		// $("#bt_foto").click(function(){
		// 	var post_url = $("#formgigifotogigipasienadd").attr("action");
		// 	var formData = new FormData($("#formgigifotogigipasienadd").get(0));

		// 	achtungShowLoader();
		// 	$.ajax({
		// 		url:post_url,
		// 		type:"POST",
		// 		data:formData,
		// 		cache:false,
		// 		contentType:false,
		// 		processData:false,
		// 		success:function(data, status, xhr){
		// 			achtungHideLoader();
		// 			var errorcode = xhr.getResponseHeader("error_code");
		// 			var warning = xhr.getResponseHeader("warning");
		// 			if(errorcode=="0"){ 
		// 				$("#dialogt_gigi").dialog("close");	
		// 				$('#listt_gigi').trigger( 'reloadGrid' );
		// 				$('#formgigifotogigipasienadd').reset();
		// 			}
		// 			achtungCreate(warning);
		// 		}
		// 	})
		// })
		$('#backlistfotogigipasien').click(function(){
			$("#tabs").empty();
			$("#tabs").load('t_gigi_pasien'+'?_=' + (new Date()).getTime());
		})
})
</script>

<div class="mycontent">
<!-- <div class="subformtitle">Tambah Foto <?php echo $tipe_foto;?> Gigi</div> -->
<fieldset>
	<span class="best_resolution_warn">* Ukuran Resolusi Terbaik (W x H) : 400 x 350.</span>
</fieldset>
<form name="frApps" id="formgigifotogigipasienadd" method="post" action="<?=site_url('t_gigi_pasien/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
			<label style="width:90px;font-size:12px;">Gambar Foto</label>
			<input type="hidden" name="kd_pasien" value="<?php echo $kd_pasien;?>">
			<input type="hidden" name="kd_puskesmas" value="<?php echo $kd_puskesmas;?>">
			<input type="hidden" name="types" value="<?php echo $types;?>">
			<input type="hidden" name="kd_foto_gigi" value="">
			<input type="file" name="gambar" id="upload_foto"/>
		</span>
	</fieldset>
<!-- 	<fieldset>
		<span>
			<input type="button" name="bt_foto" id="bt_foto" value="Proses Data" style="font-size:12px;"/>
		</span>
	</fieldset>	 -->
</form>
</div >