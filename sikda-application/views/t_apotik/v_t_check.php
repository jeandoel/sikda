<script>
$(document).ready(function(){
	$('#formkomentar').ajaxForm({
		beforeSend: function() {
			achtungShowLoader();	
		},
		uploadProgress: function(event, position, total, percentComplete) {
		},
		complete: function(xhr) {
			achtungHideLoader();
			var id1 = '<?=$data->KD_PELAYANAN?>'
			var id2 = '<?=$data->KD_PASIEN?>'
			var id3 = '<?=$data->KD_PUSKESMAS?>'
			if(xhr.responseText!=='OK'){
				$.achtung({message: 'Proses Kirim Pesan Berhasil', timeout:5});
				$("#dialogcari_apotikkomentar").dialog("close");
			}
			$.ajax({
					  url: 't_apotik/check',
					  type: "post",
					  data: {id1:id1,id2:id2,id3:id3},
					  dataType: "json",
					  success: function(msg){
						if(msg == 'OK'){
							$.achtung({message: 'Proses Permohonan Check Data Berhasil', timeout:2});
							$("#listt_apotik").trigger("reloadGrid");
						}
						else{						
							$.achtung({message: 'Maaf Proses Permohonan Check Data Gagal', timeout:2});
						}						
					  }
			});
		}
	})
});
</script>	
<form name="frApps" id="formkomentar" method="post" action="<?=site_url('t_apotik/checkkomentar1')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
			<label>Pesan Check</label>
			<textarea name="komentar" id="komentar_id" style="width:400px;height:200px"></textarea>
			<input type="hidden" name="kd_pelayanan" id="textid" value="<?=$data->KD_PELAYANAN?>" />
			<input type="hidden" name="kd_pasien" id="textid2" value="<?=$data->KD_PASIEN?>" />
			<input type="hidden" name="kd_puskesmas" id="textid3" value="<?=$data->KD_PUSKESMAS?>" />
			</span>
		<br/>
		<span>
			<label style="width:217px"></label>
			<input type="submit" name="bt1" value="Kirim"/>
		</span>
	</fieldset>
</form>