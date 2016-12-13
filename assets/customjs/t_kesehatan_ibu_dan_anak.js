jQuery().ready(function (){ 
	jQuery("#listt_kesehatanibudananak").jqGrid({ 
		url:'t_kesehatan_ibu_dan_anak/t_kesehatan_ibu_dan_anakxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml", 
		colNames:['ID','Kode Pasien','Tanggal Kunjungan','Nama Pengunjung','Jenis Kelamin','Kode Kategori Kunjungan','Kategori Kunjungan',
			  'Kunjungan Pemeriksaan','Kunjungan','Action'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,
		colModel:[ 
				{name:'id',index:'id', width:5,hidden:true}, 
				{name:'kd_pasien',index:'kd_pasien', width:99}, 
				{name:'tanggal_kunjungan',index:'tanggal_kunjungan', width:115,sortable:false}, 
				{name:'nama_pengunjung',index:'nama_pengunjung', width:125,sortable:false}, 
				{name:'jk',index:'jk', width:125,sortable:false}, 
				{name:'kd_kunjungan_kia',index:'kd_kunjungan_kia', width:5,hidden:true}, 
				{name:'kategori_kunjungan',index:'kategori_kunjungan', width:100,sortable:false},
				{name:'kunjungan_pemeriksaan',index:'kunjungan_pemeriksaan', width:75,align:'center',sortable:false},
				{name:'aksi',index:'aksi', width:69,align:'center',formatter:formatterKunjungan},
				{name:'myid',index:'myid', width:99,align:'center',formatter:formatterAction, hidden:true}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_kesehatanibudananak'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				//dari=$('#darit_kesehatanibudananak').val()?$('#darit_kesehatanibudananak').val():'';
				//sampai=$('#sampait_kesehatanibudananak').val()?$('#sampait_kesehatanibudananak').val():'';
				keyword=$('#keywordid').val()?$('#keywordid').val():'';
				cari=$('#kesehatanibudananak').val()?$('#kesehatanibudananak').val():'';
				$('#listt_kesehatanibudananak').setGridParam({postData:{'keyword':keyword,'cari':cari}})
			}
			
		
	}).navGrid('#pagert_kesehatanibudananak',{edit:false,add:false,del:false,search:false});
	
	function formatterKunjungan(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="'+cellvalue+'" class="lab-green">Kunjungan</a>';
		return content;
	}
	
	$("#listt_kesehatanibudananak .lab-green").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_kesehatanibudananak").find('.lab-green').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_kesehatanibudananak").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_kesehatanibudananak').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_kesehatanibudananak').jqGrid('getCell', colid, 'kd_kunjungan_kia');
						$("#t422","#tabs").empty();
						$("#t422","#tabs").load('t_kesehatan_ibu_dan_anak/detailkunjungan'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		content  += '<a rel="' + cellvalue + '" class="icon-detail" title="View"></a> ';
		content  += '<a rel="' + cellvalue + '" class="icon-edit" title="Edit?"></a>';
		content  += '<a rel="' + cellvalue + '" class="icon-delete" title="Remove?"></a>';
		return content;
	}
	$("#listt_kesehatanibudananak .icon-detail").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t422","#tabs").empty();
			$("#t422","#tabs").load('t_kesehatan_ibu_dan_anak/detail'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	$("#listt_kesehatanibudananak .icon-edit").live('click', function(g){
		if($(g.target).data('oneclicked')!='yes')
		{
			$("#t422","#tabs").empty();
			$("#t422","#tabs").load('t_kesehatan_ibu_dan_anak/edit'+'?id='+this.rel);
		}
		$(g.target).data('oneclicked','yes');
	});
	
	function deldata(myid){
		achtungShowLoader();
		$.ajax({
			  url: 't_kesehatan_ibu_dan_anak/delete',
			  type: "post",
			  data: {kodekesehatanibudananak:myid},
			  dataType: "json",
			  success: function(msg){
				if(msg == 'OK'){
					$("#dialogkesehatanibudananak").dialog("close");
					$.achtung({message: 'Proses Hapus Data Berhasil', timeout:5});
					$('#listt_kesehatanibudananak').trigger("reloadGrid");							
				}
				else{						
					$("#dialogkesehatanibudananak").dialog("close");
					$.achtung({message: 'Maaf Proses Hapus Data Gagal', timeout:5});
				}						
			  }
		  });
		achtungHideLoader();
	}
	
	$("#listt_kesehatanibudananak .icon-delete").live('click', function(){
		var myid= this.rel;
		$("#dialogkesehatanibudananak").dialog({
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
		
		$("#dialogkesehatanibudananak").dialog("open");
	});
	$('#t_kesehatanibudananakadd').click(function(){
		$("#t422","#tabs").empty();
		$("#t422","#tabs").load('t_kesehatan_ibu_dan_anak/add'+'?_=' + (new Date()).getTime());
	});
	
	
	
	$("#listt_kesehatanibudananak .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_kesehatanibudananak").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_kesehatanibudananak").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_kesehatanibudananak').jqGrid('getCell', colid, 'kd_kunjungan');
						var myCellDataId2 = jQuery('#listt_kesehatanibudananak').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#t422","#tabs").empty();
						$("#t422","#tabs").load('t_kesehatanibudananak/edit'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$("#listt_kesehatanibudananak .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_kesehatanibudananak").find('.lab-blue').each(function() {
				$(this).click( function(){
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_kesehatanibudananak").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_kesehatanibudananak').jqGrid('getCell', colid, 'kd_pasien');
						var myCellDataId2 = jQuery('#listt_kesehatanibudananak').jqGrid('getCell', colid, 'kd_puskesmas');
						$("#422","#tabs").empty();
						$("#422","#tabs").load('t_kesehatanibudananak/gabungpasien'+'?id='+decodeURIComponent(myCellDataId)+'&id2='+decodeURIComponent(myCellDataId2));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});
	
	$('form').resize(function(e) {
		if($("#listt_kesehatanibudananak").getGridParam("records")>0){
			jQuery('#listt_kesehatanibudananak').setGridWidth(($(this).width()-28));
		}
		if($("#listt_kesehatanibudananakantrian").getGridParam("records")>0){
			jQuery('#listt_kesehatanibudananakantrian').setGridWidth(($(this).width()-28));
		}
	});
	
	//$('#tanggalt_kesehatanibudananak').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_kesehatanibudananak').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_kesehatanibudananak');$('#listt_kesehatanibudananak').trigger("reloadGrid");}});
	$('#tanggalt_kesehatanibudananak').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onClose: function(dateText, inst){$('#listt_kesehatanibudananakantrian').trigger("reloadGrid");}});
	$("#tanggalt_kesehatanibudananak").mask("99/99/9999");
	//$("#sampait_kesehatanibudananak").mask("99/99/9999");
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	
	$("#resettrans_kia").live('click', function(event){
		event.preventDefault();
		$('#formt_kesehatanibudananak').reset();
		$('#listt_kesehatanibudananak').trigger("reloadGrid");
	});
	$("#caritrans_kia").live('click', function(event){
		event.preventDefault();
		$('#listt_kesehatanibudananak').trigger("reloadGrid");
	});
	
})