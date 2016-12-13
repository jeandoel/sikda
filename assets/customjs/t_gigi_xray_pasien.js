jQuery().ready(function (){ 
	jQuery("#listt_gigi").jqGrid({ 
		url:'t_gigi_pasien/masterXml/t_gigi_xray_model', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Kode','Waktu', 'Gambar','Action'],
		// rownumbers:true,
		width: 580,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'kd_foto_gigi',index:'kd_foto_gigi',  hidden:true, width:10}, 
				{name:'tanggal',index:'tanggal',width:30},  
				{name:'gambar',index:'gambar', width:40},
				{name:'x',index:'x', width:20,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_gigi'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				tanggal=$('#kodet_gigi').val()?$('#kodet_gigi').val():'';
		  		var puskesmas = $("#get_puskesmas_id").attr('value');
		  		var pasien = $("#get_pasien_id").attr('value');

				$('#listt_gigi').setGridParam({postData:{'tanggal':tanggal, 'pasien':pasien, 'puskesmas':puskesmas}})
			},
			onSelectRow:function(){
				var grid = jQuery('#listt_gigi');
				var sel_id = grid.jqGrid('getGridParam', 'selrow');
				var myCellData = grid.jqGrid('getCell', sel_id, 'gambar');

				var img = new Image();
				if (!Date.now) {
				    timestamp = Date().getTime();
				}else{
					timestamp = Date.now();
				}
				img.src = './assets/images/gigi_pasien/xray/'+myCellData+"?"+timestamp;
				img.width = 400;
				img.height = 350;
				
				$('#main_form_gigi_pasien').hide();
				$("#main_foto").html(img);
			},
			gridComplete:function(){
				$("#main_form_gigi_pasien").hide();
				$(this).find("tbody tr:eq(1)").trigger("click");

				var count_record = jQuery('#listt_gigi').jqGrid('getGridParam', 'reccount');
				if(!count_record){
					$("#no_record_foto").show();
				}
			}
	}).navGrid('#pagert_gigi',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	function formatterImageGigi(cellValue, options, rowObject){
		var content = '';
		content += '<img src="./assets/images/gigi_pasien/xray/'+cellValue+'" width="400"/>';
		return content;
	}

	function edit_xray_gigi(){
		var post_url = $("#formgigimastergigiedit").attr("action");
		var formData = new FormData($("#formgigimastergigiedit").get(0));

		achtungShowLoader();
		$.ajax({
			url:post_url,
			type:"POST",
			data:formData,
			cache:false,
			contentType:false,
			processData:false,
			success:function(data, status, xhr){
				achtungHideLoader();
				var errorcode = xhr.getResponseHeader("error_code");
				var warning = xhr.getResponseHeader("warning");
				if(errorcode=="0"){ 
					// $('#listt_gigi').trigger( 'reloadGrid' );
					$("#dialogt_gigi").dialog("close");
					var url = getPathFromUrl($("#main_foto img").attr("src"));
					if (!Date.now) {
					    var timestamp = Date().getTime();
					}else{
					  	var timestamp = Date.now();
					}
					$("#main_foto img").attr("src",url+"?"+timestamp)
					$('#formgigimastergigiedit').reset();
					$("#main_form_gigi_pasien").hide();
				}
				achtungCreate(warning);
			}
		})
	}

	$("#listt_gigi .icon-edit").live('click', function(p){
		$(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.ui-resizable.ui-dialog-buttons").remove();
		$(this).parents("tr.jqgrow:eq(0)").trigger("click");
		

		$('#dialogt_gigi').attr('Title','Edit Foto X-Ray Gigi');

		$('#ins_dialogt_gigi').show();	
		$('#del_dialogt_gigi').hide();
		$("#ins_dialogt_gigi").load('t_gigi_pasien/edit/'+'?kd_foto_gigi='+this.rel);       

		$("#dialogt_gigi").dialog({
		  autoOpen: false,
		  width:360,
          modal:true,
		  buttons : {
		  	"Process" : function(){
		  		edit_xray_gigi();
		  	},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});		
		$("#dialogt_gigi").dialog("open");	
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_gigi_pasien/delete/xray',
			  type: "post",
			  data: {kd_foto_gigi:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogt_gigi").dialog("close");
					achtungCreate('Proses Hapus Data Berhasil');
					$('#listt_gigi').trigger("reloadGrid");							
				}
				else{						
					$("#dialogt_gigi").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listt_gigi .icon-delete").live('click', function(){
		$(this).parents("tr.jqgrow:eq(0)").trigger("click");
		$('#del_dialogt_gigi').show();
		$('#ins_dialogt_gigi').hide();
		var myid= this.rel;
		$("#dialogt_gigi").dialog({
		  autoOpen: false,
          modal:true,
		  buttons : {
			"Confirm" : function() {
				deldata(myid);
				$('#main_foto').html('');
			},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialogt_gigi").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listt_gigi").getGridParam("records")>0){
		// jQuery('#listt_gigi').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_gigi_pasien/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$( "#kodet_gigi" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listt_gigi').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_gigi").live('click', function(event){
		event.preventDefault();
		$('#formt_gigi').reset();
		$('#listt_gigi').trigger("reloadGrid");
	});
	$("#carit_gigi").live('click', function(event){
		event.preventDefault();
		$('#listt_gigi').trigger("reloadGrid");
	});



	function add_xray_gigi(){
		var post_url = $("#formgigifotogigipasienadd").attr("action");
		var formData = new FormData($("#formgigifotogigipasienadd").get(0));

		achtungShowLoader();
		$.ajax({
			url:post_url,
			type:"POST",
			data:formData,
			cache:false,
			contentType:false,
			processData:false,
			success:function(data, status, xhr){
				achtungHideLoader();
				var errorcode = xhr.getResponseHeader("error_code");
				var warning = xhr.getResponseHeader("warning");
				if(errorcode=="0"){ 
					$("#dialogt_gigi").dialog("close");	
					$('#listt_gigi').trigger( 'reloadGrid' );
					$('#formgigifotogigipasienadd').reset();
				}
				achtungCreate(warning);
			}
		})
	}

	$('#t_gigiadd').click(function(){
		$(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.ui-resizable.ui-dialog-buttons").remove();
		var puskesmas = $("#get_puskesmas_id").val();
		var pasien = $("#get_pasien_id").val();

		// $("#main_form_gigi_pasien").load('t_gigi_pasien/add/2/X-Ray'+'?_='+(new Date()).getTime()+'&kd_pasien='+pasien+'&kd_puskesmas='+puskesmas);
		// $('#main_form_gigi_pasien').show();
	
		$('#dialogt_gigi').attr('Title','Tambah Foto X-Ray Gigi');

		$('#del_dialogt_gigi').hide();
		$('#ins_dialogt_gigi').show();
		$("#ins_dialogt_gigi").load('t_gigi_pasien/add/2/X-Ray'+'?_='+(new Date()).getTime()+'&kd_pasien='+pasien+'&kd_puskesmas='+puskesmas);
		$("#dialogt_gigi").dialog({
		  autoOpen: false,
	   		width:335,
          modal:true,
		  buttons : {
		  	"Process" : function(){
		  		add_xray_gigi();
		  	},
			"Cancel" : function() {
			  $(this).dialog("close");
			}
		  }
		});
		
		$("#dialogt_gigi").dialog("open");
	})	
	// $("#t_gigiadd").trigger("click");
})
