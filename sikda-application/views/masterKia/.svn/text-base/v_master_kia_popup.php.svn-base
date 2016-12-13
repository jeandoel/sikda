<script>
jQuery().ready(function (){ 
	jQuery("#listmasterKiapopup").jqGrid({ 
		url:'c_master_kia/masterkiaxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['VARIA_ID','FORMAT XML','VARIABEL ID','PARENT ID','VARIABEL DATA','DEFINISI','PILIHAN VALUE','IROW','STATUS','PELAYANAN ULANG','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id1',index:'id1', width:25,align:'center',hidden:false,formatter:formatterAction}, 
				{name:'id',index:'id', width:70}, 
				{name:'varId',index:'varId', width:50}, 
				{name:'parId',index:'parId', width:50}, 
				{name:'varNam',index:'varNam', width:45}, 
				{name:'varDef',index:'varDef', width:50}, 
				{name:'pilVal',index:'pilVal', width:35,align:'center',hidden:true}, 
				{name:'irow',index:'irow', width:15,align:'center',hidden:true}, 
				{name:'stat',index:'stat', width:15,align:'center'}, 
				{name:'pelul',index:'pelul', width:15,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterKiapopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#carinamamasterKiapopup').val()?$('#carinamamasterKiapopup').val():'';
				$('#listmasterKiapopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagermasterKiapopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkia" />';
		return content;
	}	
	
	$("#chkkia.chk").live('click', function(){		
		$("#listmasterKiapopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmasterKiapopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmasterKiapopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmasterKiapopup').jqGrid('getCell', colid, 'namaKab');
					$('#<?=$id_caller?> #master_kia_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_kia_id').val(myCellDataColumn1);
					$("#dialogcari_master_kia_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmasterKiapopup").getGridParam("records")>0){
		jQuery('#listmasterKiapopup').setGridWidth(($(this).width()));
		}
	});
	
	$("#carimasterKiapopup").live('click', function(event){
		event.preventDefault();
		$('#listmasterKiapopup').trigger("reloadGrid");
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterKiapopup").live('click', function(event){
		event.preventDefault();
		$('#formmasterKiapopup').reset();
		$('#listmasterKiapopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formmasterKiapopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Variabel ID Kia</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="carinamamasterKiapopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterKiapopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterKiapopup"/>
		</span>
	</fieldset>
		<table id="listmasterKiapopup"></table>
		<div id="pagermasterKiapopup"></div>
		</div >
	</form>
</div>