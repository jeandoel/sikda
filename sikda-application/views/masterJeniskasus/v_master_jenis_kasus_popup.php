<script>
jQuery().ready(function (){ 
	jQuery("#listjeniskasuspopup").jqGrid({ 
		url:'c_master_jenis_kasus/jeniskasusxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Kode Jenis Kasus','Jenis Kasus','Kode ICD Induk','Kode Jenis','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',hidden:false,formatter:formatterAction},
				{name:'kodejeniskasus',index:'kodejeniskasus', width:25,align:'center',hidden:false},
				{name:'jeniskasus',index:'jeniskasus', width:25,align:'center'},
				{name:'kodeicd',index:'kodeicd', width:100},
				{name:'kodejenis',index:'kodejenis', width:100},
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,20,30], 
			pager: jQuery('#pagerjeniskasuspopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#carinamajeniskasuspopup').val()?$('#carinamajeniskasuspopup').val():'';
				$('#listjeniskasuspopup').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagerjeniskasuspopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkjenis" />';
		return content;
	}	
	
	$("#chkjenis.chk").live('click', function(){		
		$("#listjeniskasuspopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listjeniskasuspopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listjeniskasuspopup').jqGrid('getCell', colid, 'myid');
					var myCellDataColumn1 = jQuery('#listjeniskasuspopup').jqGrid('getCell', colid, 'kodejeniskasus');
					$('#<?=$id_caller?> #master_jenis_kasus_id_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_jenis_kasus_id').val(myCellDataColumn1);
					$("#dialogcari_master_jenis_kasus_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(e) {
		if($("#listjeniskasuspopup").getGridParam("records")>0){
		jQuery('#listjeniskasuspopup').setGridWidth(($(this).width()));
		}
	});
	
	$("#carijeniskasuspopup").live('click', function(event){
		event.preventDefault();
		$('#listjeniskasuspopup').trigger("reloadGrid");
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetjeniskasuspopup").live('click', function(event){
		event.preventDefault();
		$('#formmasterjeniskasuspopup').reset();
		$('#listjeniskasuspopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formjeniskasuspopup">
	<fieldset style="margin:0 13px 0 13px ">
		<span>
		<label>Cari Jenis Kasus</label>
		</span>
		<span>
		<input type="text" name="carinama" class="nama" size="3" id="carinamajeniskasuspopup" autocomplete="off">
		<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carijeniskasuspopup"/>
		<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetjeniskasuspopup"/>
		</span>
	</fieldset>
		<table id="listjeniskasuspopup"></table>
		<div id="pagerjeniskasuspopup"></div>
		</div >
	</form>
</div>