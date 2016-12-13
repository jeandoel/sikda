<script>
$(document).ready(function(){
		$('#form1rumahsehatadd').ajaxForm({
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
					$("#t461","#tabs").empty();
					$("#t461","#tabs").load('t_k_rumah_sehat'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1rumahsehatadd").validate({
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
$("#tanggalrumahsehat").mask("99/99/9999");

//$("#kabupaten_kotarmh_sehatadd").remoteChained("#provinsirmh_sehatadd", "<?=site_url('t_masters/getKabupatenByProvinceId2')?>");
//$("#kecamatanrmh_sehatadd").remoteChained("#kabupaten_kotarmh_sehatadd", "<?=site_url('t_masters/getKecamatanByKabupatenId2')?>");
//$("#kelurahanrmh_sehatadd").remoteChained("#kecamatanrmh_sehatadd", "<?=site_url('t_masters/getKelurahanByKecamatanId2')?>");
</script>
<script>
	$('#backlistrumahsehat').click(function(){
		$("#t461","#tabs").empty();
		$("#t461","#tabs").load('t_k_rumah_sehat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Inspeksi Rumah Sehat</div>
<div class="backbutton"><span class="kembali" id="backlistrumahsehat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1rumahsehatadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_k_rumah_sehat/addprocess')?>" enctype="multipart/form-data">	
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
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'desa_kelurahan','','required','')?>
	<fieldset>
		<span>
		<label>RW*</label>
		<input type="text" name="rw" value="" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RT*</label>
		<input type="text" name="rt" value="" required  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama KK*</label>
		<input type="text" name="nama_kk" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Jiwa*</label>
		<input type="text" name="jumlah_jiwa" value="" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Pemeriksa*</label>
		<input type="text" name="pemeriksa" value="" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Total Nilai Pemeriksaan*</label>
		<input type="text" name="total_nilai" value="" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Inspeksi* (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_inspeksi" id="tanggalrumahsehat" class="mydate" required  />		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Dokumen Pemeriksaan*</label>
		<input type="file" name="filedok" value="" />		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>&nbsp;</label>
		<a href="<?=base_url()?>tmp/RumahSehat.xls" style="color:blue">Klik di Sini Untuk Mengunduh Contoh File Inspeksi</a>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >