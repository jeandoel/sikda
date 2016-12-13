<script>
jQuery().ready(function (){ 
	$('#dari_ctksk').datepicker({dateFormat:'dd-mm-yy'});
	$('#sampai_ctksk').datepicker({dateFormat:'dd-mm-yy'});
	
	$('input:radio[name="keterangan"]').change(function(){
		if($(this).is(':checked') && $(this).val() == 'sakit'){
			$('#sakit').show();
		}else{
			$('#sakit').hide();
		}
	});
    
	$('#submitter').live('click',function(){
		var nomor_surat = $('#nomor_surat').val(),
			keterangan = $('input:radio[name="keterangan"]:checked').val(),
			kd_pasien = $('#kd_pasien').val(),
			berat = $('#berat_badan').val(),
			tinggi = $('#tinggi_badan').val(),
			tensi = $('#tensi').val(),
			perdetik = $('#perdetik').val(),
			buwar = $('input:radio[name="buwar"]:checked').val(),
			guna = $('#guna').val(),
			dari = $('#dari_ctksk').val(),
			sampai = $('#sampai_ctksk').val(),
			dokter = $('#dokter option:selected').text();
			
		if(keterangan =='sakit' || keterangan =='sehat'){
			if(keterangan =='sehat'){
				NewWin = window.open('surat_keterangan/cetak_sk?kd_pasien='+decodeURIComponent(kd_pasien)+'&nomor_surat='+decodeURIComponent(nomor_surat)+'&berat='+decodeURIComponent(berat)+'&tinggi='+decodeURIComponent(tinggi)+'&tensi='+decodeURIComponent(tensi)+'&perdetik='+decodeURIComponent(perdetik)+'&buwar='+decodeURIComponent(buwar)+'&guna='+decodeURIComponent(guna)+'&dokter='+decodeURIComponent(dokter));
				$('#dialogt_pelayanancetaksk').dialog('close');
				location.reload();
			}else{
				NewWin = window.open('surat_keterangan/cetak_sk_sakit?kd_pasien='+decodeURIComponent(kd_pasien)+'&nomor_surat='+decodeURIComponent(nomor_surat)+'&berat='+decodeURIComponent(berat)+'&tinggi='+decodeURIComponent(tinggi)+'&tensi='+decodeURIComponent(tensi)+'&perdetik='+decodeURIComponent(perdetik)+'&buwar='+decodeURIComponent(buwar)+'&guna='+decodeURIComponent(guna)+'&dari='+decodeURIComponent(dari)+'&sampai='+decodeURIComponent(sampai)+'&dokter='+decodeURIComponent(dokter));
				$('#dialogt_pelayanancetaksk').dialog('close');
				location.reload();
			}
		}else{
			alert('Pilih Keterangan untuk mencetak!');
		}
	});
})
</script>

<div class="mycontent">
	<form id="formcetaksurat">
	<fieldset>
		<span>
		<label>Nomor Surat</label>
		</span>
		<span>
		<input type="text" name="nomor_surat" id="nomor_surat" value=""/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan</label>
		</span>
		<span>
		<input type="radio" name="keterangan" class="keterangan" value="sakit"/>SAKIT
		<input type="radio" name="keterangan" class="keterangan" value="sehat"/>SEHAT
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		</span>
		<span>
		<input type="text" name="nama_pasien" id="nama_pasien" value="<?=$data->NAMA_LENGKAP?>"/>
		<input type="hidden" name="kd_pasien" id="kd_pasien" value="<?=$data->KD_PASIEN?>"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan</label>
		</span>
		<span>
		<input type="text" name="berat_badan" id="berat_badan" class="mydate" value=""/> Kg
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tinggi Badan</label>
		</span>
		<span>
		<input type="text" name="tinggi_badan" id="tinggi_badan" class="mydate" value=""/> Cm
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tensi Darah</label>
		</span>
		<span>
		<input type="text" name="tensi" id="tensi" class="mydate" value=""/>/
		<input type="text" name="perdetik" id="perdetik" class="mydate" value=""/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Buta Warna</label>
		</span>
		<span>
		<input type="radio" name="buwar" class="buwar" value="ya"/>Ya
		<input type="radio" name="buwar" class="buwar" checked value="tidak"/>Tidak
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keperluan</label>
		</span>
		<span>
		<textarea name="guna" id="guna" style="width:194px"></textarea>
		</span>
	</fieldset>
	<fieldset id="sakit">
		<span>
		<label>Dari - Sampai</label>
		</span>
		<span>
		<input type="text" name="dari" readonly id="dari_ctksk" class="mydate" value="<?=date('d-m-Y')?>"/> - &nbsp;
		<input type="text" name="sampai" readonly id="sampai_ctksk" class="mydate" value=""/>
		</span>
	</fieldset>
	
	<?=getComboDokterdanPetugas20('','petugas2','dokter','','')?>
	<br/>
	<input type="button" id="submitter" value="Cetak" style="float:right"/>
	<br/>
	</form>
</div>