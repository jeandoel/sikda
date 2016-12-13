<script>
$(document).ready(function(){
		$('#form1inspeksipasaradd').ajaxForm({
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
					$("#t463","#tabs").empty();
					$("#t463","#tabs").load('t_k_inspeksi_pasar'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1inspeksipasaradd").validate({
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
$("#tanggalinspeksipasar").mask("99/99/9999");

//$("#kabupaten_kotainspek_pasaradd").remoteChained("#provinsiinspek_pasaradd", "<?=site_url('t_masters/getKabupatenByProvinceId2')?>");
//$("#kecamataninspek_pasaradd").remoteChained("#kabupaten_kotainspek_pasaradd", "<?=site_url('t_masters/getKecamatanByKabupatenId2')?>");
//$("#kelurahaninspek_pasaradd").remoteChained("#kecamataninspek_pasaradd", "<?=site_url('t_masters/getKelurahanByKecamatanId2')?>");
</script>
<script>
	$('#backlistinspeksipasar').click(function(){
		$("#t463","#tabs").empty();
		$("#t463","#tabs").load('t_k_inspeksi_pasar'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Inspeksi Pasar</div>
<div class="backbutton"><span class="kembali" id="backlistinspeksipasar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1inspeksipasaradd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_k_inspeksi_pasar/addprocess')?>" enctype="multipart/form-data">	
	<!--<?=getComboProvinsi($this->session->userdata('kd_provinsi'),'provinsi','provinsiinspek_pasaradd','required','')?>
	<fieldset>
		<span>
		<label>Kab/Kota</label>
			<select name="kabupaten_kota" id="kabupaten_kotainspek_pasaradd" >
				<option value="">--</option>
			</select>
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<select name="kecamatan" id="kecamataninspek_pasaradd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>		
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahan" id="kelurahaninspek_pasaradd">
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
		<label>Nama Pasar*</label>
		<input type="text" name="nama_pasar" value=""  required />
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
		<label>Penanggung Jawab</label>
		<input type="text" name="pic" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Kios*</label>
		<input type="text" name="jumlah_kios" value="" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Jumlah Pedagang*</label>
		<input type="text" name="jumlah_pedagang" value="" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Jumlah Asosiasi*</label>
		<input type="text" name="jumlah_asosiasi" value="" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Team Pemeriksa*</label>
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
		<input type="text" name="tanggal_inspeksi" id="tanggalinspeksipasar" class="mydate" required  />		
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
		<a href="<?=base_url()?>tmp/InspeksiPasar.xls" style="color:blue">Klik di Sini Untuk Mengunduh Contoh File Inspeksi</a>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >