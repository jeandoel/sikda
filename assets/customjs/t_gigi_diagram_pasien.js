jQuery().ready(function (){ 
	jQuery("#listt_diagram").jqGrid({ 
		url:'t_gigi_diagram_pasien/masterXml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['ID','Tanggal','Nomenklatur','Kode Status','Status','Diagnosa','Tindakan','Catatan','Dokter', 'Petugas','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id',  hidden:true}, 
				{name:'tanggal',index:'tanggal',width:6, align:'center',formatter:'date', formatoptions: { srcformat: 'Y-m-d', newformat: 'd/m/Y'}},
				{name:'kd_gigi',index:'kd_gigi',width:6, align:'center'},
				{name:'kd_status_gigi',index:'kd_status_gigi',width:6},  
				{name:'status',index:'status',width:10},  
				{name:'kd_masalah_gigi',index:'kd_masalah_gigi',width:10},  
				{name:'kd_prosedur_gigi',index:'kd_prosedur_gigi',width:10},   
				{name:'note',index:'note', width:10, formatter:formatterNote}, 
				{name:'kd_dokter',index:'kd_dokter',width:7, align:'center'}, 
				{name:'kd_petugas',index:'kd_petugas',width:4, align:'center'}, 
				{name:'x',index:'x', width:5,align:'center',formatter:formatterAction}
			],
			rowNum:10, 
			rowList:[10,20,30], 
			pager: jQuery('#pagert_diagram'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				// var highlighted_id = $("#main_diagram_gigi .highlighted").attr("id");
				// $("#nomor_gigi_hid").val(highlighted_id);
				var tanggal=$('#cari_sebelum_tanggal').val()?$('#cari_sebelum_tanggal').val():'';
				var nomor_gigi = $("#nomor_gigi_hid").val()?$("#nomor_gigi_hid").val():'';

	  			var puskesmas = $("#get_puskesmas_id").attr('value');
		  		var pasien = $("#get_pasien_id").attr('value');

				$('#listt_diagram').setGridParam({postData:{'tanggal':tanggal,'nomor':nomor_gigi,'pasien':pasien,'puskesmas':puskesmas}})
			}
	}).navGrid('#pagert_diagram',{edit:false,add:false,del:false,search:false});
				console.clear();
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	function formatterImageGigi(cellValue, options, rowObject){
		var content = '';
		content += '<img src="./assets/images/gigi_pasien/oral/'+cellValue+'" width="400"/>';
		return content;
	}
	function formatterNote(cellValue, options, rowObject){
		if(!cellValue){
			substred = '';
		}else{
			var substred = cellValue.substring(0,40);
			if(cellValue.length>40){
				substred += '...';
			}
		}
		return '<div title="'+cellValue+'">'+substred+'</div>';
	}

	$("#listt_diagram .icon-edit").live('click', function(p){
		$(".ui-dialog.ui-widget.ui-widget-content.ui-corner-all.ui-draggable.ui-resizable.ui-dialog-buttons").remove();
		// $(this).parents("tr.jqgrow:eq(0)").trigger("click");
		var myid = this.rel;

		var pasien = $("#get_pasien_id").attr("value");
		var puskesmas = $("#get_puskesmas_id").attr("value");
		$('.has_record input').prop("disabled", false);
		$('.has_record textarea').prop("disabled", false);
		$('#kd_dokter_gigi_id').prop("disabled", false);
		$.ajax({
			url:"t_gigi_diagram_pasien/data_gigi",
			type:"POST",
			cache:false,
			data:"id_transaksi_perawatan="+myid+"&kd_pasien="+pasien+"&kd_puskesmas="+puskesmas,
			success:function(msg){
				// console.log(msg);
				// return false;
				msg = $.parseJSON(msg);
				if(!$.isEmptyObject(msg)){
					showDialogForm();
					$("#main_transaksi_id").val(msg.main_transaksi_id);
					$("#tanggal").val(msg.tanggal);	

					$("#master_gigi_id_hidden").val(msg.kode_gigi);
					$("#master_gigi_id").val(msg.kode_n_gigi);

					$("#kd_map_id").val(msg.kode_map_id);
					$("#master_gigi_status_id_hidden").val(msg.kode_status);
					$("#master_output_status").val(msg.kode_output_status)			
					$("#master_gigi_status_id").val(msg.kode_n_status);			

					$("#kd_penyakit_id").val(msg.kode_penyakit);
					$("#kd_icd_induk_id").val(msg.kode_icd_induk);
					$("#nama_penyakit").val(msg.kode_n_penyakit);

					$("#master_gigi_tindakan_id").val(msg.kode_produk);
					$("#tindakan_gigi").val(msg.kode_n_produk);

					$("#kd_dokter_gigi_id").val(msg.kode_dokter);
					$("#note_text_area").val(msg.note);

					if(msg.akar_gigi == 1){
						$("#akar_gigi_ya").prop("checked",true);
						$("#akar_gigi_tidak").prop("checked",false);
					}else{
						$("#akar_gigi_ya").prop("checked",false);
						$("#akar_gigi_tidak").prop("checked",true);
					}
				}else{
					$("#dialogmastergigi").siblings(".ui-dialog-buttonpane.ui-widget-content.ui-helper-clearfix").hide();
					$("#dialogmastergigi .has_record").hide();
					$("#dialogmastergigi .no_record").show();
				}
			}
		})

		$("#dialogmastergigi").dialog({
		  autoOpen: false,
          modal:true,
          width:450,
		  buttons : [
		  	{
		  		'text' : 'Confirm',
		  		'class' : 'dialog-btn-confirm',
				'click' : function() {
				  edit_data(myid);
				}
			},
		  	{
		  		'text' : 'Cancel',
				'click' : function() {
				  $(this).dialog("close");
				}
			},
		  ]
		});
		
		$("#dialogmastergigi").dialog("open");
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_gigi_diagram_pasien/delete',
			  type: "post",
			  data: {id_transaksi_perawatan:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialog_del_t_gigi").dialog("close");
					achtungCreate('Proses Hapus Data Berhasil');

					if(confirm('Kembali ke Pelayanan dan tutup Odontogram ?')){
						//CONFIRM STATES
						$('#backlistt_pelayanan').trigger('click');
					}else{
					 	$('#main_diagram_gigi').load('t_gigi_diagram_pasien/views/diagram_gigi',{
						'kd_pasien':kd_pasien,
						'kd_puskesmas':kd_puskesmas
						},function(data){
						})
						$('#listt_diagram').trigger( 'reloadGrid' );
					} 
				}
				else{						
					$("#dialog_del_t_gigi").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listt_diagram .icon-delete").live('click', function(){
		var myid= this.rel;	
		$("#dialog_del_t_gigi").dialog({
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
		
		$("#dialog_del_t_gigi").dialog("open");
	});
	
	$('form').resize(function(e) {
		if($("#listt_diagram").getGridParam("records")>0){
		// jQuery('#listt_diagram').setGridWidth(($(this).width()-28));
		}
	});
	
	function formattermou(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue){		
			content  += '<a href="tmp/t_diagram_pasien/' + cellvalue + '" style="color:blue;cursor:pointer" title="">download</a>';
		}else{
			content  += ' - ';
		}
		return content;
	}
	
	$( "#kodet_diagram" )
		.keypress(function(event) {
			var keycode =(event.keyCode?event.keyCode:event.which);	
			if(keycode ==13){
				event.preventDefault();
				$('#listt_diagram').trigger("reloadGrid");
			}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_diagram").live('click', function(event){
		event.preventDefault();
		$('#formt_diagram').reset();
		$("#nomor_gigi_hid").val("");
		refreshDiagramGigi();
		$(".gigi div").removeClass("highlighted");
		$('#listt_diagram').trigger("reloadGrid");
	});
	$("#carit_diagram").bind('click', function(event){
		event.preventDefault();
		refreshDiagramGigi();
		$('#listt_diagram').trigger("reloadGrid");
	});

})
