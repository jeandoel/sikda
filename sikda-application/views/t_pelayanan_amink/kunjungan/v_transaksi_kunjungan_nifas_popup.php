<script>
jQuery().ready(function (){ 
	jQuery("#listt_kunjungan_nifaspopup").jqGrid({ 
		url:'t_kunjungan_nifas/kunjungannifasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Tanggal Kunjungan','Keluhan','Tekanan</br> Darah','Nadi </br>Per Menit ','Nafas </br>Per Menit','Suhu','Kontraksi</br>Rahim','Perdarahan','Warna </br>Lokhia','Jumlah </br> Lokhia','Bau </br> Lokhia','Buang </br>Air Besar','Buang </br>Air kecil','Produksi </br>ASI','Nasihat','Status </br>Hamil'],
		rownumbers:true,
		width: 1500,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:15,hidden:true},
				{name:'tanggal',index:'tanggal', width:115},
				{name:'keluhan',index:'keluhan', width:100}, 
				{name:'tekanan_darah',index:'tekanan_darah', width:100}, 
				{name:'nadi',index:'nadi', width:90},
				{name:'nafas',index:'nafas', width:100},
				{name:'suhu',index:'suhu', width:75},
				{name:'kontraksi',index:'kontraksi', width:100}, 				
				{name:'perdarahan',index:'perdarahan', width:125}, 
				{name:'warna_lokhia',index:'warna_lokhia', width:99},
				{name:'jumlah_lokhia',index:'jumlah_lokhia', width:100}, 
				{name:'bau_lokhia',index:'bau_lokhia', width:100},
				{name:'bab',index:'bab', width:100},
				{name:'bak',index:'bak', width:100},
				{name:'produksi_asi',index:'produksi_asi', width:100}, 	 
				{name:'nasehat',index:'nasehat', width:150},
				{name:'stat_hamil',index:'stat_hamil', width:100}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_kunjungan_nifaspopup'), 
			viewrecords: true, 
			sortorder: "desc",
			
	}).navGrid('#pagert_kunjungan_nifaspopup',{edit:false,add:false,del:false,search:false});
	
	
	
	$(".chk").live('click', function(){		
		$("#listt_kunjungan_nifaspopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listt_kunjungan_nifaspopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listt_kunjungan_nifaspopup').jqGrid('getCell', colid, 'myid');
					var myCellDatatkunjungannifas = jQuery('#listt_kunjungan_nifaspopup').jqGrid('getCell', colid, 'tanggal');
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
	$("#resetkunjungannifaspopup").live('click', function(event){
		event.preventDefault();
		$('#formraspopup').reset();
		$('#listt_kunjungan_nifaspopup').trigger("reloadGrid");
	});
	$("#carikunjungannifaspopup").live('click', function(event){
		event.preventDefault();
		$('#listt_kunjungan_nifaspopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formraspopup">
	<div class="gridtitle">List Riwayat Kunjungan Nifas</div>
		<fieldset>
			<span>
				<label>Rekam Medis</label>
				<input type="text" name="rekam_medis" id="rekam_medis" value="" disabled   />
			</span>
			<span>
				<label>Nama Pasien</label>
				<input type="text" name="nm_pasien" id="nm_pasien" value="" disabled />
			</span>
		</fieldset>
		<table id="listt_kunjungan_nifaspopup"></table>
		<div id="pagert_kunjungan_nifaspopup"></div>
		</div >
	</form>
</div>