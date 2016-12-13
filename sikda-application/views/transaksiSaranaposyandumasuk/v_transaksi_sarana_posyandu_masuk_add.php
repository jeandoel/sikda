<script>
jQuery().ready(function (){ 
		$('#form1transaksisaranaposyandumasukadd').ajaxForm({
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
					$("#t4","#tabs").empty();
					$("#t4","#tabs").load('c_transaksi_sarana_posyandu_masuk'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$('#cari_namapuskesmas').click(function(){
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
			
			$('#dialogtransaksisaranaposyandumasuk_cari_namapuskesmas').load('c_master_puskesmas/puskesmaspopup?id_caller=form1transaksisaranaposyandumasukadd', function() {
				$("#dialogtransaksisaranaposyandumasuk_cari_namapuskesmas").dialog("open");
			});
		});
		
		$('#cari_namasaranaposyandu').click(function(){
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
			
			$('#dialogtransaksisaranaposyandumasuk_cari_namasaranaposyandu').load('c_master_sarana_posyandu/saranaposyandupopup?id_caller=form1transaksisaranaposyandumasukadd', function() {
				$("#dialogtransaksisaranaposyandumasuk_cari_namasaranaposyandu").dialog("open");
			});
		});
		
})

$('#tgltransaksi').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlisttransaksisaranaposyandumasuk').click(function(){
		$("#t4","#tabs").empty();
		$("#t4","#tabs").load('c_transaksi_sarana_posyandu_masuk'+'?_=' + (new Date()).getTime());
	})
</script>
<div id="dialogtransaksisaranaposyandumasuk_cari_namapuskesmas" title="Master Puskesmas"></div>
<div id="dialogtransaksisaranaposyandumasuk_cari_namasaranaposyandu" title="Master Sarana Posyandu"></div>
<div class="mycontent">
<div class="formtitle">Tambah Transaksi Sarana Posyandu Masuk</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksisaranaposyandumasuk">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksisaranaposyandumasukadd" method="post" action="<?=site_url('c_transaksi_sarana_posyandu_masuk/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Asal Sarana Posyandu</label>
		<input type="text" name="asalsaranaposyandu" id="asalsaranaposyanduadd" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tujuan Sarana</label>
		<input type="text" name="nama_puskesmas" id="nama_puskesmas" value="" readonly  />
		<input type="hidden" name="idpuskesmas" id="nama_puskesmas_hidden" value=""  />
		<input type="button" id="cari_namapuskesmas" value="..." >
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Id Pegawai</label>
		<input type="text" name="idpegawai" id="idpegawaiadd" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Sarana Posyandu</label>
		<input type="text" name="nama_sarana_posyandu" id="nama_sarana_posyandu" value="" readonly  />
		<input type="hidden" name="idsaranaposyandu" id="nama_sarana_posyandu_hidden" value=""  />
		<input type="button" id="cari_namasaranaposyandu" value="..." >
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan Sarana</label>
		<textarea name="keterangansarana" rows="3" cols="45"></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Transaksi</label>
		<input type="text" name="kodetransaksi" id="kodetransaksiadd" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Transaksi</label>
		<input type="text" name="tgltransaksi" id="tgltransaksi" value="<?=date('Y-m-d')?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Sarana</label>
		<input type="text" name="jumlahsarana" id="jumlahsaranaadd" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >