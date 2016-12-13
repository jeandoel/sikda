jQuery().ready(function (){ 
	jQuery("#listds_kematian_ibu").jqGrid({ 
		url:'t_ds_kematian_ibu/ds_kematian_ibuxml', 
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
			pager: jQuery('#pagerds_kematian_ibu'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				tahun=$('select[name=crtahunkematianibu] option:selected').text();
				carinama=$('#carinamads_kematian_ibu').val()?$('#carinamads_kematian_ibu').val():'';
				$('#listds_kematian_ibu').setGridParam({postData:{'tahun':tahun,'carinama':carinama}})
			}
	}).navGrid('#pagerds_kematian_ibu',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listds_kematian_ibu .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t808","#tabs").empty();
			$("#t808","#tabs").load('t_ds_kematian_ibu/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listds_kematian_ibu .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t808","#tabs").empty();
			$("#t808","#tabs").load('t_ds_kematian_ibu/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_ds_kematian_ibu/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogds_kematian_ibu").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listds_kematian_ibu').trigger("reloadGrid");							
				}
				else{						
					$("#dialogds_kematian_ibu").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listds_kematian_ibu .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogds_kematian_ibu").dialog({
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
		
		$("#dialogds_kematian_ibu").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listds_kematian_ibu").getGridParam("records")>0){
		jQuery('#listds_kematian_ibu').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_ds_kematian_ibu/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#ds_kematian_ibuadd').click(function(){
		$("#t808","#tabs").empty();
		$("#t808","#tabs").load('t_ds_kematian_ibu/add'+'?_=' + (new Date()).getTime());
	});
	
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetds_kematian_ibu").live('click', function(event){
		event.preventDefault();
		$('#formds_kematian_ibu').reset();
		$('#listds_kematian_ibu').trigger("reloadGrid");
	});
	$("#carids_kematian_ibu").live('click', function(event){
		event.preventDefault();
		$('#listds_kematian_ibu').trigger("reloadGrid");
	});
})