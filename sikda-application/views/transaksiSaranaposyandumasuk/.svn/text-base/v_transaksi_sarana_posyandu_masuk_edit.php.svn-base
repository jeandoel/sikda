<script>
$(document).ready(function(){
		$('#form1transaksisaranaposyandumasukedit').ajaxForm({
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
					$("#t4","#tabs").empty();
					$("#t4","#tabs").load('c_transaksi_sarana_posyandu_masuk'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#form1transaksisaranaposyandumasukedit  #cari_namapuskesmas').click(function(){
			$("#dialogtransaksisaranaposyandumasuk_cari_namapuskesmas").dialog({
				autoOpen: false,
				modal:true,
				width: 600,
				height: 355,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialogtransaksisaranaposyandumasuk_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1transaksisaranaposyandumasukedit', function() {
				$("#dialogtransaksisaranaposyandumasuk_cari_namapuskesmas").dialog("open");
			});
		});
		
		$('#form1transaksisaranaposyandumasukedit  #cari_namasaranaposyandu').click(function(){
			$("#dialogtransaksisaranaposyandumasuk_cari_namasaranaposyandu").dialog({
				autoOpen: false,
				modal:true,
				width: 600,
				height: 355,
				buttons : {
					"Cancel" : function() {
					  $(this).dialog("close");
					}
				}
			});
			
			$('#dialogtransaksisaranaposyandumasuk_cari_namasaranaposyandu').load('c_master_sarana_posyandu/saranaposyandupopup?id_caller=form1transaksisaranaposyandumasukedit', function() {
				$("#dialogtransaksisaranaposyandumasuk_cari_namasaranaposyandu").dialog("open");
			});
		});
		
})
</script>
<script>
	$('#backlisttransaksisaranaposyandumasuk').click(function(){
		$("#t4","#tabs").empty();
		$("#t4","#tabs").load('c_transaksi_sarana_posyandu_masuk'+'?_=' + (new Date()).getTime());
	})
	$('#tgltransaksi').datepicker({dateFormat: "yy-mm-dd",changeYear: true,yearRange: "-100:+0"});
</script>
<div class="mycontent">
<div id="dialogtransaksisaranaposyandumasuk_cari_namapuskesmas" title="Master Puskesmas"></div>
<div id="dialogtransaksisaranaposyandumasuk_cari_namasaranaposyandu" title="Master Sarana Posyandu"></div>
<div class="formtitle">Edit Transaksi Sarana Posyandu masuk</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksisaranaposyandumasuk">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksisaranaposyandumasukedit" method="post" action="<?=site_url('c_transaksi_sarana_posyandu_masuk/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Asal Sarana Posyandu</label>
		<input type="text" name="asalsaranaposyandu" id="text1" value="<?=$data->nasal_sarana_posyandu?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_sarana_posyandu_masuk?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tujuan Sarana</label>
		<input type="text" name="nama_puskesmas" id="nama_puskesmas" value="<?=$data->nnamapuskesmas?>" readonly  />
		<input type="hidden" name="idpuskesmas" id="nama_puskesmas_hidden" value="<?=$data->nid_puskesmas?>"  />
		<input type="button" id="cari_namapuskesmas" value="..." >
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Id Pegawai</label>
		<input type="text" name="idpegawai" id="text2" value="<?=$data->nid_pegawai?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Sarana Posyandu</label>
		<input type="text" name="nama_sarana_posyandu" id="nama_sarana_posyandu" value="<?=$data->nnamasaranaposyandu?>" readonly  />
		<input type="hidden" name="idsaranaposyandu" id="nama_sarana_posyandu_hidden" value="<?=$data->nid_sarana_posyandu?>"  />
		<input type="button" id="cari_namasaranaposyandu" value="..." >
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan Sarana</label>
		<textarea name="keterangansarana" rows="3" cols="45"><?=$data->nketerangan_sarana?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Transaksi</label>
		<input type="text" name="kodetransaksi" id="text4" value="<?=$data->nkode_transaksi?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Transaksi</label>
		<input type="text" name="tgltransaksi" id="tgltransaksi" value="<?=$data->ntgl_transaksi?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Sarana</label>
		<input type="text" name="jumlahsarana" id="text5" value="<?=$data->njumlah_sarana?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >