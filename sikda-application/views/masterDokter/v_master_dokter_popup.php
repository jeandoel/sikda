<script>
jQuery().ready(function (){ 
	jQuery("#listmasterDokterpopup").jqGrid({ 
		url:'c_master_dokter/masterdokterxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE','id1','Nama','NIP','Jabatan','Status','Kode Puskesmas','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',formatter:formatterAction}, 
				{name:'id1',index:'id1', width:25,align:'center',hidden:false}, 
				{name:'nama',index:'nama', width:100}, 
				{name:'nip',index:'nip', width:100}, 
				{name:'jab',index:'jab', width:100}, 
				{name:'sts',index:'sts', width:100}, 
				{name:'kdpus',index:'kdpus', width:100}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterDokterpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#namamasterDokterpopup').val()?$('#namamasterDokterpopup').val():'';
				$('#listmasterDokterpopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagermasterDokterpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkdok" />';
		return content;
	}	
	
	$("#chkdok.chk").live('click', function(){		
		$("#listmasterDokterpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmasterDokterpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmasterDokterpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmasterDokterpopup').jqGrid('getCell', colid, 'nama');
					var myCellDataColumn2 = jQuery('#listmasterDokterpopup').jqGrid('getCell', colid, 'nip');
					$('#<?=$id_caller?> #master_dokter_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_dokter_id').val(myCellDataColumn1);
					$('#<?=$id_caller?> #master_dokter_id_nip').val(myCellDataColumn2);
					$("#dialogcari_master_dokter_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmasterDokterpopup").getGridParam("records")>0){
		jQuery('#listmasterDokterpopup').setGridWidth(($(this).width()));
		}
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterDokterpopup").live('click', function(event){
		event.preventDefault();
		$('#formmasterDokterpopup').reset();
		$('#listmasterDokterpopup').trigger("reloadGrid");
	});
	$("#carimasterDokterpopup").live('click', function(event){
		event.preventDefault();
		$('#listmasterDokterpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formmasterDokterpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Dokter/Petugas</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="namamasterDokterpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterDokterpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterDokterpopup"/>
		</span>
	</fieldset>
		<table id="listmasterDokterpopup"></table>
		<div id="pagermasterDokterpopup"></div>
		</div >
	</form>
</div>