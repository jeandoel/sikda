<script>
$(document).ready(function(){
		$('#form1sysSettingdefedit').ajaxForm({
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
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t30","#tabs").empty();
					$("#t30","#tabs").load('c_sys_setting_def'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#master_propinsi_id_hidden').focus(function(){
			$("#dialogcari_master_propinsi_id").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_propinsi_id').load('c_master_propinsi/masterpropinsipopup?id_caller=form1sysSettingdefedit', function() {
				$("#dialogcari_master_propinsi_id").dialog("open");
			});
		});
		
		$('#master_kabupaten_id_hidden').focus(function(){
			$("#dialogcari_master_kabupaten_id").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_kabupaten_id').load('c_master_kabupaten/masterkabupatenpopup?id_caller=form1sysSettingdefedit', function() {
				$("#dialogcari_master_kabupaten_id").dialog("open");
			});
		});
		
		$('#master_kecamatan_id_hidden').focus(function(){
			$("#dialogcari_master_kecamatan_id").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_kecamatan_id').load('c_master_kecamatan/masterkecamatanpopup?id_caller=form1sysSettingdefedit', function() {
				$("#dialogcari_master_kecamatan_id").dialog("open");
			});
		});
		
		$('#nama_puskesmas_hidden').focus(function(){
			$("#dialog_cari_namapuskesmas").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialog_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1sysSettingdefedit', function() {
				$("#dialog_cari_namapuskesmas").dialog("open");
			});
		});
		
		$('#master_dokter_id').focus(function(){
			$("#dialogcari_master_dokter_id").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogcari_master_dokter_id').load('c_master_dokter/masterdokterpopup?id_caller=form1sysSettingdefedit', function() {
				$("#dialogcari_master_dokter_id").dialog("open");
			});
		});
		
		$('#nama_ras').focus(function(){
			$("#dialogtransaksi_cari_namaras").dialog({
				autoOpen: false,
				modal:true,
				width: 500,
				height: 405,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			$('#dialogtransaksi_cari_namaras').load('c_master_ras/masterraspopup?id_caller=form1sysSettingdefedit', function() {
				$("#dialogtransaksi_cari_namaras").dialog("open");
			});
		});
})
</script>
<script>
	$('#backlistsysSettingdef').click(function(){
		$("#t30","#tabs").empty();
		$("#t30","#tabs").load('c_sys_setting_def'+'?_=' + (new Date()).getTime());
	})
	$("#idjenispasien").change(function(){
                var idjenispasien = {idjenispasien:$("#idjenispasien").val()};
                $.ajax({
                        type: "POST",
                        url : "<?php echo site_url('c_sys_setting_def/changeCombo')?>",
                        data: idjenispasien,
						
						success: function(result){
							
							$('#idcarabayar').html(result);
						}
						
                }); 
    });
	$('#level_setting').on("change",function(){
		if($(this).val()==""){
			$('#nonkabupaten').hide();
			$('#kepalapuskesmas').hide();
		}else if($(this).val()=="KABUPATEN"){
			$('#nonkabupaten').hide();
		}else if($(this).val()=="PUSKESMAS"){
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').show();
			$('#nama_nama').hide();
		}else if($(this).val()=="PUSTU"){
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').hide();
			$('#nama_nama').show();
			$('#pustu').show();
			$('#pusling').hide();
			$('#bidan').hide();
			$('#polindes').hide();
		}else if($(this).val()=="PUSLIN"){
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').hide();
			$('#nama_nama').show();
			$('#pusling').show();
			$('#pustu').hide();
			$('#bidan').hide();
			$('#polindes').hide();
		}else if($(this).val()=="BIDAN"){
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').hide();
			$('#nama_nama').show();
			$('#bidan').show();
			$('#pusling').hide();
			$('#pustu').hide();
			$('#polindes').hide();
		}else{
			$('#nonkabupaten').show();
			$('#kepalapuskesmas').hide();
			$('#nama_nama').show();
			$('#polindes').show();
			$('#pusling').hide();
			$('#bidan').hide();
			$('#pustu').hide();
		}
	})
