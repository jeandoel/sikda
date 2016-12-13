jQuery().ready(function (){ 
	jQuery("#listds_kb").jqGrid({ 
		url:'t_ds_kb/ds_kbxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['id','Kelurahan','Kecamatan','Puskesmas','Bulan','Tahun','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:25,align:'center',hidden:true}, 
				{name:'kel',index:'kel', width:75}, 
				{name:'kec',index:'kec', width:75,align:'center'}, 
				{name:'puskes',index:'puskes', width:75,align:'center'}, 
				{name:'bulan',index:'bulan', width:35,align:'center'}, 
				{name:'tahun',index:'tahun', width:35,align:'center'}, 
				{name:'myid',index:'myid', width:91,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerds_kb'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				tahun=$('select[name=crtahunkb] option:selected').text();
				carinama=$('#carinamads_kb').val()?$('#carinamads_kb').val():'';
				$('#listds_kb').setGridParam({postData:{'tahun':tahun,'carinama':carinama}})
			}
	}).navGrid('#pagerds_kb',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listds_kb .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t804","#tabs").empty();
			$("#t804","#tabs").load('t_ds_kb/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listds_kb .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t804","#tabs").empty();
			$("#t804","#tabs").load('t_ds_kb/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_ds_kb/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogds_kb").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listds_kb').trigger("reloadGrid");							
				}
				else{						
					$("#dialogds_kb").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listds_kb .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogds_kb").dialog({
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
		
		$("#dialogds_kb").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listds_kb").getGridParam("records")>0){
		jQuery('#listds_kb').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_ds_kb/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#ds_kbadd').click(function(){
		$("#t804","#tabs").empty();
		$("#t804","#tabs").load('t_ds_kb/add'+'?_=' + (new Date()).getTime());
	});
	
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetds_kb").live('click', function(event){
		event.preventDefault();
		$('#formds_kb').reset();
		$('#listds_kb').trigger("reloadGrid");
	});
	$("#carids_kb").live('click', function(event){
		event.preventDefault();
		$('#listds_kb').trigger("reloadGrid");
	});
})