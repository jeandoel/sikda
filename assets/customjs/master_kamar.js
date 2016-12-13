jQuery().ready(function (){ 
	jQuery("#listkamar").jqGrid({ 
		url:'c_master_kamar/kamarxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Unit','No Kamar','Nama Kamar','Jumlah Bed','Digunakan(kali)','Action'],
		rownumbers:true,
		width: 1040,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd',index:'kd', width:99}, 
				{name:'no_kamar',index:'no_kamar', width:99},
				{name:'nama_kamar',index:'nama_kamar', width:99},
				{name:'jumlah_bed',index:'jumlah_bed', width:99},
				{name:'digunakan',index:'digunakan', width:99},
				{name:'x',index:'x', width:110,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermasterkamar'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#carikamar').val()?$('#carikamar').val():'';
				$('#listkamar').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			}
	}).navGrid('#pagermasterkamar',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + encodeURIComponent(cellvalue) + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	$("#listkamar .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		var colid1 = $(this).closest('tr');
		var colid = colid1[0].id;
		var no_kamar = jQuery('#listkamar').jqGrid('getCell', colid, 'no_kamar');
		$("#t36","#tabs").empty();
		$("#t36","#tabs").load('c_master_kamar/detail'+'?kd='+this.rel+'&no_kamar='+no_kamar);
                }
                $(a.target).data('oneclicked','yes');
	});
	
	$("#listkamar .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
                {    
		var colid1 = $(this).closest('tr');
		var colid = colid1[0].id;
		var no_kamar = jQuery('#listkamar').jqGrid('getCell', colid, 'no_kamar');
		$("#t36","#tabs").empty();
		$("#t36","#tabs").load('c_master_kamar/edit'+'?kd='+this.rel+'&no_kamar='+no_kamar);
                }
                $(a.target).data('oneclicked','yes');
                
	});
	
	function deldata(myid,no_kamar){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_kamar/delete',
			  type: "post",
			  data: {kd:myid,no_kamar:no_kamar},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogkamar").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listkamar').trigger("reloadGrid");							
				}
				else{						
					$("#dialogkamar").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listkamar .icon-delete").live('click', function(){
		var myid= this.rel;
		var colid1 = $(this).closest('tr');
		var colid = colid1[0].id;
		var no_kamar = jQuery('#listkamar').jqGrid('getCell', colid, 'no_kamar');
		$("#dialogkamar").dialog({
                autoOpen: false,
                modal:true,
		  buttons : {
			"Confirm" : function() {
				deldata(myid,no_kamar);
				
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialogkamar").dialog("open");
	});
	
	$('form').resize(function(a) {
		if($("#listkamar").getGridParam("records")>0){
		jQuery('#listkamar').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_kamar/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterkamaradd').click(function(){
		$("#t36","#tabs").empty();
		$("#t36","#tabs").load('c_master_kamar/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimasterkamar" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listkamar').trigger("reloadGrid");
			}
	});
		
		$( "#carimasterkamar" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listkamar').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmasterkamar").live('click', function(event){
		event.preventDefault();
		$('#formmasterkamar').reset();
		$('#listkamar').trigger("reloadGrid");
	});
	$("#carimasterkamar").live('click', function(event){
		event.preventDefault();
		$('#listkamar').trigger("reloadGrid");
	});
})
