<script>
jQuery().ready(function (){ 
	jQuery("#listraspopup").jqGrid({ 
		url:'c_master_ras/rasxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE RAS','RAS','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_ras',index:'kd_ras', width:80,align:'center',formatter:formatterAction}, 
				{name:'ras',index:'ras', width:80},				
				{name:'myid',index:'myid', width:90,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerraspopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#dariraspopup').val()?$('#dariraspopup').val():'';
				sampai=$('#sampairaspopup').val()?$('#sampairaspopup').val():'';
				nama=$('#namaraspopup').val()?$('#namaraspopup').val():'';
				$('#listraspopup').setGridParam({postData:{'dari':'','sampai':'','nama':nama}})
			}
	}).navGrid('#pagerraspopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(){		
		$("#listraspopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listraspopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listraspopup').jqGrid('getCell', colid, 'myid');
					var myCellDataras = jQuery('#listraspopup').jqGrid('getCell', colid, 'ras');
					$('#<?=$id_caller?> #nama_ras_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_ras').val(myCellDataras);
					$("#dialogtransaksi_cari_namaras").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listraspopup").getGridParam("records")>0){
		jQuery('#listraspopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetraspopup").live('click', function(event){
		event.preventDefault();
		$('#formraspopup').reset();
		$('#listraspopup').trigger("reloadGrid");
	});
	$("#cariraspopup").live('click', function(event){
		event.preventDefault();
		$('#listraspopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formraspopup">
	<div class="gridtitle">Daftar Ras</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Nama Ras</label>
				<input type="text" name="ras" class="ras" id="namaraspopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cariraspopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetraspopup" />
			</span>
		</fieldset>
		<table id="listraspopup"></table>
		<div id="pagerraspopup"></div>
		</div >
	</form>
</div>