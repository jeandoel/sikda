<script>
$(document).ready(function(){
		$('#form1masterusersadd').ajaxForm({
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
					$("#t75","#tabs").empty();
					$("#t75","#tabs").load('c_master_users'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#kabupaten_kotat_pendaftaranadd").remoteChained("#provinsit_pendaftaranadd", "<?=site_url('t_masters/getKabupatenByProvinceId')?>");
		$("#kecamatant_pendaftaranadd").remoteChained("#kabupaten_kotat_pendaftaranadd", "<?=site_url('t_masters/getKecamatanByKabupatenId')?>");
		$("#kelurahant_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getKelurahanByKecamatanId')?>");
		$("#nama_puskesmas_hidden").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getPuskesmasByKecamatanId')?>");
		$("#getPustuByKecamatanId").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getPustuByKecamatanId')?>");
		$("#getPolindesByKecamatanId").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getPolindesByKecamatanId')?>");
		$("#getBidandesaByKecamatanId").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getBidandesaByKecamatanId')?>");
		$("#getPuslingByKecamatanId").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getPuslingByKecamatanId')?>");
		
		
		$('#master_user_group_hidden').focus(function(){
			$("#dialogcari_master_user_group_id").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 475,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_user_group_id').load('c_master_user_group/masterusergrouppopup?id_caller=form1masterusersadd', function() {
				$("#dialogcari_master_user_group_id").dialog("open");
			});
		});
		
		$('#showhide_level').on('change', function() {
		if($(this).val()=='KABUPATEN'){
			$('#provinsit_pendaftaranadd').show();
			$('#id_kabkota').show();
			$('#id_kecamatan').hide();
			$('#id_kelurahan').hide();
			$('#id_puskesmas').hide();
			$('#id_pustu').hide();
			$('#id_polindes').hide();
			$('#id_bidan_desa').hide();
			$('#id_pusling').hide();
		}else if($(this).val()=='PUSKESMAS'){
			$('#provinsit_pendaftaranadd').show();
			$('#id_kabkota').show();
			$('#id_kecamatan').show();
			$('#id_kelurahan').show();
			$('#id_puskesmas').show();
			$('#id_pustu').hide();
			$('#id_polindes').hide();
			$('#id_bidan_desa').hide();
			$('#id_pusling').hide();
		}else if($(this).val()=='PUSTU'){
			$('#provinsit_pendaftaranadd').show();
			$('#id_kabkota').show();
			$('#id_kecamatan').show();
			$('#id_kelurahan').show();
			$('#id_puskesmas').show();
			$('#id_pustu').show();
			$('#id_polindes').hide();
			$('#id_bidan_desa').hide();
			$('#id_pusling').hide();
		}else if($(this).val()=='POLINDES'){
			$('#provinsit_pendaftaranadd').show();
			$('#id_kabkota').show();
			$('#id_kecamatan').show();
			$('#id_kelurahan').show();
			$('#id_puskesmas').show();
			$('#id_pustu').hide();
			$('#id_polindes').show();
			$('#id_bidan_desa').hide();
			$('#id_pusling').hide();
			}else if($(this).val()=='BIDAN_DESA'){
			$('#provinsit_pendaftaranadd').show();
			$('#id_kabkota').show();
			$('#id_kecamatan').show();
			$('#id_kelurahan').show();
			$('#id_puskesmas').show();
			$('#id_pustu').hide();
			$('#id_polindes').hide();
			$('#id_bidan_desa').show();
			$('#id_pusling').hide();
			}else if($(this).val()=='PUSLING'){
			$('#provinsit_pendaftaranadd').show();
			$('#id_kabkota').show();
			$('#id_kecamatan').show();
			$('#id_kelurahan').show();
			$('#id_puskesmas').show();
			$('#id_pustu').hide();
			$('#id_polindes').hide();
			$('#id_bidan_desa').hide();
			$('#id_pusling').show();
			}else{
			$('#provinsit_pendaftaranadd').show();
			$('#id_kabkota').show();
			$('#id_kecamatan').hide();
			$('#id_kelurahan').hide();
			$('#id_puskesmas').hide();
			$('#id_pustu').hide();
			$('#id_polindes').hide();
			$('#id_bidan_desa').hide();
			$('#id_pusling').hide();
		}
	});

		
		
})
</script>
<script>
	$('#backlistmasterusers').click(function(){
		$("#t75","#tabs").empty();
		$("#t75","#tabs").load('c_master_users'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div id="dialogcari_master_user_group_id" title="Group Pengguna"></div>
<div id="dialog_cari_namapuskesmas" title="Puskesmas"></div>
<div class="formtitle">Tambah Pengguna</div>
<div class="backbutton"><span class="kembali" id="backlistmasterusers">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterusersadd" onsubmit="bt1.disabled = true; return true;" method="post" action="<?=site_url('c_master_users/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KD USER</label>
		<input type="text" name="kduser" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Level</label>
			<select name="showhide_level" id="showhide_level">
				<option value="" selected >--Pilih Level--</option>
				<?php if($this->session->userdata('group_id')=='kabupaten'){?>
					<option value="KABUPATEN">KABUPATEN</option>
				<?php }?>
				<option value="PUSKESMAS">PUSKESMAS</option>
				<option value="PUSTU">PUSTU</option>
				<option value="POLINDES">POLINDES</option>
				<option value="BIDAN_DESA">BIDAN DESA</option>
				<option value="PUSLING">PUSLING</option>
			</select>
		</span>
	</fieldset>
	<?=getComboProvinsi(/*$this->session->userdata('kd_provinsi')*/'','provinsi','provinsit_pendaftaranadd','required','')?>
	<fieldset id="id_kabkota">
	<span>
	<label>Kab/Kota</label>
		<select name="kabupaten" id="kabupaten_kotat_pendaftaranadd">
			<option value="">--</option>
		</select>
	</span>
	</fieldset>
	<fieldset  id="id_kecamatan">
		<span>
		<label>Kecamatan</label>
			<select name="kecamatan" id="kecamatant_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset id="id_kelurahan">
		<span>
		<label>Desa/Kelurahan</label>
			<select name="desa_kelurahan" id="kelurahant_pendaftaranadd">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset id="id_puskesmas">
		<span>
		<label>Puskesmas</label>
			<select name="nama_puskesmas" id="nama_puskesmas_hidden">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset id="id_pustu">
		<span>
		<label>KD PUSTU</label>
			<select name="pustu" id="getPustuByKecamatanId" >
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset id="id_polindes">
		<span>
		<label>KD POLINDES</label>
			<select name="polindes" id="getPolindesByKecamatanId">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset id="id_bidan_desa">
		<span>
		<label>KD BIDAN DESA</label>
			<select name="bidan_desa" id="getBidandesaByKecamatanId">
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset id="id_pusling">
		<span>
		<label>KD PUSLING</label>
			<select name="pusling" id="getPuslingByKecamatanId" >
				<option value="">--</option>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>GROUP ID</label>
		<input type="text" name="idgroup" id="master_user_group_hidden" value=""   />
		<input type="text" placeholder="Group Name" name="master_user_group" id="master_user_group"  value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>USER NAME</label>
		<input type="text" name="username" placeholder="Login Username" id="text2" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>FULL NAME</label>
		<input type="text" name="fullname" id="text3" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PASSWORD</label>
		<input type="text" name="userpassword" id="text5" placeholder="Login Password" value="" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>EMAIL</label>
		<input type="text" name="email" id="text4" value="" />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >