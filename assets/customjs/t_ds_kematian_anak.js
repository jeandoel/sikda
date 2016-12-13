jQuery().ready(function (){ 
	jQuery("#listds_kematian_anak").jqGrid({ 
		url:'t_ds_kematian_anak/ds_kematian_anakxml', 
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
			pager: jQuery('#pagerds_kematian_anak'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				tahun=$('select[name=crtahunkematiananak] option:selected').text();
				carinama=$('#carinamads_kematian_anak').val()?$('#carinamads_kematian_anak').val():'';
				$('#listds_kematian_anak').setGridParam({postData:{'tahun':tahun,'carinama':carinama}})
			}
	}).navGrid('#pagerds_kematian_anak',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listds_kematian_anak .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t809","#tabs").empty();
			$("#t809","#tabs").load('t_ds_kematian_anak/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listds_kematian_anak .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t809","#tabs").empty();
			$("#t809","#tabs").load('t_ds_kematian_anak/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_ds_kematian_anak/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogds_kematian_anak").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listds_kematian_anak').trigger("reloadGrid");							
				}
				else{						
					$("#dialogds_kematian_anak").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listds_kematian_anak .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogds_kematian_anak").dialog({
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
		
		$("#dialogds_kematian_anak").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listds_kematian_anak").getGridParam("records")>0){
		jQuery('#listds_kematian_anak').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_ds_kematian_anak/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#ds_kematian_anakadd').click(function(){
		$("#t809","#tabs").empty();
		$("#t809","#tabs").load('t_ds_kematian_anak/add'+'?_=' + (new Date()).getTime());
	});
	
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetds_kematian_anak").live('click', function(event){
		event.preventDefault();
		$('#formds_kematian_anak').reset();
		$('#listds_kematian_anak').trigger("reloadGrid");
	});
	$("#carids_kematian_anak").live('click', function(event){
		event.preventDefault();
		$('#listds_kematian_anak').trigger("reloadGrid");
	});
})