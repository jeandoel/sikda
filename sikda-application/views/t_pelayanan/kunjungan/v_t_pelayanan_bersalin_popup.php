<script>
jQuery().ready(function (){ 
	jQuery("#listt_kunjungan_bersalin").jqGrid({ 
		url:'t_kesehatan_ibu_dan_anak/pelayananbersalinpopupxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Tanggal Persalinan','Jam Kelahiran','Umur</br>Kehamilan','Penolong</br>Persalinan','Jabatan',
		'Cara</br>Persalinan','Jenis</br>Kelahiran','Jumlah</br>Bayi','Keadaan</br>Ibu','Anak</br>Ke','Berat</br>Lahir','Panjang</br>Badan',
		'Lingkar</br>Kepala','Jenis</br>Kelamin','Keadaan Bayi</br>Saat Lahir','Asuhan Bayi</br>Lahir','Keterangan</br>Tambahan'],
		rownumbers:true,
		width: 1500,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'tanggal',index:'tanggal', width:115},
				{name:'keluhan',index:'keluhan', width:100}, 
				{name:'tekanan_darah',index:'tekanan_darah', width:100}, 
				{name:'nadi',index:'nadi', width:90},
				{name:'nafas',index:'nafas', width:100},
				{name:'kontraksi',index:'kontraksi', width:100}, 				
				{name:'perdarahan',index:'perdarahan', width:125}, 
				{name:'warna_lokhia',index:'warna_lokhia', width:99},
				{name:'jumlah_lokhia',index:'jumlah_lokhia', width:100}, 
				{name:'bau_lokhia',index:'bau_lokhia', width:100},
				{name:'bab',index:'bab', width:100},
				{name:'bak',index:'bak', width:100},
				{name:'produksi_asi',index:'produksi_asi', width:100}, 	 
				{name:'nasehat',index:'nasehat', width:150},
				{name:'stat_hamil',index:'stat_hamil', width:100},
				{name:'nasehat1',index:'nasehat1', width:150},
				{name:'stat_hamil1',index:'stat_hamil1', width:100}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_kunjungan_bersalin'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				get_kd_pasien=$('#get_kd_pasien_bersalin').val()?$('#get_kd_pasien_bersalin').val():'';
				$('#listt_kunjungan_bersalin').setGridParam({postData:{'get_kd_pasien':get_kd_pasien}})
			}
	}).navGrid('#pagert_kunjungan_bersalin',{edit:false,add:false,del:false,search:false});
	
	
	
	$(".chk").live('click', function(){		
		$("#listt_kunjungan_bersalin").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listt_kunjungan_bersalin").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listt_kunjungan_bersalin').jqGrid('getCell', colid, 'myid');
					var myCellDatatkunjungannifas = jQuery('#listt_kunjungan_bersalin').jqGrid('getCell', colid, 'tanggal');
					$('#<?=$id_caller?> #kode_kunjungan_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #kode_kunjungan').val(myCellDatatkunjungannifas);
					$("#dialogtransaksi_cari_kunjungan_nifas").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listt_kunjungan_bersalin").getGridParam("records")>0){
		jQuery('#listt_kunjungan_bersalin').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetkunjungannifaspopup").live('click', function(event){
		event.preventDefault();
		$('#formraspopup').reset();
		$('#listt_kunjungan_bersalin').trigger("reloadGrid");
	});
	$("#carikunjungannifaspopup").live('click', function(event){
		event.preventDefault();
		$('#listt_kunjungan_bersalin').trigger("reloadGrid");
	});
})
</script>
<div>
	<input type="hidden" name="get_kd_pasien" id="get_kd_pasien_bersalin" value="<?php echo $get_kd_pasien;?>">
</div>
<div class="mycontent">
	<form id="formraspopup">
	<div class="gridtitle">List Riwayat Kunjungan Bersalin</div>
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
		<table id="listt_kunjungan_bersalin"></table>
		<div id="pagert_kunjungan_bersalin"></div>
		</div >
	</form>
</div>