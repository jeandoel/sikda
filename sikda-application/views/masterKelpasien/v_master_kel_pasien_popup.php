<script>
jQuery().ready(function (){ 
	jQuery("#listrkelpasienpopup").jqGrid({ 
		url:'c_master_kel_pasien/kelpasienxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KODE CUSTEMER','CUSTEMER','TELEPON','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'kd_cus',index:'kd_cus', width:80 ,formatter:formatterAction}, 
				{name:'cus',index:'cus', width:80},	
				{name:'tlp1',index:'tlp1', width:80},,				
				{name:'myid',index:'myid', width:90,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerkelpasienpopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darikelpasienpopup').val()?$('#darikelpasienpopup').val():'';
				sampai=$('#sampaikelpasienpopup').val()?$('#sampaikelpasienpopup').val():'';
				nama=$('#namakelpasienpopup').val()?$('#namakelpasienpopup').val():'';
				$('#listrkelpasienpopup').setGridParam({postData:{'dari':'','sampai':'','nama':nama}})
			}
	}).navGrid('#pagerkelpasienpopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" />';
		return content;
	}
	
	$(".chk").live('click', function(){		
		$("#listrkelpasienpopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listrkelpasienpopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listrkelpasienpopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamaposyandu = jQuery('#listrkelpasienpopup').jqGrid('getCell', colid, 'cus');
					$('#<?=$id_caller?> #nama_cus_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #nama_cus').val(myCellDataNamaposyandu);
					$("#dialogtransaksi_cari_namacus").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(g) {
		if($("#listrkelpasienpopup").getGridParam("records")>0){
		jQuery('#listrkelpasienpopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetkelpasienpopup").live('click', function(event){
		event.preventDefault();
		$('#formkelpasienpopup').reset();
		$('#listrkelpasienpopup').trigger("reloadGrid");
	});
	$("#carikelpasienpopup").live('click', function(event){
		event.preventDefault();
		$('#listrkelpasienpopup').trigger("reloadGrid");
	});
})
</script>

<div class="mycontent">
	<form id="formkelpasienpopup">
	<div class="gridtitle">Daftar Kelompok Pasien</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Nama Custemer</label>
				<input type="text" name="cus" class="cus" id="namakelpasienpopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carikelpasienpopup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkelpasienpopup" />
			</span>
		</fieldset>
		<table id="listrkelpasienpopup"></table>
		<div id="pagerkelpasienpopup"></div>
		</div >
	</form>
</div>