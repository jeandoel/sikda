jQuery().ready(function (){ 
	jQuery("#listds_uks").jqGrid({ 
		url:'t_ds_uks/ds_uksxml', 
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
			pager: jQuery('#pagerds_uks'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				tahun=$('select[name=crtahun_uks] option:selected').text();
				carinama=$('#carinamads_uks').val()?$('#carinamads_uks').val():'';
				$('#listds_uks').setGridParam({postData:{'tahun':tahun,'carinama':carinama}})
			}
	}).navGrid('#pagerds_uks',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listds_uks .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t806","#tabs").empty();
			$("#t806","#tabs").load('t_ds_uks/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listds_uks .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t806","#tabs").empty();
			$("#t806","#tabs").load('t_ds_uks/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_ds_uks/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogds_uks").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listds_uks').trigger("reloadGrid");							
				}
				else{						
					$("#dialogds_uks").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listds_uks .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogds_uks").dialog({
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
		
		$("#dialogds_uks").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listds_uks").getGridParam("records")>0){
		jQuery('#listds_uks').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_ds_uks/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#ds_uksadd').click(function(){
		$("#t806","#tabs").empty();
		$("#t806","#tabs").load('t_ds_uks/add'+'?_=' + (new Date()).getTime());
	});
	
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetds_uks").live('click', function(event){
		event.preventDefault();
		$('#formds_uks').reset();
		$('#listds_uks').trigger("reloadGrid");
	});
	$("#carids_uks").live('click', function(event){
		event.preventDefault();
		$('#listds_uks').trigger("reloadGrid");
	});
})