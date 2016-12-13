<script>
jQuery().ready(function (){ 
	jQuery("#listt_kunjungan_nifaspopup").jqGrid({ 
		url:'t_kunjungan_nifas/kunjungannifasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Tanggal Kunjungan','Keluhan','Tekanan Darah','Nadi Per Menit ','Nafas Per Menit','Suhu','Kontraksi Rahim','Perdarahan','Warna Lokhia','Jumlah Lokhia','Bau Lokhia','Buang Air Besar','Buang Air kecil','Produksi ASI','Nasihat','Status Hamil'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5},
				{name:'tanggal',index:'tanggal', width:99},
				{name:'keluhan',index:'keluhan', width:100}, 
				{name:'tekanan_darah',index:'tekanan_darah', width:100}, 
				{name:'nadi',index:'nadi', width:75},
				{name:'nafas',index:'nafas', width:100},
				{name:'suhu',index:'suhu', width:75},
				{name:'kontraksi',index:'kontraksi', width:100}, 				
				{name:'perdarahan',index:'perdarahan', width:100}, 
				{name:'warna_lokhia',index:'warna_lokhia', width:99},
				{name:'jumlah_lokhia',index:'jumlah_lokhia', width:100}, 
				{name:'bau_lokhia',index:'bau_lokhia', width:100},
				{name:'bab',index:'bab', width:100},
				{name:'bak',index:'bak', width:100},
				{name:'produksi_asi',index:'produksi_asi', width:100}, 	 
				{name:'nasehat',index:'nasehat', width:99},
				{name:'stat_hamil',index:'stat_hamil', width:100}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_kunjungan_nifaspopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darit_kunjungan_nifas_popup').val()?$('#darit_kunjungan_nifas_popup').val():'';
				sampai=$('#sampait_kunjungan_nifas_popup').val()?$('#sampait_kunjungan_nifas_popup').val():'';
				kode=$('#kodet_kunjungan_nifas_popup').val()?$('#kodet_kunjungan_nifas_popup').val():'';
				$('#listt_kunjungan_nifaspopup').setGridParam({postData:{'dari':dari,'sampai':sampai,'kode':kode}})
			}
	}).navGrid('#pagert_kunjungan_nifaspopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(){		
		$("#listt_kunjungan_nifaspopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listt_kunjungan_nifaspopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listt_kunjungan_nifaspopup').jqGrid('getCell', colid, 'myid');
					var myCellDatatkunjungannifas = jQuery('#listt_kunjungan_nifaspopup').jqGrid('getCell', colid, 'id');
					$('#<?=$id_caller?> #kode_kunjungan_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #kode_kunjungan').val(myCellDatatkunjungannifas);
					$("#dialogtransaksi_cari_kunjungan_nifas").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listt_kunjungan_nifaspopup").getGridParam("records")>0){
		jQuery('#listt_kunjungan_nifaspopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetraspopup").live('click', function(event){
		event.preventDefault();
		$('#formraspopup').reset();
		$('#listt_kunjungan_nifaspopup').trigger("reloadGrid");
	});
	$("#cariraspopup").live('click', function(event){
		event.preventDefault();
		$('#listt_kunjungan_nifaspopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formraspopup">
	<div class="gridtitle">Tabel Catatan Kesehatan Ibu Nifas</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Kode Nifas</label>
				<input type="text" name="id" class="id" id="namaraspopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cariraspopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetraspopup" />
			</span>
		</fieldset>
		<table id="listt_kunjungan_nifaspopup"></table>
		<div id="pagerraspopup"></div>
		</div >
	</form>
</div>