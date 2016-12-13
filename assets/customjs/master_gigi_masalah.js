jQuery().ready(function (){ 
	jQuery("#listmastergigimasalah").jqGrid({ 
		url:'c_master_gigi_masalah/masterXml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','masalah','Deskripsi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_masalah_gigi',index:'kd_masalah_gigi', width:7, align:'center'}, 
				{name:'masalah',index:'masalah', width:30}, 
				{name:'deskripsi',index:'deskripsi', width:50}, 
				{name:'x',index:'x', width:10,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastergigimasalah'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_masalah_gigi=$('#kodemastergigimasalah').val()?$('#kodemastergigimasalah').val():'';
				masalah=$('#masalahmastergigimasalah').val()?$('#masalahmastergigimasalah').val():'';
				$('#listmastergigimasalah').setGridParam({postData:{'kd_masalah_gigi':kd_masalah_gigi,'masalah':masalah}})
			}
	}).navGrid('#pagermastergigimasalah',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmastergigimasalah .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1002","#tabs").empty();				
		$("#t1002","#tabs").load('c_master_gigi_masalah/detail'+'?kd_masalah_gigi='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	$("#listmastergigimasalah .icon-edit").live('click', function(p){

		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1002","#tabs").empty();
		$("#t1002","#tabs").load('c_master_gigi_masalah/edit'+'?kd_masalah_gigi='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_gigi_masalah/delete',
			  type: "post",
			  data: {kd_masalah_gigi:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmastergigimasalah").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastergigimasalah').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmastergigimasalah").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastergigimasalah .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmastergigimasalah").dialog({
		  autoOpen: false,
          modal:true,
		  buttons : {
			"Confirm" : function() {
				deldata(myid);
				
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialogmastergigimasalah").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmastergigimasalah").getGridParam("records")>0){
		jQuery('#listmastergigimasalah').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastergigimasalah/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastergigimasalahadd').click(function(){
		$("#t1002","#tabs").empty();
		$("#t1002","#tabs").load('c_master_gigi_masalah/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#masalahmastergigimasalah" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastergigimasalah').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastergigimasalah").live('click', function(event){
		event.preventDefault();
		$('#formmastergigimasalah').reset();
		$('#listmastergigimasalah').trigger("reloadGrid");
	});
	$("#carimastergigimasalah").live('click', function(event){
		event.preventDefault();
		$('#listmastergigimasalah').trigger("reloadGrid");
	});
})
