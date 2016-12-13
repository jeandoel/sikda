 <style>
.ui-menu-item{
	font-size:.59em;
	color:blue!important;
}
.ui-autocomplete-category {
	font-weight: bold;
	padding: .1em .1.5em;
	margin: .8em 0 .2em;
	line-height: 1.5;
	font-size:.71em;
}
.ui-autocomplete{
	width:355px!important;
}
.inputaction1{
	width:255px;font-weight:bold;
}
.inputaction2{
	width:255px;font-weight:bold;color:#0B77B7
}
.labelaction{
	font-weight:bold;font-size:1.05em;color:#0B77B7;width:175px;
}
.declabel{width:91px}
.declabel2{width:175px}
.decinput{width:99px}
</style>
<script>
	jQuery("#listimunisasivaksin").jqGrid({
			datatype: 'clientSide',
			rownumbers:true,
			width: 581,
			height: 'auto',
			colNames:['KD Jenis Imunisasi','Jenis Imunisasi'/*,'KD Vaksin', 'Vaksin'*/],
			colModel :[ 
			{name:'kd_jenis_imunisasi',index:'kd_jenis_imunisasi', width:300,hidden:true},  
			{name:'jenis_imunisasi',index:'jenis_imunisasi', width:300, align:'center'},
			//{name:'kd_vaksin',index:'kd_vaksin', width:300,hidden:true},			
			//{name:'vaksin',index:'vaksin', width:300}, 
			],
			rowNum:35,
			viewrecords: true
		});
		
	var imunisasivaksinid = 0;
	$('#tambahimunisasivaksinid').click(function(){
		if($('#jenis_imunisasit_imunisasiadd').val()/* && $('#vaksint_imunisasiadd').val()*/){
			var myfirstrow = {kd_jenis_imunisasi:$('#jenis_imunisasit_imunisasiadd option:selected').val(),/*kd_vaksin:$('#vaksint_imunisasiadd option:selected').val(),*/jenis_imunisasi:$('#jenis_imunisasit_imunisasiadd option:selected').text()};//,vaksin:$('#vaksint_imunisasiadd option:selected').text()};
			jQuery("#listimunisasivaksin").addRowData(imunisasivaksinid+1, myfirstrow);
			$('#jenis_imunisasit_imunisasiadd').val('');
			//$('#vaksint_imunisasiadd').val('');
			if(confirm('Tambah Data imunisasi & vaksin lain?')){
				$('#jenis_imunisasit_imunisasiadd').focus();					
			}
		}else{
			alert('Silahkan Pilih Jenis Imunisasi & Vaksin.');
		}
	})
	
	$('#hapusimunisasivaksinid').click(function(){
		jQuery("#listimunisasivaksin").clearGridData();
	})
	
	//$("#vaksint_imunisasiadd").chained("#jenis_imunisasit_imunisasiadd");
	
	$("#form1t_imunisasi").validate({focusInvalid:true});


	$('#form1t_imunisasi :submit').click(function(e) {
		e.preventDefault();
		if($("#form1t_imunisasi").valid()) {
			if(kumpularray())$('#form1t_imunisasi').submit();
		}
		return false;
	});
	
	$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
	   var n = $(":text,:radio,:checkbox,select,textarea").length;
	   if (e.which == 13) 
	   {
			e.preventDefault();
			var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
			var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
			if(nextIndex < n && $(this).valid()){
				if($(this).attr('id')=='imunisasivaksinid'){
					if($('#jenis_imunisasit_imunisasiadd').val()){
						$('#tambahimunisasivaksinid').focus();return false;
					}else{
						$('#imunisasivaksinsearch').focus();
					}
				}
				$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
			}else{			
				if($("#form1t_imunisasi").valid()) {
					//$(':text,:radio,:checkbox,select,textarea')[nextIndex-1].blur();
					if(kumpularray())$('#form1t_imunisasi').submit();
				}
				return false;
			}
	   }
	});
</script>

<div class="subformtitle">Imunisasi & Vaksin</div>
<table id="listimunisasivaksin"></table>
<fieldset id="fieldsimunisasivaksin">
	<span>
	<?=getComboJenisimunisasi1('','jenis_imunisasi','jenis_imunisasit_imunisasiadd','','inline')?>
	</span>
	<span>
	<input type="hidden" name="imunisasivaksin_final" id="imunisasivaksin_final" />
	<input type="button" value="Tambah" id="tambahimunisasivaksinid" />
	<input type="button" value="Hapus" id="hapusimunisasivaksinid" />
	</span>
</fieldset>
<!--<fieldset>
	<span>
	<?=getComboVaksin('','vaksin','vaksint_imunisasiadd','','inline')?>
	</span>
	
</fieldset>-->
