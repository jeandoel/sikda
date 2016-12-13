jQuery().ready(function (){ 
	jQuery("#listsysSettingdef").jqGrid({ 
		url:'c_sys_setting_def/syssettingdefxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['KD','id1','Provinsi','Kabupaten/Kota','Kecamatan','Kd Puskesmas','Nama Puskesmas','Nama Kep. Puskesmas','NIP','Alamat','Agama','Level','Server Kemkes','Server Provinsi','Server Kabupaten/Kota','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:20,align:'center',fixed:true}, 
				{name:'id1',index:'id1', width:15,align:'center',hidden:true}, 
				{name:'prov',index:'prov', width:75,fixed:true}, 
				{name:'kabkot',index:'kabkot', width:100,fixed:true}, 
				{name:'kec',index:'kec', width:75,fixed:true}, 
				{name:'kdpus',index:'kdpus', width:100,fixed:true}, 
				{name:'napus',index:'napus', width:100,fixed:true}, 
				{name:'napim',index:'napim', width:130,fixed:true}, 
				{name:'nipp',index:'nipp', width:100,fixed:true}, 
				{name:'alma',index:'alma', width:100,fixed:true}, 
				{name:'agam',index:'agam', width:50,fixed:true,hidden:true}, 
				{name:'lev',index:'lev', width:100,fixed:true}, 
				{name:'sdm',index:'sdm', width:100,fixed:true}, 
				{name:'sdp',index:'sdp', width:100,fixed:true}, 
				{name:'sdk',index:'sdk', width:125,fixed:true}, 
				{name:'myid',index:'myid', width:135,align:'center',formatter:formatterAction,fixed:true}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagersysSettingdef'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#darisysSettingdef').val()?$('#darisysSettingdef').val():'';
				sampai=$('#sampaisysSettingdef').val()?$('#sampaisysSettingdef').val():'';
				keyword=$('#keywordsysSettingdef').val()?$('#keywordsysSettingdef').val():'';
				carinama=$('#carinamasysSettingdef').val()?$('#carinamasysSettingdef').val():'';
				$('#listsysSettingdef').setGridParam({postData:{'dari':dari,'sampai':sampai,'keyword':keyword,'carinama':carinama}})
			}
	}).navGrid('#pagersysSettingdef',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail"  title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	
	$("#listsysSettingdef .icon-detail").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t30","#tabs").empty();
			$("#t30","#tabs").load('c_sys_setting_def/detail'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');
	});
	
	$("#listsysSettingdef .icon-edit").live('click', function(f){
		if($(f.target).data('oneclicked')!='yes')
		{
			$("#t30","#tabs").empty();
			$("#t30","#tabs").load('c_sys_setting_def/edit'+'?id='+this.rel);
		}
		$(f.target).data('oneclicked','yes');		
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 'c_sys_setting_def/delete',
			  type: "post",
			  data: {id:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogsysSettingdef").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listsysSettingdef').trigger("reloadGrid");							
				}
				else{						
					$("#dialogsysSettingdef").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listsysSettingdef .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogsysSettingdef").dialog({
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
		
		$("#dialogsysSettingdef").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listsysSettingdef").getGridParam("records")>0){
		jQuery('#listsysSettingdef').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/c_sys_setting_def/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$('#sysSettingdefadd').click(function(){
		$("#t30","#tabs").empty();
		$("#t30","#tabs").load('c_sys_setting_def/add'+'?_=' + (new Date()).getTime());
	});
	
	$( "#sampaisysSettingdef" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listsysSettingdef').trigger("reloadGrid");
			}
	});
	
	$('#darisysSettingdef').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onSelect: function(dateText, inst){$('#sampaisysSettingdef').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampaisysSettingdef');}});
	$('#sampaisysSettingdef').datepicker({dateFormat: "dd-mm-yy",changeYear: true,onClose: function(dateText, inst){$('#listsysSettingdef').trigger("reloadGrid");}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetsysSettingdef").live('click', function(event){
		event.preventDefault();
		$('#formsysSettingdef').reset();
		$('#listsysSettingdef').trigger("reloadGrid");
	});
	$("#carisysSettingdef").live('click', function(event){
		event.preventDefault();
		$('#listsysSettingdef').trigger("reloadGrid");
	});
})