<script>
$(document).ready(function(){
		$('#formgigimastergigiadd').ajaxForm({
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
					$("#t1001","#tabs").empty();
					$("#t1001","#tabs").load('c_master_gigi'+'?_=' + (new Date()).getTime());
				}
			}
		});
		$("#formgigimastergigiadd").validate({
		rules: {
			kd_gigi: {
				number:true,
				required: true
			}
		},
		messages: {
			kd_gigi: {
				number: "field harus diisi dengan angka",
				required:"Silahkan Lengkapi Data"
			}
		}
	});
})
</script>
<script>
	$('#backlistmastergigi').click(function(){
		$("#t1001","#tabs").empty();
		$("#t1001","#tabs").load('c_master_gigi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Nomenklatur</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formgigimastergigiadd" method="post" action="<?=site_url('c_master_gigi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nomenklatur</label>
		<input type="text" name="kd_gigi" id="kd_gigi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" name="nama" id="nama" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Gambar</label>
		<input type="file" name="gambar"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >