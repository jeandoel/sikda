jQuery().ready(function (){ 
	jQuery("#listmastergigipermukaan").jqGrid({ 
		url:'c_master_gigi_permukaan/masterXml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID', 'Kode', 'Nama', 'Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_gigi_permukaan',index:'kd_gigi_permukaan', width:7, align:"center", hidden:true}, 
				{name:'kode',index:'kode', width:15, align:"center"},
				{name:'nama',index:'nama', width:40}, 
				{name:'x',index:'x', width:10,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastergigipermukaan'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				kode = $("#kodemastergigipermukaan").val()?$("#kodemastergigipermukaan").val():'';
				nama_gigi = $("#namamastergigipermukaan").val()?$("#namamastergigipermukaan").val():'';
				$('#listmastergigipermukaan').setGridParam({postData:{'kode':kode, 'nama':nama_gigi}})
			}
	}).navGrid('#pagermastergigipermukaan',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	function formatterImageGigi(cellValue, options, rowObject){
		var content = '';
		content += '<img src="./assets/images/gigi_master/'+cellValue+'" width="30" height="39"/>';
		return content;
	}
	
	$("#listmastergigipermukaan .icon-detail").live('click', function(p){
		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1004","#tabs").empty();
		$("#t1004","#tabs").load('c_master_gigi_permukaan/detail'+'?kd_gigi_permukaan='+this.rel);
		}	

		$(p.target).data('oneclicked','yes');
	});
	
	$("#listmastergigipermukaan .icon-edit").live('click', function(p){

		if($(p.target).data('oneclicked')!='yes')
		{
		$("#t1004","#tabs").empty();
		$("#t1004","#tabs").load('c_master_gigi_permukaan/edit'+'?kd_gigi_permukaan='+this.rel);
		}
		$(p.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_gigi_permukaan/delete',
			  type: "post",
			  data: {kd_gigi_permukaan:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogmastergigipermukaan").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmastergigipermukaan').trigger("reloadGrid");							
				}
				else{						
					$("#dialogmastergigipermukaan").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmastergigipermukaan .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogmastergigipermukaan").dialog({
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
		
		$("#dialogmastergigipermukaan").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listmastergigipermukaan").getGridParam("records")>0){
		jQuery('#listmastergigipermukaan').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/mastergigipermukaan/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastergigipermukaanadd').click(function(){
		$("#t1004","#tabs").empty();
		$("#t1004","#tabs").load('c_master_gigi_permukaan/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#kodemastergigipermukaan" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmastergigipermukaan').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastergigipermukaan").live('click', function(event){
		event.preventDefault();
		$('#formmastergigipermukaan').reset();
		$('#listmastergigipermukaan').trigger("reloadGrid");
	});
	$("#carimastergigipermukaan").live('click', function(event){
		event.preventDefault();
		$('#listmastergigipermukaan').trigger("reloadGrid");
	});
})
