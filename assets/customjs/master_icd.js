jQuery().ready(function (){ 
	jQuery("#listicd").jqGrid({ 
		url:'c_master_icd/icdxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Penyakit','Kode ICD Induk','Penyakit','Description','Action'],
		rownumbers:true,
		width: 1040,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd',index:'kd', width:99}, 
				{name:'kd_icd_induk',index:'kd_icd_induk', width:99},
				{name:'penyakit',index:'penyakit', width:99},
				{name:'description',index:'description', width:99},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastericd'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#carinamamastericd').val()?$('#carinamamastericd').val():'';
				$('#listicd').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			}
	}).navGrid('#pagermastericd',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listicd .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t33","#tabs").empty();
		$("#t33","#tabs").load('c_master_icd/detail'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
	});
	
	$("#listicd .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t33","#tabs").empty();
		$("#t33","#tabs").load('c_master_icd/edit'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
                
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_icd/delete',
			  type: "post",
			  data: {kd:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogicd_new").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listicd').trigger("reloadGrid");							
				}
				else{						
					$("#dialogicd_new").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listicd .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogicd_new").dialog({
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
		
		$("#dialogicd_new").dialog("open");
	});
	
	$('form').resize(function(a) {
		if($("#listicd").getGridParam("records")>0){
		jQuery('#listicd').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_icd/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastericdadd').click(function(){
		$("#t33","#tabs").empty();
		$("#t33","#tabs").load('c_master_icd/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimastericd" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listicd').trigger("reloadGrid");
			}
	});
		
		$( "#carimastericd" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listicd').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastericd").live('click', function(event){
		event.preventDefault();
		$('#formmastericd').reset();
		$('#listicd').trigger("reloadGrid");
	});
	$("#carimastericd").live('click', function(event){
		event.preventDefault();
		$('#listicd').trigger("reloadGrid");
	});
})
