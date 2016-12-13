jQuery().ready(function (){ 
	jQuery("#listmaster_cara_masuk_pasien").jqGrid({ 
		url:'c_master_cara_masuk_pasien/caramasukpasienxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD CARA MASUK','Kode Cara Masuk','Cara Masuk','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[  
				{name:'id',index:'id', width:50, hidden:true}, 		
				{name:'kodecaramasuk',index:'kodecaramasuk', width:30}, 
				{name:'caramasuk',index:'caramasuk', width:50}, 
				{name:'myid',index:'myid', width:15,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagermaster_cara_masuk_pasien'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				carimasukpasien=$('#caripasienmasuk').val()?$('#caripasienmasuk').val():'';
				$('#listmaster_cara_masuk_pasien').setGridParam({postData:{'carimasukpasien':carimasukpasien}})
			}
	}).navGrid('#pagermaster_cara_masuk_pasien',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listmaster_cara_masuk_pasien .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t55","#tabs").empty();
			$("#t55","#tabs").load('c_master_cara_masuk_pasien/detail'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listmaster_cara_masuk_pasien .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t55","#tabs").empty();
			$("#t55","#tabs").load('c_master_cara_masuk_pasien/edit'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_master_cara_masuk_pasien/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogcaramasukpasien").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listmaster_cara_masuk_pasien').trigger("reloadGrid");							
				}
				else{						
					$("#dialogcaramasukpasien").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listmaster_cara_masuk_pasien .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogcaramasukpasien").dialog({
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
		
		$("#dialogcaramasukpasien").dialog("open");
	});
	
	$('form').resize(function(g) {
		if($("#listmaster_cara_masuk_pasien").getGridParam("records")>0){
		jQuery('#listmaster_cara_masuk_pasien').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_master_cara_masuk_pasien/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#master_cara_masuk_pasien_add').click(function(){
		$("#t55","#tabs").empty();
		$("#t55","#tabs").load('c_master_cara_masuk_pasien/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaimaster_cara_masuk_pasien" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_cara_masuk_pasien').trigger("reloadGrid");
			}			
	});
	
	$( "#caripasienmasuk" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listmaster_cara_masuk_pasien').trigger("reloadGrid");
			}			
	});

	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetmaster_cara_masuk_pasien").live('click', function(event){
		event.preventDefault();
		$('#formmaster_cara_masuk_pasien').reset();
		$('#listmaster_cara_masuk_pasien').trigger("reloadGrid");
	});
	$("#carimaster_cara_masuk_pasien").live('click', function(event){
		event.preventDefault();
		$('#listmaster_cara_masuk_pasien').trigger("reloadGrid");
	});
})