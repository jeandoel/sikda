<script>
$(document).ready(function(){
		$('#form1posyanduadd').ajaxForm({
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
					$("#t472","#tabs").empty();
					$("#t472","#tabs").load('t_posyandu'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1posyanduadd").validate({
			rules: {
				tanggal_inspeksi: {
					date:true,
					required: true
				}
			},
			messages: {
				tanggal_inspeksi: {
					required:"Silahkan Lengkapi Data"
				}
			}
		});
})

//$("#kabupaten_kotarmh_sehatadd").remoteChained("#provinsirmh_sehatadd", "<?=site_url('t_masters/getKabupatenByProvinceId2')?>");
//$("#kecamatanrmh_sehatadd").remoteChained("#kabupaten_kotarmh_sehatadd", "<?=site_url('t_masters/getKecamatanByKabupatenId2')?>");
//$("#kelurahanrmh_sehatadd").remoteChained("#kecamatanrmh_sehatadd", "<?=site_url('t_masters/getKelurahanByKecamatanId2')?>");
//$("#desa_kel_id_combo").remoteChained("#kec_id_combo", "<?=site_url('t_masters/getKelurahanByKecamatanId2')?>");
</script>
<script>
	$('#backlistposyandu').click(function(){
		$("#t472","#tabs").empty();
		$("#t472","#tabs").load('t_posyandu'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistposyandu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1posyanduadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_posyandu/addprocess')?>" enctype="multipart/form-data">	
	<!--<?=getComboProvinsi($this->session->userdata('kd_provinsi'),'provinsi','provinsirmh_sehatadd','required','')?>
	<fieldset>
		<span>
		<label>Kab/Kota</label>
			<select name="kabupaten_kota" id="kabupaten_kotarmh_sehatadd" >
				<option value="">--</option>
			</select>
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<select name="kecamatan" id="kecamatanrmh_sehatadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>		
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahan" id="kelurahanrmh_sehatadd">
				<option value="">--</option>
			</select>			
		</span>
	</fieldset>	-->
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text"  name="" id="textid" value="<?=$this->session->userdata('nama_propinsi')?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text"  name="" id="textid" value="<?=$this->session->userdata('nama_kabupaten')?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
		<input type="text"  name="" id="textid" value="<?=$this->session->userdata('nama_kecamatan')?>" disabled />
		</span>
	</fieldset>
	<!--<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'kecamatan','kec_id_combo','required','')?>-->
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'desa_kelurahan','desa_kel_id_combo','required','')?>
	<fieldset>
		<span>
		<label>Nama Posyandu*</label>
		<input type="text" name="nama_posyandu" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RW</label>
		<input type="text" name="rw" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RT</label>
		<input type="text" name="rt" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat*</label>
		<input type="text" name="alamat" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Kader*</label>
		<input type="text" name="jumlah_kader" value="" required />
		</span>
	</fieldset>	
	<fieldset>	
	<span>
		<label>Jenis Posyandu*</label>
		<select name="jenis_posyandu" required>
			<option value="">Pilih Jenis Posyandu</option>
			<option value="PRATAMA" >PRATAMA</option>
			<option value="MADYA" >MADYA</option>
			<option value="PURNAMA" >PURNAMA</option>
		</select>
	</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >