<script>
jQuery().ready(function (){ 
	jQuery("#listmaster_kelurahanpopup").jqGrid({ 
		url:'c_master_kelurahan/masterkelurahanxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Kelurahan','Kode Kecamatan','Kelurahan','Kode Kelurahan'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:10,formatter:formatterAction}, 
				{name:'kodekelurahan',index:'kodekelurahan', width:35}, 
				{name:'kodekecamatan',index:'kodekecamatan', width:35}, 
				{name:'kelurahan',index:'kelurahan', width:50},
				{name:'myid',index:'myid', width:30,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagermasterkelurahanpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#kodekelurahanmaster_kelurahanpopup').val()?$('#kodekelurahanmaster_kelurahanpopup').val():'';
				idkec=$('#master_kecamatan_id_hidden').val()?$('#master_kecamatan_id_hidden').val():'';
				$('#listmaster_kelurahanpopup').setGridParam({postData:{'nama':nama,'idkec':idkec}})
			}
	}).navGrid('#pagermasterkelurahanpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkec" />';
		return content;
	}	
	
	$("#chkkec.chk").live('click', function(){		
		$("#listmaster_kelurahanpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listmaster_kelurahanpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listmaster_kelurahanpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listmaster_kelurahanpopup').jqGrid('getCell', colid, 'kelurahan');
					$('#<?=$id_caller?> #master_kelurahan_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_kelurahan_id').val(myCellDataColumn1);
					$("#dialogcari_master_kelurahan_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_kelurahanpopup").getGridParam("records")>0){
		jQuery('#listmaster_kelurahanpopup').setGridWidth(($(this).width()-28));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_kelurahanpopup").live('click', function(event){
		event.preventDefault();
		$('#formkelurahanpopup').reset();
		$('#listmaster_kelurahanpopup').trigger("reloadGrid");
	});
	$("#carimaster_kelurahanpopup").live('click', function(event){
		event.preventDefault();
		$('#listmaster_kelurahanpopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formkelurahanpopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Kelurahan</label>
		</span>
		<span>
		<input type="text" name="nama" class="nama" size="3" id="kodekelurahanmaster_kelurahanpopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_kelurahanpopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_kelurahanpopup"/>
		</span>
	</fieldset>
		<table id="listmaster_kelurahanpopup"></table>
		<div id="pagermasterkelurahanpopup"></div>
	</form>
</div>