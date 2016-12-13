<script>
jQuery().ready(function (){ 
	jQuery("#listterapipopup").jqGrid({ 
		url:'c_master_terapi_obat/master_terapiobatxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','KD TERAPI OBAT','TERAPI OBAT','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,align:'center',hidden:false,formatter:formatterAction},
				{name:'kodeterapiobat',index:'kodeterapiobat', width:20, align:'center'}, 
				{name:'terapiobat',index:'terapiobat', width:40},				
				{name:'myid',index:'myid', width:90,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerterapipopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#dariterapipopup').val()?$('#dariterapipopup').val():'';
				sampai=$('#sampaiterapipopup').val()?$('#sampaiterapipopup').val():'';
				nama=$('#namaterapipopup').val()?$('#namaterapipopup').val():'';
				$('#listterapipopup').setGridParam({postData:{'dari':'','sampai':'','nama':nama}})
			}
	}).navGrid('#pagerterapipopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(){		
		$("#listterapipopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listterapipopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listterapipopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamaposyandu = jQuery('#listterapipopup').jqGrid('getCell', colid, 'terapiobat');
					$('#<?=$id_caller?> #nama_terapi_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_terapi').val(myCellDataNamaposyandu);
					$("#dialogtransaksi_cari_namaterapi").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listterapipopup").getGridParam("records")>0){
		jQuery('#listterapipopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetterapipopup").live('click', function(event){
		event.preventDefault();
		$('#formterapipopup').reset();
		$('#listterapipopup').trigger("reloadGrid");
	});
	$("#cariterapipopup").live('click', function(event){
		event.preventDefault();
		$('#listterapipopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formterapipopup">
	<div class="gridtitle">Daftar Terapi</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Nama Terapi</label>
				<input type="text" name="terapiobat" class="name" id="namaterapipopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cariterapipopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetterapipopup" />
			</span>
		</fieldset>
		<table id="listterapipopup"></table>
		<div id="pagerterapipopup"></div>
		</div >
	</form>
</div>