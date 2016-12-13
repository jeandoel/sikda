<script>
jQuery().ready(function (){ 
	jQuery("#listpenkespopup").jqGrid({ 
		url:'c_master_pendidikan_kesehatan/penkesxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE PENDIDIKAN','PENDIDIKAN','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'kd_penkes',index:'kd_penkes', width:80,formatter:formatterAction}, 
				{name:'penkes',index:'penkes', width:80},			
				{name:'myid',index:'myid', width:90,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerpenkespopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#daripenkespopup').val()?$('#daripenkespopup').val():'';
				sampai=$('#sampaipenkespopup').val()?$('#sampaipenkespopup').val():'';
				nama=$('#namapenkespopup').val()?$('#namapenkespopup').val():'';
				$('#listpenkespopup').setGridParam({postData:{'dari':'','sampai':'','nama':nama}})
			}
	}).navGrid('#pagerpenkespopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(){		
		$("#listpenkespopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listpenkespopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listpenkespopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamaposyandu = jQuery('#listpenkespopup').jqGrid('getCell', colid, 'penkes');
					$('#<?=$id_caller?> #nama_penkes_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_penkes').val(myCellDataNamaposyandu);
					$("#dialogtransaksi_cari_namapenkes").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listpenkespopup").getGridParam("records")>0){
		jQuery('#listpenkespopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetpenkespopup").live('click', function(event){
		event.preventDefault();
		$('#formpenkespopup').reset();
		$('#listpenkespopup').trigger("reloadGrid");
	});
	$("#caripenkespopup").live('click', function(event){
		event.preventDefault();
		$('#listpenkespopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formpenkespopup">
	<div class="gridtitle">Daftar Pendidikan Kesehatan</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Nama Pendidikan</label>
				<input type="text" name="ras" class="ras" id="namapenkespopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caripenkespopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetpenkespopup" />
			</span>
		</fieldset>
		<table id="listpenkespopup"></table>
		<div id="pagerpenkespopup"></div>
		</div >
	</form>
</div>