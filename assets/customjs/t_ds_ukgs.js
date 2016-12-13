jQuery().ready(function (){ 
	jQuery("#listds_ukgs").jqGrid({ 
		url:'t_ds_ukgs/ds_ukgsxml', 
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
			pager: jQuery('#pagerds_ukgs'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				tahun=$('select[name=crtahunukgs] option:selected').text();
				carinama=$('#carinamads_ukgs').val()?$('#carinamads_ukgs').val():'';
				$('#listds_ukgs').setGridParam({postData:{'tahun':tahun,'carinama':carinama}})
			}
	}).navGrid('#pagerds_ukgs',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listds_ukgs .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t812","#tabs").empty();
			$("#t812","#tabs").load('t_ds_ukgs/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listds_ukgs .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t812","#tabs").empty();
			$("#t812","#tabs").load('t_ds_ukgs/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_ds_ukgs/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogds_ukgs").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listds_ukgs').trigger("reloadGrid");							
				}
				else{						
					$("#dialogds_ukgs").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listds_ukgs .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogds_ukgs").dialog({
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
		
		$("#dialogds_ukgs").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listds_ukgs").getGridParam("records")>0){
		jQuery('#listds_ukgs').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_ds_ukgs/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#ds_ukgsadd').click(function(){
		$("#t812","#tabs").empty();
		$("#t812","#tabs").load('t_ds_ukgs/add'+'?_=' + (new Date()).getTime());
	});
	
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetds_ukgs").live('click', function(event){
		event.preventDefault();
		$('#formds_ukgs').reset();
		$('#listds_ukgs').trigger("reloadGrid");
	});
	$("#carids_ukgs").live('click', function(event){
		event.preventDefault();
		$('#listds_ukgs').trigger("reloadGrid");
	});
})