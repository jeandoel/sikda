<script>
jQuery().ready(function (){ 
	jQuery("#listtranskotapopup").jqGrid({ 
		url:'c_master_kota/masterkotaxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Nama Kota','Tgl. Master','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:15,align:'center',hidden:false,formatter:formatterAction},
				{name:'namaKota',index:'namaKota', width:100}, 
				{name:'tgl_masterKota',index:'tgl_masterKota', width:75,align:'center',hidden:true},
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagertranswilayahpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carinama=$('#carinamatranswilayahpopup').val()?$('#carinamatranswilayahpopup').val():'';
				$('#listtranskotapopup').setGridParam({postData:{'dari':'','sampai':'','carinama':carinama}})
			}
	}).navGrid('#pagertranswilayahpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkota" />';
		return content;
	}	
	
	$("#chkkota.chk").live('click', function(){		
		$("#listtranskotapopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listtranskotapopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listtranskotapopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listtranskotapopup').jqGrid('getCell', colid, 'namaKota');
					$('#<?=$id_caller?> #master_kota_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_kota_id').val(myCellDataColumn1);
					$("#dialogcari_master_kota_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listtranskotapopup").getGridParam("records")>0){
		jQuery('#listtranskotapopup').setGridWidth(($(this).width()));
		}
	});
	
	$("#caritranswilayahpopup").live('click', function(event){
		event.preventDefault();
		$('#listtranskotapopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kota</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="carinamatranswilayahpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caritranswilayahpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resettranswilayahpopup"/>
		</span>
	</fieldset>
	<form id="formtranswilayahpopup">
		<table id="listtranskotapopup"></table>
		<div id="pagertranswilayahpopup"></div>
		</div >
	</form>
</div>