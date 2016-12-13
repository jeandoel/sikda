<script>
jQuery().ready(function(){ 
		$('#form1t_pendaftarangabunggabung').ajaxForm({
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
					$("#t202","#tabs").empty();
					$("#t202","#tabs").load('t_pendaftaran'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		jQuery("#listt_pendaftarangabung").jqGrid({ 
		url:'t_pendaftaran/t_pendaftaranxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['Pilih','KD_PUSKESMAS','Pilih','Nama Pasien','KK','Tanggal Lahir','Umur','Alamat'],
		rownumbers:true,
		width: 1035,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'kd_pasien',index:'kd_pasien', width:21,hidden:true}, 
				{name:'kd_puskesmas',index:'kd_puskesmas', width:5,hidden:true}, 
				{name:'column1',index:'column1', width:25,sortable:false,formatter:formatterGabung}, 
				{name:'namapasien',index:'namapasien', width:105,sortable:false}, 
				{name:'column3',index:'column3', width:105,sortable:false},
				{name:'column4',index:'column4', width:65,align:'center',sortable:false},
				{name:'column5',index:'column5', width:45,align:'center',sortable:false},
				{name:'column6',index:'column6', width:175,sortable:false}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_pendaftaran'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordt_pendaftarangabung').val()?$('#keywordt_pendaftarangabung').val():'';
				cari=$('#carit_pendaftarangb').val()?$('#carit_pendaftarangb').val():'';
				usergabung = '<?=$data->KD_PASIEN?>'?'<?=$data->KD_PASIEN?>':'';
				$('#listt_pendaftarangabung').setGridParam({postData:{'keyword':keyword,'cari':cari,'usergabung':usergabung}})
			}
	}).navGrid('#pagert_pendaftarangabung',{edit:false,add:false,del:false,search:false});
	
	function formatterGabung(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
			{
			//$("#listt_pendaftarangabung").find('input[type=checkbox]').each(function() {			
				$(this).change( function(){
					var colid = $(this).parents('tr:last').attr('id');
						if( $(this).is(':checked')) {
							$("#listt_pendaftarangabung").jqGrid('setSelection', colid );
							$(this).prop('checked',true);
							var myCellKdPasien = jQuery('#listt_pendaftarangabung').jqGrid('getCell', colid, 'kd_pasien');
							var myCellKdPuskesmas = jQuery('#listt_pendaftarangabung').jqGrid('getCell', colid, 'kd_puskesmas');
							var myCellNama = jQuery('#listt_pendaftarangabung').jqGrid('getCell', colid, 'namapasien');
							$('#hidden_kdpuskesmas_selected').val(myCellKdPuskesmas);
							$('#kd_pasien_selected_hidden').val(myCellKdPasien);
							var o = new Option("option text", ""+myCellKdPasien+"");
							$(o).html(""+myCellKdPasien+" - "+myCellNama+"");
							$("#id_gabungid").append(o);
							$("#id_gabungid").focus();
						}else{
							$("#listt_pendaftarangabung").jqGrid('setSelection', colid );
							$(this).prop('checked',false);
							var myCellKdPasien = jQuery('#listt_pendaftarangabung').jqGrid('getCell', colid, 'kd_pasien');
							var myCellKdPuskesmas = jQuery('#listt_pendaftarangabung').jqGrid('getCell', colid, 'kd_puskesmas');
							var myCellNama = jQuery('#listt_pendaftarangabung').jqGrid('getCell', colid, 'namapasien');
							$('#hidden_kdpuskesmas_selected').val('');
							$('#kd_pasien_selected_hidden').val('');
							$("select#id_gabungid option").filter("[value='"+myCellKdPasien+"']").remove();
						}
				});	
			//});
		}
		$(e.target).data('oneclicked','yes');
	});
		
});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_pendaftarangabung").live('click', function(event){
		event.preventDefault();
		$('#form1t_pendaftarangabunggabung').reset();
		$('#listt_pendaftarangabung').trigger("reloadGrid");
	});
	$("#carit_pendaftarangabung").live('click', function(event){
		event.preventDefault();
		$('#listt_pendaftarangabung').trigger("reloadGrid");
	});	
/*$('#carit_pendaftarangb').keyup(function(e){
e.preventDefault();
if(e.keyCode == 13)
{
  alert('asdf');
}
});*/

$("#showhide_pasienbaru_kunjungan").focus();
</script>
<script>
	$("#form1t_pendaftarangabunggabung input[name = 'batal'], #backlistt_pendaftarangabung").click(function(){
		$("#t202","#tabs").empty();
		$("#t202","#tabs").load('t_pendaftaran'+'?_=' + (new Date()).getTime());
	});
</script>
<div class="mycontent">
<div class="formtitle">Gabung Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistt_pendaftarangabung">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1t_pendaftarangabunggabung" method="post" action="<?=site_url('t_pendaftaran/gabungprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Rekam Medis#</label>
		<input type="text" name="text" value="<?=$data->KD_PASIEN?>" disabled />
		<input type="hidden" name="kd_pasien_hidden" id="textid" value="<?=$data->KD_PASIEN?>" />
		<input type="hidden" name="kd_puskesmas_hidden" id="textid" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="hidden" name="kd_puskesmas_selected_hidden" id="hidden_kdpuskesmas_selected" />
		<input type="hidden" name="kd_pasien_selected_hidden" id="kd_pasien_selected_hidden" />
		</span>
		<span>
		<label>NIK</label>
		<input type="text" name="text" value="<?=$data->NIK?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Pasien</label>
		<input type="text" name="text" value="<?=$data->NAMA_PASIEN?>" disabled />
		</span>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="text" value="<?=$data->KD_GOL_DARAH?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Pasien</label>
		<input type="text" name="text" value="<?=$data->CUSTOMER?>" disabled />
		</span>
		<span>
		<label>Tanggal Lahir</label>
		<input type="text" name="text" value="<?=$data->TGL_LAHIR?>" disabled />
		</span>
	</fieldset>
	
	<div class="gridtitle_t">&nbsp;</div>		
	<fieldset class="fieldsetpencarian" id="fieldset_t_pendaftarangabung_pasien">
		<span>
			<label>Pencarian Berdasarkan</label>
			<select id="keywordt_pendaftarangabung" name="keywordt_pendaftaran">
				<option value="NAMA_LENGKAP">Nama Pasien</option>
				<option value="SHORT_KD_PASIEN">Rekam Medis</option>
				<option value="NO_KK">No Kartu Keluarga</option>
				<option value="NO_PENGENAL">NIK</option>
				<option value="KK">Kepala Keluarga</option>
				<option value="TEMPAT_LAHIR">Tempat Lahir</option>
				<option value="ALAMAT">Alamat</option>
			</select>
			<input type="text" name="carit_pendaftaran" id="carit_pendaftarangb"/>
			<input type="button" class="cari" value="&nbsp;Cari&nbsp;" id="carit_pendaftarangabung" />
			<input type="button" class="reset" value="&nbsp;Reset&nbsp;" id="resett_pendaftarangabung"/>
		</span>
	</fieldset>
	
	<div class="paddinggrid" id="pendaftaran_grid_pasien_gabung">
	<table id="listt_pendaftarangabung"></table>
	<div id="pagert_pendaftarangabung"></div>		
	</div >
	
	<br/>
	<fieldset>
		<span>
		<label>Pilih No. Rekam Medis Induk</label>
		<select name="id_gabung" id="id_gabungid" style="width:355px">
			<option value="<?=$data->KD_PASIEN?>" selected ><?=$data->KD_PASIEN?> - <?=$data->NAMA_PASIEN?></option>
		</select>
		</span>		
	</fieldset>
	<br/>
	<fieldset>
		<span>
		<input type="button" name="batal" value="Batal" />
		&nbsp; - &nbsp;
		<input type="submit" id="submitformid" name="bt1" value="Gabung Pasien"/>
		</span>
	</fieldset>	
</form>
</div >