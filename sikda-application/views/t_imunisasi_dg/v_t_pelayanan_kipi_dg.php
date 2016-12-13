<script>
	$("form").validate({
		rules: {
			tgl_imunisasi: {
				date:true,
				required: true
			}
		},
		messages: {
			tgl_imunisasi: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Data"
			}
		}
	});

	$("form").validate({focusInvalid:true});
	
	$(':submit').click(function(e) {
		e.preventDefault();
		if($("form").valid()) {
			if(kumpularray())$('form').submit();
		}
		return false;
	});

	$("#jenis_vaksin").focus();

	$("#tgl_imunisasi").mask("99/99/9999");
</script>
	
	<fieldset>
		<span>
		<label>Jenis Vaksin</label>
		<input type="text" name="jenis_vaksin" id="jenis_vaksin" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Vaksin</label>
		<input type="text" name="nama_vaksin" id="nama_vaksin" value="" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
			<label>Tanggal Imunisasi</label>
			<input type="text" name="tgl_imunisasi" id="tgl_imunisasi" value="" class="mydate" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Gejala</label>
		<span>
			<input type="checkbox" id="gejala" name="gejala[]" value="demam" >Demam<br/>
			<input type="checkbox" name="gejala[]" value="bengkak" >Bengkak di Lokasi Suntikan<br/>
			<input type="checkbox" name="gejala[]" value="merah" >Merah di Lokasi Suntikan<br/>
			<input type="checkbox" name="gejala[]" value="muntah" >Muntah<br/>
		</span>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Gejala Lain</label>
		<textarea type="text" name="gejala[]" id="gejala_lain" value="" rows="3" cols="45" ></textarea>
		</span>
	</fieldset>
	</fieldset>
	<fieldset>
		<?=getComboKeadaanKesehatan('','kondisiakhir','kondisiakhir','required','inline')?>	
	</fieldset>
	<?=getComboDokter1('','pemeriksa','pemeriksa','required','')?>
	<?=getComboDokter2('','petugas','petugas','required','')?>
	<?=getComboStatuskeluar('','status_keluar','status_keluar_id','required','')?>


	