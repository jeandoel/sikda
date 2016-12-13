jQuery().ready(function (){ 
	jQuery("#listretribusi").jqGrid({ 
		url:'c_master_retribusi/retribusixml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Puskesmas','Kode Puskesmas','Kode Kecamatan','Puskesmas','Alamat','Nilai Retribusi','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:90,hidden:true}, 
				{name:'kodepuskesmas',index:'kodepuskesmas', width:80}, 
				{name:'kodekecamatan',index:'kodekecamatan', width:80}, 
				{name:'namapuskesmas',index:'namapuskesmas', width:90},
				{name:'alamat',index:'alamat', width:120},
				{name:'nilairetribusi',index:'nilairetribusi', width:80},
				{name:'x',index:'x', width:70,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagerretribusi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				nama=$('#namaretribusi').val()?$('#namaretribusi').val():'';
				$('#listretribusi').setGridParam({postData:{'nama':nama}})
			}
	}).navGrid('#pagerretribusi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listretribusi .icon-detail").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t900","#tabs").empty();
			$("#t900","#tabs").load('c_master_retribusi/detail'+'?kd_retribusi='+this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	$("#listretribusi .icon-edit").live('click', function(a){
		if($(a.target).data('oneclicked')!='yes')
		{
			$("#t900","#tabs").empty();
			$("#t900","#tabs").load('c_master_retribusi/edit'+'?kd_retribusi='+this.rel);
		}
		$(a.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_retribusi/delete',
			  type: "post",
			  data: {kd_retribusi:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogretribusi").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listretribusi').trigger("reloadGrid");							
				}
				else{						
					$("#dialogretribusi").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listretribusi .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogretribusi").dialog({
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
		
		$("#dialogretribusi").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listretribusi").getGridParam("records")>0){
		jQuery('#listretribusi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/puskesmas/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#masterretribusiadd').click(function(){
		$("#t900","#tabs").empty();
		$("#t900","#tabs").load('c_master_retribusi/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#namaretribusi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listretribusi').trigger("reloadGrid");
			}
	});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetretribusi").live('click', function(event){
		event.preventDefault();
		$('#formretribusi').reset();
		$('#listretribusi').trigger("reloadGrid");
	});
	$("#cariretribusi").live('click', function(event){
		event.preventDefault();
		$('#listretribusi').trigger("reloadGrid");
	});
})
