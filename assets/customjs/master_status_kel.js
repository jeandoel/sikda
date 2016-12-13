jQuery().ready(function (){ 
	jQuery("#listmasterstatuskel").jqGrid({ 
		url:'master_status_kel/masterstatus_kelxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','ID Status Kel','Status Keluarga','Keterangan','Tgl Master','Action'],
		rownumbers:true,
		width: 1040,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'nid_status_kel',index:'nid_status_kel', width:99}, 
				{name:'nstatus_kel',index:'nstatus_kel', width:99}, 
				{name:'nketerangan',index:'nketerangan', width:99},
				{name:'ntgl_masteridp',index:'ntgl_masteridp', width:99},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster3'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darimaster').val()?$('#darimaster3').val():'';
				sampai=$('#sampaimaster3').val()?$('#sampaimaster3').val():'';
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#carimaster3').val()?$('#carimaster3').val():'';
				$('#listmasterstatuskel').setGridParam({postData:{'dari':dari,'sampai':sampai,'keyword':keyword,'cari':cari}})
			}
	}).navGrid('#pagermaster3',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$(".icon-detail").live('click', function(){
		$("#t9","#tabs").empty();
		$("#t9","#tabs").load('master_status_kel/detail'+'?id='+this.rel+ '_=' + (new Date()).getTime());
	});
	
	$(".icon-edit").live('click', function(){
		$("#t9","#tabs").empty();
		$("#t9","#tabs").load('master_status_kel/edit'+'?id='+this.rel);
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'master_status_kel/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmasterstatuskel').trigger("reloadGrid");							
				}
				else{						
					$("#dialog").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$(".icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialog").dialog({
		  buttons : {
			"Confirm" : function() {
				deldata(myid);
				
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialog").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmasterstatuskel").getGridParam("records")>0){
		jQuery('#listmasterstatuskel').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/master_status_kel/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master2add').click(function(){
		$("#t9","#tabs").empty();
		$("#t9","#tabs").load('master_status_kel/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster3" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterstatuskel').trigger("reloadGrid");
			}
	});
		
		$( "#carimaster3" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmasterstatuskel').trigger("reloadGrid");
			}
	});
	
	$('#darimaster3').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaimaster3').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaimaster3');}});
	$('#sampaimaster3').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listmasterstatuskel').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster3").live('click', function(event){
		event.preventDefault();
		$('#formmaster3').reset();
		$('#listmasterstatuskel').trigger("reloadGrid");
	});
	$("#carimaster3").live('click', function(event){
		event.preventDefault();
		$('#listmasterstatuskel').trigger("reloadGrid");
	});
})