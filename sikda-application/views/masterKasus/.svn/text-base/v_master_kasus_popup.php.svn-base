<script>
jQuery().ready(function (){ 
	jQuery("#listmasterkasuspopup").jqGrid({ 
		url:'c_master_kasus/masterkasusxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','KODE JENIS KASUS','VARIABEL ID','PARENT ID','VARIABEL NAME','VARIABEL DEFINISI','KETERANGAN','PILIHAN VALUE','IROW','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id1',index:'id1', width:10,align:'center',hidden:false,formatter:formatterAction}, 
				{name:'id',index:'id', width:30}, 
				{name:'varId',index:'varId', width:30}, 
				{name:'parId',index:'parId', width:30}, 
				{name:'varNam',index:'varNam', width:35}, 
				{name:'varDef',index:'varDef', width:50}, 
				{name:'ket',index:'ket', width:75,hidden:true}, 
				{name:'pilVal',index:'pilVal', width:35,align:'center'}, 
				{name:'irow',index:'irow', width:10,align:'center',hidden:true}, 
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterkasuspopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#carinamamasterkasuspopup').val()?$('#carinamamasterkasuspopup').val():'';
				$('#listmasterkasuspopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagermasterkasuspopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkasus" />';
		return content;
	}	
	
	$("#chkkasus.chk").live('click', function(){		
		$("#listmasterkasuspopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmasterkasuspopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmasterkasuspopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmasterkasuspopup').jqGrid('getCell', colid, 'namaKab');
					$('#<?=$id_caller?> #master_kasus_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_kasus_id').val(myCellDataColumn1);
					$("#dialogcari_master_kasus_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listmasterkasuspopup").getGridParam("records")>0){
		jQuery('#listmasterkasuspopup').setGridWidth(($(this).width()));
		}
	});
	
	$("#carimasterkasuspopup").live('click', function(event){
		event.preventDefault();
		$('#listmasterkasuspopup').trigger("reloadGrid");
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterkasuspopup").live('click', function(event){
		event.preventDefault();
		$('#formmasterkasuspopup').reset();
		$('#listmasterkasuspopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formmasterkasuspopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kasus</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="carinamamasterkasuspopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterkasuspopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterkasuspopup"/>
		</span>
	</fieldset>
		<table id="listmasterkasuspopup"></table>
		<div id="pagermasterkasuspopup"></div>
		</div >
	</form>
</div>