</script>
<div id="dialogcari_master_propinsi_id" title="Provinsi"></div>
<div id="dialogcari_master_kabupaten_id" title="Kabupaten"></div>
<div id="dialogcari_master_kecamatan_id" title="Kecamatan"></div>
<div id="dialog_cari_namapuskesmas" title="Puskesmas"></div>
<div id="dialogtransaksi_cari_namaras" title="Ras"></div>
<div id="dialogcari_master_dokter_id" title="Dokter"></div>
<div class="mycontent">
<div class="formtitle">Edit Setting Profil Aplikasi</div>
<div class="backbutton"><span class="kembali" id="backlistsysSettingdef">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1sysSettingdefedit" method="post" action="<?=site_url('c_sys_setting_def/editprocess')?>" enctype="multipart/form-data">
	<?=getComboLevel1($data->LEVEL,'level','level_setting','required','')?>
	<fieldset>
		<span>
		<label>Kode Provinsi</label>
		<input type="text" name="kd_prov" readonly id="master_propinsi_id_hidden" value="<?=$data->KD_PROV?>" />
		<input type="text" placeholder="Provinsi" readonly name="provinsi" id="master_propinsi_id" value="<?=$data->PROVINSI?>" />
		<input type="hidden"readonly name="id" id="idtext" value="<?=$data->KD_SETTING?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kabupaten/Kota</label>
		<input type="text" name="kd_kabkota" readonly id="master_kabupaten_id_hidden" value="<?=$data->KD_KABKOTA?>" />
		<input type="text" placeholder="Kabupaten/Kota" readonly name="kabukota" id="master_kabupaten_id" value="<?=$data->KABUPATEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="kd_kec" readonly id="master_kecamatan_id_hidden" value="<?=$data->KD_KEC?>" />
		<input type="text" placeholder="Kecamatan" readonly name="kecamatan" id="master_kecamatan_id" value="<?=$data->KECAMATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" readonly name="kd_puskesmas" readonly id="nama_puskesmas_hidden" value="<?=$data->KD_PUSKESMAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Puskesmas</label>
		<input type="text" readonly name="nama_puskesmas" readonly id="nama_puskesmas" value="<?=$data->NAMA_PUSKESMAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<input type="textarea" readonly name="alamat" readonly id="nama_puskesmas_alamat" value="<?=$data->ALAMAT?>" style="width:410px" />
		</span>
	</fieldset>
	<div id="nama_nama">
	<fieldset id="pustu" style="display:none">
		<span>
		<label>Nama Pustu</label>
		<input type="text" name="nama_pustu"  id="nama_pustu_id" value="" />
		</span>
	</fieldset>
	<fieldset id="polindes" style="display:none">
		<span>
		<label>Nama Polindes</label>
		<input type="text" name="nama_polindes"  id="nama_polindes_id" value="" />
		</span>
	</fieldset>
	<fieldset id="pusling" style="display:none">
		<span>
		<label>Nama Pusling</label>
		<input type="text" name="nama_pusling"  id="nama_pusling_id" value="" />
		</span>
	</fieldset>
	<fieldset id="bidan" style="display:none">
		<span>
		<label>Nama Bidan</label>
		<input type="text" name="nama_bidan"  id="nama_bidan_id" value="" />
		</span>
	</fieldset>
	</div>	
	<div id="kepalapuskesmas">
	<fieldset>
		<span>
		<label>Nama Kepala Puskesmas</label>
		<input type="text" readonly name="nama_pimpinan" readonly id="master_dokter_id" value="<?=$data->NAMA_PIMPINAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NIP</label>
		<input type="text" readonly name="nip" readonly id="master_dokter_id_nip" value="<?=$data->NIP?>" />
		</span>
	</fieldset>
	</div>
	<!--
	<fieldset>
		<span>
		<label>Agama</label>
		<select name="agama" id="text3" style="width:203px">
			<option value="">Pilih</option>
			<?php foreach($agama as $key=>$a):?>
			<option value="<?=$a['KD_AGAMA']?>" <?=$a['KD_AGAMA']==$data->AGAMA?'selected':''?>><?=$a['AGAMA']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<select name="jenis_pasien" id="idjenispasien" style="width:203px">
			<option value="">Pilih</option>
			<?php foreach($jenispasien as $key=>$c):?>
			<option value="<?=$c['KD_CUSTOMER']?>" <?=$data->JENIS_PASIEN==$c['KD_CUSTOMER']?'selected':''?>><?=$c['CUSTOMER']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Cara Bayar</label>
		<div id="field_carabayar">
		<select data-placeholder="Pilih" name="cara_bayar" id="idcarabayar" style="width:203px">
			<?php foreach($bayar as $key=>$d):?>
			<option value="<?=$d['KD_BAYAR']?>" <?=$data->CARA_BAYAR==$d['KD_BAYAR']?'selected':''?>><?=$d['CARA_BAYAR']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Marital</label>
		<select data-placeholder="Pilih" name="marital" id="text7" style="width:203px">
			<option value="">Pilih</option>
			<?php foreach($marital as $key=>$e):?>
			<option value="<?=$e['KD_STATUS']?>" <?=$data->MARITAL==$e['KD_STATUS']?'selected':''?>><?=$e['STATUS']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pekerjaan</label>
		<select data-placeholder="Pilih" name="pekerjaan" id="text8" style="width:203px">
			<option value="">Pilih</option>
			<?php foreach($pekerjaan as $key=>$f):?>
			<option value="<?=$f['KD_PEKERJAAN']?>" <?=$data->PEKERJAAN==$f['KD_PEKERJAAN']?'selected':''?>><?=$f['PEKERJAAN']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pendidikan</label>
		<select data-placeholder="Pilih" name="pendidikan" id="text9" style="width:203px">
			<option value="">Pilih</option>
			<?php foreach($pendidikan as $key=>$g):?>
			<option value="<?=$g['KD_PENDIDIKAN']?>" <?=$data->PENDIDIKAN==$g['KD_PENDIDIKAN']?'selected':''?>><?=$g['PENDIDIKAN']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Poli</label>
		<select data-placeholder="Pilih" name="poli" id="text10" style="width:203px">
			<option value="">Pilih</option>
			<?php foreach($poli as $key=>$i):?>
			<option value="<?=$i['KD_UNIT']?>" <?=$data->POLI==$i['KD_UNIT']?'selected':''?>><?=$i['UNIT']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Gender</label>
		<input type="radio" name="gender" id="gender1" value="L" <?=$data->GENDER=='L'?'checked':''?> />Laki-laki</radio>
		<input type="radio" name="gender" id="gender2" value="P" <?=$data->GENDER=='P'?'checked':''?> />Perempuan</radio>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Suku</label>
		<input type="text" readonly name="ras" readonly id="nama_ras" value="<?=$data->RAS?>" />
		<input type="hidden" readonly name="suku" readonly id="nama_ras1" value="<?=$data->SUKU?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Unit Pelayanan</label>
		<select data-placeholder="Pilih" name="unit_pelayanan" id="text12" style="width:203px">
			<option value="">Pilih</option>
			<?php foreach($unitpelayanan as $key=>$h):?>
			<option value="<?=$h['KD_UNIT_LAYANAN']?>" <?=$h['KD_UNIT_LAYANAN']==$data->UNIT_PELAYANAN?'selected':''?>><?=$h['KD_UNIT_LAYANAN']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	-->
	<fieldset>
		<span>
		<label>Server Kementrian Kesehatan</label>
		<input type="text" name="server_kemkes" id="text13" value="<?=$data->SERVER_KEMKES?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Server Dinas Kesehatan Provinsi</label>
		<input type="text" name="server_dinkes_prov" id="text14" value="<?=$data->SERVER_DINKES_PROV?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Server Dinas Kesehatan Kabupaten/Kota</label>
		<input type="text" name="server_dinkes_kabkota" id="text15" value="<?=$data->SERVER_DINKES_KAB_KOTA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >
