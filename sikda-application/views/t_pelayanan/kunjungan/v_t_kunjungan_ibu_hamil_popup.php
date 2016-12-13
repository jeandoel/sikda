<script>
jQuery().ready(function (){ 
	jQuery("#listt_kunjungan_ibu_hamil_popup").jqGrid({ 
		url:'t_kunjungan_ibu_hamil/t_kunjungan_ibu_hamilxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD_KUNJUNGAN_BUMIL','Kode','KD KIA','Tanggal Kunjungan','Kunjungan Ke','Keluhan','Tekanan Darah','Berat Badan','Umur Kehamilan','Tinggi Fundus','Letak Janin','Denyut Jantung','Kaki Bengkak','Lab Darah','Lab Urin Reduksi','Lab Urin Proteksi','Tindakan','Pemeriksaan Khusus','Jenis Kasus','Status Hamil','Nasehat','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true},
				{name:'kd_bumil',index:'kd_bumil', width:50,hidden:true},
				{name:'kd_kia',index:'kd_kia', width:50,align:'center',hidden:true}, 
				{name:'tgl_kunjungan',index:'tgl_kunjungan', width:80,align:'center'}, 
				{name:'kunjungan_ke',index:'kunjungan_ke', width:100}, 
				{name:'keluhan',index:'keluhan', width:100}, 
				{name:'tekanan_darah',index:'tekanan_darah', width:100},
				{name:'berat_badan',index:'berat_badan', width:100},
				{name:'umur_hamil',index:'umur_hamil', width:100},
				{name:'tinggi_fundus',index:'tinggi_fundus', width:100},
				{name:'letak_janin',index:'letak_janin', width:100},
				{name:'denyut_jantung',index:'denyut_jantung', width:100},
				{name:'kaki_bengkak',index:'kaki_bengkak', width:100},
				{name:'lab_darah',index:'lab_darah', width:100},
				{name:'lab_urin_reduksi',index:'lab_urin_reduksi', width:100},
				{name:'lab_urin_protein',index:'lab_urin_protein', width:100},
				{name:'tindakan',index:'tindakan', width:100},
				{name:'pemeriksaan_khusus',index:'pemeriksaan_khusus', width:100},
				{name:'jenis_kasus',index:'jenis_kasus', width:100},
				{name:'status_hamil',index:'status_hamil', width:100},
				{name:'nasehat',index:'nasehat', width:100},
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction,hidden:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_kunjungan_ibu_hamil_popup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darit_kunjungan_ibu_hamil_popup').val()?$('#darit_kunjungan_ibu_hamil_popup').val():'';
				sampai=$('#sampait_kunjungan_ibu_hamil_popup').val()?$('#sampait_kunjungan_ibu_hamil_popup').val():'';
				keyword=$('#keywordt_kunjungan_ibu_hamil_popup').val()?$('#keywordt_kunjungan_ibu_hamil_popup').val():'';
				carinama=$('#carinamat_kunjungan_ibu_hamil_popup').val()?$('#carinamat_kunjungan_ibu_hamil_popup').val():'';
				get_kd_pasien=$('#get_kd_pasien').val()?$('#get_kd_pasien').val():'';
				$('#listt_kunjungan_ibu_hamil_popup').setGridParam({postData:{'dari':dari,'sampai':sampai,'keyword':keyword,'carinama':carinama,'get_kd_pasien':get_kd_pasien}})
			}
	}).navGrid('#pagert_kunjungan_ibu_hamil_popup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkham" />';
		return content;
	}	
	
	$("#chkham.chk").live('click', function(){		
		$("#listt_kunjungan_ibu_hamil_popup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listt_kunjungan_ibu_hamil_popup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listt_kunjungan_ibu_hamil_popup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listt_kunjungan_ibu_hamil_popup').jqGrid('getCell', colid, 'kd_bumil');
					$('#<?=$id_caller?> #kunjungan_ibu_hamil_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #kunjungan_ibu_hamil_id').val(myCellDataColumn1);
					$("#dialogcari_kunjungan_ibu_hamil_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listt_kunjungan_ibu_hamil_popup").getGridParam("records")>0){
		jQuery('#listt_kunjungan_ibu_hamil_popup').setGridWidth(($(this).width()-28));
		}
	});
	
	$( "#sampait_kunjungan_ibu_hamil_popup" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listt_kunjungan_ibu_hamil_popup').trigger("reloadGrid");
			}
	});
	
	$('#darit_kunjungan_ibu_hamil_popup').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_kunjungan_ibu_hamil_popup').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_kunjungan_ibu_hamil_popup');}});
	$('#sampait_kunjungan_ibu_hamil_popup').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listt_kunjungan_ibu_hamil_popup').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_kunjungan_ibu_hamil_popup").live('click', function(event){
		event.preventDefault();
		$('#formt_kunjungan_ibu_hamil_popup').reset();
		$('#listt_kunjungan_ibu_hamil_popup').trigger("reloadGrid");
	});
	$("#carit_kunjungan_ibu_hamil_popup").live('click', function(event){
		event.preventDefault();
		$('#listt_kunjungan_ibu_hamil_popup').trigger("reloadGrid");
	});
})
</script>
<div>
	<input type="hidden" name="get_kd_pasien" id="get_kd_pasien" value="<?php echo $get_kd_pasien;?>">
</div>
<div class="mycontent">
	<form id="formt_kunjungan_ibu_hamil_popup">
	<fieldset style="margin:0 13px 0 13px ">
		</fieldset>
		<table id="listt_kunjungan_ibu_hamil_popup"></table>
		<div id="pagert_kunjungan_ibu_hamil_popup"></div>
		</div >
	</form>
</div>