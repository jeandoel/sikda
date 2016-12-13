jQuery().ready(function (){ 
	jQuery("#listtkasir").jqGrid({ 
		url:'t_kasir/t_kasirxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode Transaksi','Status','Rekam Medis','Nama Lengkap','No Pengenal','kd pasien','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50}, 			
				{name:'status',index:'status', width:50}, 
				{name:'rekam_medis',index:'rekam_medis', width:50}, 
				{name:'nama_lengkap',index:'nama_lengkap', width:50}, 
				{name:'no_pengenal',index:'no_pengenal', width:50}, 
				{name:'kd_pasien',index:'kd_pasien', width:50, hidden:false},
				{name:'myid',index:'myid', width:50,align:'center',formatter:formatterlisttransaksi}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagertkasir'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				statusx=$('#statusidx').val()?$('#statusidx').val():'';
				cari=$('#carikasir').val()?$('#carikasir').val():'';
				$('#listtkasir').setGridParam({postData:{'keyword':keyword,'cari':cari,'status':statusx}})
			},
	}).navGrid('#pagertkasir',{edit:false,add:false,del:false,search:false});
	
	function formatterlisttransaksi(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="'+cellvalue+'" class="lab-green">Lihat Transaksi</a>';
		return content;
	}
	$("#listtkasir .lab-green").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listtkasir").find('.lab-green').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listtkasir").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listtkasir').jqGrid('getCell', colid, 'id');
						var myCellDataId2 = jQuery('#listtkasir').jqGrid('getCell', colid, 'kd_pasien');
						$("#t205","#tabs").empty();
						$("#t205","#tabs").load('t_kasir/listtransaksikasir'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	$("#listtkasir .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t41","#tabs").empty();
			$("#t41","#tabs").load('t_kasir/detail'+'?kodeagama='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listtkasir .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t41","#tabs").empty();
			$("#t41","#tabs").load('t_kasir/edit'+'?kodeagama='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_kasir/delete',
			  type: "post",
			  data: {kodeagama:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogagama").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listtkasir').trigger("reloadGrid");							
				}
				else{						
					$("#dialogagama").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listtkasir .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogagama").dialog({
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
		
		$("#dialogagama").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listtkasir").getGridParam("records")>0){
		jQuery('#listtkasir').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_kasir/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#tkasir_add').click(function(){
		$("#t41","#tabs").empty();
		$("#t41","#tabs").load('t_kasir/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaitkasir" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listtkasir').trigger("reloadGrid");
			}			
	});
	
	$( "#kodeagamatkasir" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listtkasir').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resettkasir").live('click', function(event){
		event.preventDefault();
		$('#formtkasir').reset();
		$('#listtkasir').trigger("reloadGrid");
	});
	$("#caritkasir").live('click', function(event){
		event.preventDefault();
		$('#listtkasir').trigger("reloadGrid");
	});
})