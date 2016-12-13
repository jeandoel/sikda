<script>
$(document).ready(function(){
		$('#form1rmrestoranadd').ajaxForm({
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
					$("#t462","#tabs").empty();
					$("#t462","#tabs").load('t_k_rm_restoran'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1rmrestoranadd").validate({
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
$("#tanggalrmrestoran").mask("99/99/9999");

//$("#kabupaten_kotarmrstradd").remoteChained("#provinsirmrstradd", "<?=site_url('t_masters/getKabupatenByProvinceId2')?>");
//$("#kecamatanrmrstradd").remoteChained("#kabupaten_kotarmrstradd", "<?=site_url('t_masters/getKecamatanByKabupatenId2')?>");
//$("#kelurahanrmrstradd").remoteChained("#kecamatanrmrstradd", "<?=site_url('t_masters/getKelurahanByKecamatanId2')?>");
</script>
<script>
	$('#backlistrmrestoran').click(function(){
		$("#t462","#tabs").empty();
		$("#t462","#tabs").load('t_k_rm_restoran'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Inspeksi RM dan Restoran</div>
<div class="backbutton"><span class="kembali" id="backlistrmrestoran">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1rmrestoranadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('t_k_rm_restoran/addprocess')?>" enctype="multipart/form-data">	
	<!--<?=getComboProvinsi($this->session->userdata('kd_provinsi'),'provinsi','provinsirmrstradd','required','')?>
	<fieldset>
		<span>
		<label>Kab/Kota</label>
			<select name="kabupaten_kota" id="kabupaten_kotarmrstradd" >
				<option value="">--</option>
			</select>
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Kecamatan</label>
			<select name="kecamatan" id="kecamatanrmrstradd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>		
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahan" id="kelurahanrmrstradd">
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
		<label>Nama RM/Restoran*</label>
		<input type="text" name="nama_rm" value=""  required />
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
		<label>Jumlah Karyawan*</label>
		<input type="text" name="jumlah_kry" value="" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Jumlah Penjamah*</label>
		<input type="text" name="jumlah_pjmh" value="" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>No. Ijin Usaha</label>
		<input type="text" name="no_ijin" value="" />
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
		<input type="text" name="tanggal_inspeksi" id="tanggalrmrestoran" class="mydate" required  />		
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
		<a href="<?=base_url()?>tmp/SanitasiRMdanRestoran.xls" style="color:blue">Klik di Sini Untuk Mengunduh Contoh File Inspeksi</a>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >