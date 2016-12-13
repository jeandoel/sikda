jQuery().ready(function (){ 
	jQuery("#listmastergigiprosedur").jqGrid({ 
		url:'c_master_gigi_prosedur/masterXml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Prosedur','Deskripsi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_prosedur_gigi',index:'kd_prosedur_gigi', width:7, align:'center'}, 
				{name:'prosedur',index:'prosedur', width:30}, 
				{name:'deskripsi',index:'deskripsi', width:50}, 
				{name:'x',index:'x', width:10,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastergigiprosedur'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kd_prosedur_gigi=$('#kodemastergigiprosedur').val()?$('#kodemastergigiprosedur').val():'';
				prosedur=$('#prosedurmastergigiprosedur').val()?$('#prosedurmastergigiprosedur').val():'';
				$('#listmastergigiprosedur').setGridParam({postData:{'kd_prosedur_gigi':kd_prosedur_gigi,'prosedur':prosedur}})
			}
	}).navGrid('#pagermastergigiprosedur',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmastergigiprosedur .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1005","#tabs").empty();				
		$("#t1005","#tabs").load('c_master_gigi_prosedur/detail'+'?kd_prosedur_gigi='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	$("#listmastergigiprosedur .icon-edit").live('click', function(p){

		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_master_gigi_prosedur/edit'+'?kd_prosedur_gigi='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_gigi_prosedur/delete',
			  type: "post",
			  data: {kd_prosedur_gigi:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmastergigiprosedur").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastergigiprosedur').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmastergigiprosedur").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastergigiprosedur .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmastergigiprosedur").dialog({
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
		
		$("#dialogmastergigiprosedur").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmastergigiprosedur").getGridParam("records")>0){
		jQuery('#listmastergigiprosedur').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastergigiprosedur/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastergigiproseduradd').click(function(){
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_master_gigi_prosedur/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#kodemastergigiprosedur" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastergigiprosedur').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastergigiprosedur").live('click', function(event){
		event.preventDefault();
		$('#formmastergigiprosedur').reset();
		$('#listmastergigiprosedur').trigger("reloadGrid");
	});
	$("#carimastergigiprosedur").live('click', function(event){
		event.preventDefault();
		$('#listmastergigiprosedur').trigger("reloadGrid");
	});
})
