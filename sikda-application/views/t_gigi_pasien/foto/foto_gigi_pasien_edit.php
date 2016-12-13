<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<script>
$(document).ready(function(){
		$('#formgigimastergigiedit').ajaxForm({
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
		$("#bt_foto").click(function(){
			var post_url = $("#formgigimastergigiedit").attr("action");
			var formData = new FormData($("#formgigimastergigiedit").get(0));

			achtungShowLoader();
			$.ajax({
				url:post_url,
				type:"POST",
				data:formData,
				cache:false,
				contentType:false,
				processData:false,
				success:function(data, status, xhr){
					achtungHideLoader();
					var errorcode = xhr.getResponseHeader("error_code");
					var warning = xhr.getResponseHeader("warning");
					if(errorcode=="0"){ 
						// $('#listt_gigi').trigger( 'reloadGrid' );
						$("#dialogt_gigi").dialog("close");
						var url = getPathFromUrl($("#main_foto img").attr("src"));
						if (!Date.now) {
						    var timestamp = Date().getTime();
						}else{
						  	var timestamp = Date.now();
						}
						$("#main_foto img").attr("src",url+"?"+timestamp)
						$('#formgigimastergigiedit').reset();
						$("#main_form_gigi_pasien").hide();
					}
					achtungCreate(warning);
				}
			})
		})
		$('#backlistfotogigipasien').click(function(){
			$("#tabs").empty();
			$("#tabs").load('t_gigi_pasien'+'?_=' + (new Date()).getTime());
		})
})
function getPathFromUrl(url) {
  return url.split("?")[0];
}
</script>

<div class="mycontent">
<fieldset>
	<span class="best_resolution_warn">* Ukuran Resolusi Terbaik (W x H) : 400 x 350.</span>
</fieldset>
<!-- <div class="subformtitle">Edit Foto <?php if($data->TIPE_FOTO == 1){echo 'Oral';}else{echo 'X-Ray';} ?> Gigi</div> -->
<form name="frApps" id="formgigimastergigiedit" method="post" action="<?=site_url('t_gigi_pasien/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label style="width:95px;font-size:12px;">Nama Gambar</label>
		<input type="text" readonly="readonly" name="gambar" id="gambar" value="<?=$data->GAMBAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label style="width:95px;font-size:12px;">Gambar</label>
		<input type="file" name="gambar" id="upload_foto" />
		<input type="hidden" name="types" id="types" value="<?php echo $data->TIPE_FOTO?>">
		<input type="hidden" name="kd_foto_gigi" id="kd_foto_gigi" value="<?=$data->KD_FOTO_GIGI?>" />
		<input type="hidden" name="tanggal" id="tanggal" value="<?=$data->TANGGAL?>" />
		</span>
	</fieldset>
<!-- 	<fieldset>
		<span>
		<input type="button" name="bt_foto" id="bt_foto" value="Proses Data" style="font-size:12px;"/>
		</span>
	</fieldset> -->
</form>
</div >