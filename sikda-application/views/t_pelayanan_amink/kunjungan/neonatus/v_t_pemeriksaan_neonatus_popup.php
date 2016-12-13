<script>
jQuery().ready(function (){ 
	jQuery("#listpemeriksaanneonatuspopup").jqGrid({ 
		url:'t_pemeriksaan_neonatus/transaksi_pemeriksaanneonatusxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 					
		colNames:['KD PEMERIKSAAN NEONATUS','KD PEMERIKSAAN NEONATUS','KD PUSKESMAS','Tanggal Pemeriksaan','Kunjungan ke','Berat Badan (kg)','Panjang Badan (cm)','Memeriksa Bayi/Anah','Keterangan','Tindakan Ibu','Keluhan','Pemeriksa','Petugas','Nama Lengkap'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodepemeriksaanneonatus',index:'kodepemeriksaanneonatus', width:50, hidden:true},  
				{name:'kd_puskesmas',index:'kd_puskesmas', width:50, hidden:true},  
				{name:'tglkunjungan',index:'tglkunjungan', align:'center', width:50}, 
				{name:'kunjunganke',index:'kunjunganke', width:50}, 
				{name:'beratbadan',index:'beratbadan', width:50}, 
				{name:'panjangbadan',index:'panjangbadan', width:50}, 
				{name:'tindakananak',index:'tindakananak', width:70}, 
				{name:'keterangan',index:'keterangan', width:50}, 
				{name:'tindakanibu',index:'tindakanibu', width:80}, 
				{name:'keluhan',index:'keluhan', width:50}, 
				{name:'pemeriksa',index:'pemeriksa', width:50}, 
				{name:'petugas',index:'petugas', width:50},
				{name:'namalengkap',index:'namalengkap', width:50},	
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagerpemeriksaanneonatuspopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#carinamapemeriksaanneonatuspopup').val()?$('#carinamapemeriksaanneonatuspopup').val():'';
				$('#listpemeriksaanneonatuspopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagerpemeriksaanneonatuspopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkab" />';
		return content;
	}	
	
	$("#chkkab.chk").live('click', function(){		
		$("#listpemeriksaanneonatuspopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listpemeriksaanneonatuspopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listpemeriksaanneonatuspopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listpemeriksaanneonatuspopup').jqGrid('getCell', colid, 'kodepemeriksaanneonatus');
					$('#<?=$id_caller?> #pemeriksaan_neonatus_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #pemeriksaan_neonatus_id').val(myCellDataColumn1);
					$("#dialogcari_pemeriksaan_neonatus_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listpemeriksaanneonatuspopup").getGridParam("records")>0){
		jQuery('#listpemeriksaanneonatuspopup').setGridWidth(($(this).width()));
		}
	});
	
	$("#caripemeriksaanneonatuspopup").live('click', function(event){
		event.preventDefault();
		$('#listpemeriksaanneonatuspopup').trigger("reloadGrid");
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetpemeriksaanneonatuspopup").live('click', function(event){
		event.preventDefault();
		$('#formpemeriksaanneonatuspopup').reset();
		$('#listpemeriksaanneonatuspopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formpemeriksaanneonatuspopup">
	<fieldset style="margin:0 13px 0 13px ">
		</fieldset>
		<table id="listpemeriksaanneonatuspopup"></table>
		<div id="pagerpemeriksaanneonatuspopup"></div>
		</div >
	</form>
</div>