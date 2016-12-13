<script>
jQuery().ready(function (){ 
	jQuery("#listpelayanankb").jqGrid({ 
		url:'t_pelayanan_kb/t_pelayanan_kbxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Tanggal Pemeriksaan','KD KUNJUNGAN KB','Kd Puskesmas','Jenis KB','Nama Pemeriksa','Nama Petugas','KELUHAN','ANAMNESE','TINDAKAN','Obat','Action'],
		rownumbers:true,
		width: 5000,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:20,hidden:true},
				{name:'tanggalpemeriksaan',index:'tanggalpemeriksaan', width:60},
				{name:'kdkunjungankb',index:'kdkunjungankb', width:20,hidden:true}, 
				{name:'kd_puskesmas',index:'kd_puskesmas', width:20,hidden:true}, 
				{name:'kdjeniskb',index:'kdjeniskb', width:70}, 
				{name:'pemeriksa',index:'pemeriksa', width:90}, 
				{name:'petugas',index:'petugas', width:90}, 
				{name:'keluhan',index:'keluhan', width:50,hidden:false}, 
				{name:'anamnese',index:'anamnese', width:50,hidden:false}, 
				{name:'kdtindakan',index:'kdtindakan', width:120}, 
				{name:'obat',index:'obat', width:120}, 
				{name:'myid',index:'myid', width:30,align:'center',formatter:formatterAction,hidden:true}
			],
			rowNum:5, 
			rowList:[5,20,30], 
			pager: jQuery('#pagertpelayanankbpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				group=$('#groupid_tpelayanankbpopup').val()?$('#groupid_tpelayanankbpopup').val():'';
				get_kd_pasien=$('#get_kd_pasien_kb').val()?$('#get_kd_pasien_kb').val():'';
				$('#listpelayanankb').setGridParam({postData:{'group':group, 'get_kd_pasien':get_kd_pasien}})
			}
	}).navGrid('#pagertpelayanankbpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkec" />';
		return content;
	}	
	
	$("#chkkec.chk").live('click', function(){		
		$("#listpelayanankb").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listpelayanankb").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listpelayanankb').jqGrid('getCell', colid, 'myid');
					var myCellDataNamausergroup = jQuery('#listpelayanankb').jqGrid('getCell', colid, 'namagroup');
					$('#<?=$id_caller?> #t_pelayanan_kb_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #t_pelayanan_kb_popup').val(myCellDataNamausergroup);
					$("#dialogcari_t_pelayanan_kb_popup_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(y) {
		if($("#listpelayanankb").getGridParam("records")>0){
		jQuery('#listpelayanankb').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resettpelayanankbpopup").live('click', function(event){
		event.preventDefault();
		$('#formtpelayanakbpopup').reset();
		$('#listpelayanankb').trigger("reloadGrid");
	});
	$("#caritpelayanankb").live('click', function(event){
		event.preventDefault();
		$('#listpelayanankb').trigger("reloadGrid");
	});
	
})
</script>
<div>
	<input type="hidden" name="get_kd_pasien_kb" id="get_kd_pasien_kb" value="<?php echo $get_kd_pasien;?>">
</div>
<div class="mycontent">
	<form id="formtpelayanakbpopup">
		<div class="gridtitle">Daftar Pelayanan KB</div>
		<table id="listpelayanankb"></table>
		<div id="pagertpelayanankbpopup"></div>
	</form>
</div>