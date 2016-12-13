jQuery().ready(function (){ 
	jQuery("#listgoldarah").jqGrid({ 
		url:'c_master_gol_darah/goldarahxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Gol Darah','Golongan Darah','Action'],
		rownumbers:true,
		width: 1040,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd',index:'kd', width:99}, 
				{name:'gol_darah',index:'gol_darah', width:99},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermastergd'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#carigd').val()?$('#carigd').val():'';
				$('#listgoldarah').setGridParam({postData:{'keyword':'KD_GOL_DARAH','cari':cari}})
			}
	}).navGrid('#pagermastergd',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listgoldarah .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t32","#tabs").empty();
		$("#t32","#tabs").load('c_master_gol_darah/detail'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
	});
	
	$("#listgoldarah .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		$("#t32","#tabs").empty();
		$("#t32","#tabs").load('c_master_gol_darah/edit'+'?kd='+this.rel);
                }
                $(a.target).data('oneclicked','yes');
                
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_gol_darah/delete',
			  type: "post",
			  data: {kd:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialoggoldarah").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listgoldarah').trigger("reloadGrid");							
				}
				else{						
					$("#dialoggoldarah").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listgoldarah .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialoggoldarah").dialog({
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
		
		$("#dialoggoldarah").dialog("open");
	});
	
	$('form').resize(function(a) {
		if($("#listgoldarah").getGridParam("records")>0){
		jQuery('#listgoldarah').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_gol_darah/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#mastergdadd').click(function(){
		$("#t32","#tabs").empty();
		$("#t32","#tabs").load('c_master_gol_darah/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimastergd" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listgoldarah').trigger("reloadGrid");
			}
	});
		
		$( "#carimastergd" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listgoldarah').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmastergd").live('click', function(event){
		event.preventDefault();
		$('#formmastergd').reset();
		$('#listgoldarah').trigger("reloadGrid");
	});
	$("#carimastergd").live('click', function(event){
		event.preventDefault();
		$('#listgoldarah').trigger("reloadGrid");
	});
})