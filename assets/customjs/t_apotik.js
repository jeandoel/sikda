jQuery().ready(function (){ 	
	var datadetail='';
	
	jQuery("#listt_apotik").jqGrid({ 
		url:'t_apotik/t_apotikantrianxml', 
		emptyrecords: 'Tidak ada data',
		datatype: "xml",
		colNames:['kd_kunjungan','kd_pelayanan','KD_PASIEN','KD_PUSKESMAS','Rekam<br/> Medis','Nama Pasien','Umur','L/P','KK','Alamat','Dokter','Status','Aksi','Lain'],
		rownumbers:true,
		width: 1049,
		height: 'auto',
		mtype: 'POST',
		altRows     : false,		
		colModel:[ 
				{name:'kd_kunjungan',index:'kd_kunjungan', width:5,hidden:true},
				{name:'kd_pelayanan',index:'kd_pelayanan', width:5,hidden:true},
				{name:'kd_puskesmas',index:'kd_puskesmas', width:5,hidden:true},
				{name:'idb',index:'idb', width:5,hidden:true},				
				{name:'column2b',index:'column2b', width:55,sortable:false}, 
				{name:'column3b',index:'column3b', width:115,sortable:false},
				{name:'column3b',index:'column3b', width:35,sortable:false,align:'center'},
				{name:'column3b',index:'column3b', width:25,sortable:false,align:'center'},
				{name:'column4b',index:'column4b', width:115,sortable:false},
				{name:'column5b',index:'column5b', width:155,sortable:false},
				{name:'column6b',index:'column6b', width:95,sortable:false,align:'center'},
				{name:'column8b',index:'column8b', width:85,sortable:false,align:'center',formatter:formatterStatus},
				{name:'aksib',index:'aksib', width:61,align:'center',formatter:formatterPelayanan},
				{name:'aksicheck',index:'aksicheck', width:61,align:'center',formatter:formatterCheck}
			],
			rowNum:5, 
			rowList:[5,10,25], 
			pager: jQuery('#pagert_apotikanantrian'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				dari=$('#tanggalt_apotik').val()?$('#tanggalt_apotik').val():'';
				keyword=$('#keywordt_pendaftaran').val()?$('#keywordt_pendaftaran').val():'';
				mystatus=$('#status_pelayanant_apotik').val()?$('#status_pelayanant_apotik').val():'';
				cari=$('#carit_pendaftaran').val()?$('#carit_pendaftaran').val():'';
				$('#listt_apotik').setGridParam({postData:{'dari':dari,'keyword':keyword,'cari':cari,'status':mystatus}})
			},
			multiselect: false, 
			subGrid: true, 
			subGridRowExpanded: function(subgrid_id, row_id) {
				achtungHideLoader();
				var subgrid_table_id, pager_id; 
				subgrid_table_id = subgrid_id+"_t";
				pager_id = 'p_'+subgrid_table_id;
				subgrid_table_id_pasien = subgrid_id+"_t_pasien";
				subgrid_table_id_riwayat = subgrid_id+"_t_riwayat";
				pager_id_riwayat = 'p_'+subgrid_table_id_riwayat;
				var rowval = $('#listt_apotik').jqGrid('getRowData', row_id);
				var kd_kunjungan = rowval.kd_kunjungan;
				var kd_pelayanan = rowval.kd_pelayanan;
				var kd_puskesmas = rowval.kd_puskesmas;
				var kd_pasien = rowval.idb;				
				
				var htm='';
				htm += '<div class="subgridtitle">Detail Pasien</div>';
				htm +="<table id='"+subgrid_table_id_pasien+"' class='scroll'></table>";
				htm += '<div class="subgridtitle">Daftar Obat</div>';
				htm +="<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>";
				htm += '<div class="subgridtitle">Riwayat Pasien</div>';
				htm +="<table id='"+subgrid_table_id_riwayat+"' class='scroll'></table><div id='"+pager_id_riwayat+"' class='scroll'></div>";
				$("#"+subgrid_id).append(htm);
				jQuery("#"+subgrid_table_id_pasien).jqGrid({			
					url:'t_masters/t_pasienbyparentxml', 
					rownumbers:false,
					height: 'auto',
					mtype: 'POST',
					datatype: "xml", colNames: ['NIK','Tempat, Tgl. Lahir','Gol. Darah','Jenis Pasien','Cara Bayar','Telp/HP'], 
					colModel: [ {name:"kd_obat",index:"kd_obat",width:135,sortable:false}, 
								{name:"nama_obat",index:"nama_obat",width:255,sortable:false}, 
								{name:"jenis_obat",index:"jenis_obat",width:75,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:95,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:95,align:"center",sortable:false}, 
								{name:"harga",index:"harga",width:175,align:"left",sortable:false}
								],
					beforeRequest:function(){
						$('#'+subgrid_table_id_pasien).setGridParam({postData:{'kd_kunjungan':kd_kunjungan,'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'kd_pelayanan':kd_pelayanan}})
					}					
				});
				jQuery("#"+subgrid_table_id).jqGrid({			
					url:'t_masters/t_obatbyparentxml', 
					rownumbers:true,
					mtype: 'POST',
					height: 'auto',
					datatype: "xml", colNames: ['Kd. PKM','kd_kasir','Kd. Obat','Nama Obat','Jenis Obat','Dosis','Harga','Qty','Jumlah','Status','x','Aksi'], 
					colModel: [ 
								{name:"kd_puskesmas",index:"kd_puskesmas",width:80,sortable:false,hidden:true}, 
								{name:"kd_kasir",index:"kd_kasir",width:80,sortable:false,hidden:true}, 
								{name:"kd_obat",index:"kd_obat",width:80,sortable:false}, 
								{name:"nama_obat",index:"nama_obat",width:355,sortable:false}, 
								{name:"jenis_obat",index:"jenis_obat",width:95,align:"center",sortable:false}, 
								{name:"dosis",index:"dosis",width:55,align:"center",sortable:false}, 
								{name:"harga",index:"harga",width:45,align:"center",sortable:false}, 
								{name:"qty",index:"qty",width:35,align:"center",sortable:false}, 
								{name:"jumlah",index:"jumlah",width:45,align:"center",sortable:false,hidden:true}, 
								{name:"status",index:"status",width:70,align:"center",sortable:false,hidden:true}, 
								{name:"kd_pelayanan",index:"kd_pelayanan",width:70,align:"center",sortable:false,hidden:true}, 
								{name:"stat",index:"stat",width:70,align:"center",sortable:false,formatter:formatterObat} 
								],
					rowNum:99, 
					beforeRequest:function(){
						$('#'+subgrid_table_id).setGridParam({postData:{'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'kd_pelayanan':kd_pelayanan}})
					}
				});
				$("#"+subgrid_table_id+" .lab-green").live('click', function(e){
				if($(e.target).data('oneclicked')!='yes')
				{	
					achtungShowLoader();
					var id3 = Math.random();
					$("#"+subgrid_table_id).find('.lab-green').each(function() {
						$(this).click( function(){
							var colid1 = $(this).closest('tr');
							var colid = colid1[0].id;
								$("#"+subgrid_table_id).jqGrid('setSelection', colid );
								var id1 = jQuery("#"+subgrid_table_id).jqGrid('getCell', colid, 'kd_puskesmas');
								var id2 = jQuery("#"+subgrid_table_id).jqGrid('getCell', colid, 'kd_obat');						
								var id4 = jQuery("#"+subgrid_table_id).jqGrid('getCell', colid, 'qty');
								var id5 = jQuery("#"+subgrid_table_id).jqGrid('getCell', colid, 'kd_pelayanan');
								var id6 = jQuery("#"+subgrid_table_id).jqGrid('getCell', colid, 'kd_kasir');
								var id7 = jQuery("#"+subgrid_table_id).jqGrid('getCell', colid, 'harga');
								$.ajax({
									  url: 't_apotik/posting',
									  type: "post",
									  data: {kd_puskesmas:id1,kd_obat:id2,random:id3,stock:id4,kd_pelayanan:id5,kd_kasir:id6,harga:id7},
									  dataType: "json",
									  success: function(msg){
										if(msg == 'OK'){
											$.achtung({message: 'Proses Posting Data Berhasil', timeout:2});
											$("#"+subgrid_table_id).trigger("reloadGrid");
										}
										else{						
											$.achtung({message: 'Maaf Proses Posting Data Gagal', timeout:2});
										}						
									  }
								  });
						});	
					});
					achtungHideLoader();
				}
				$(e.target).data('oneclicked','yes');
				});
				
				jQuery("#"+subgrid_table_id_riwayat).jqGrid({			
					url:'t_masters/t_riwayatbyparentxml', 
					rownumbers:true,
					mtype: 'POST',
					height: 'auto',
					datatype: "xml", colNames: ['Tgl. Kunjungan','Poli','Diagnosa'/*,'Anamnesa'*/,'Tindakan','Obat'], 
					colModel: [ {name:"kd_obat",index:"kd_obat",width:80,sortable:false,align:'center'}, 
								{name:"jenis_obat",index:"jenis_obat",width:85,align:"center",sortable:false},
								{name:"nama_obat",index:"nama_obat",width:255,sortable:false}, 								
								//{name:"dosis",index:"dosis",width:215,align:"center",sortable:false}, 
								{name:"harga",index:"harga",width:225,align:"center",sortable:false}, 
								{name:"qty",index:"qty",width:255,align:"center",sortable:false}
								],
					rowNum:5, 
					pager: pager_id_riwayat,
					beforeRequest:function(){
						$('#'+subgrid_table_id_riwayat).setGridParam({postData:{'kd_kunjungan':kd_kunjungan,'kd_pasien':kd_pasien,'kd_puskesmas':kd_puskesmas,'kd_pelayanan':kd_pelayanan}})
					}
				});
				
				achtungHideLoader();
			},subGridBeforeExpand:function(subgrid_id,row_id){
				achtungShowLoader();
			}
	}).navGrid('#pagert_apotikanantrian',{edit:false,add:false,del:false,search:false});
	
	function formatterPelayanan(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='CHECK ULANG'){
			content += '-';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-blue">Cetak Resep</a>';
		}
		return content;
	}
	function formatterCheck(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='CHECK'){
			content += '-';
		}else if(cellvalue=='LIHAT'){
			content += '<a rel="'+cellvalue+'" class="lab-orange">LIHAT</a>';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-red">-</a>';
		}
		return content;
	}
	function formatterObat(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='1'){
			content += '-';
		}else{
			content  += '<a rel="'+cellvalue+'" class="lab-green">Posting</a>';
		}
		return content;
	}
	
	function formatterStatus(cellvalue, options, rowObject) {
		var content = '';
		if(cellvalue=='BELUM DILAYANI'){
			content  += '<span style="color:green">'+cellvalue+'<span>';
		}else if(cellvalue=='CHECK ULANG'){
			content  += '<span style="color:red">'+'Proses Check Ulang'+'<span>';
		}else if(cellvalue=='SELESAI CHECK'){
			content  += '<span style="color:orange">'+'Telah Di Check'+'<span>';
		}else{
			content  += '<span style="color:blue">'+cellvalue+'<span>';
		}
		return content;
	}
	
	$("#listt_apotik .lab-blue").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			$("#listt_apotik").find('.lab-blue').each(function() {
				$(this).click( function(){
					$("#listt_apotik").trigger("reloadGrid");
					var colid = $(this).parents('tr:last').attr('id');
						$("#listt_apotik").jqGrid('setSelection', colid );
						var myCellDataId = jQuery('#listt_apotik').jqGrid('getCell', colid, 'kd_pelayanan');
						var myCellDataId2 = jQuery('#listt_apotik').jqGrid('getCell', colid, 'kd_puskesmas');
						var myCellDataId3 = jQuery('#listt_apotik').jqGrid('getCell', colid, 'idb');
						// $("#dialogcari_apotikcetak_id").dialog({
						// 	autoOpen: false,
						// 	modal:true,
						// 	width: 711,
						// 	height: 615
						// });	
						// $.get('t_apotik/cetak?kd_pelayanan='+decodeURIComponent(myCellDataId)+'&kd_puskesmas='+decodeURIComponent(myCellDataId2)+'&kd_pasien='+decodeURIComponent(myCellDataId3), function(str) {							
						// 	$("#dialogcari_apotikcetakiframe_id").attr('src',str);        
						// 	$("#dialogcari_apotikcetak_id").dialog("open");							
						// 	return false;
						// });
						window.open("t_apotik/cetakresep?kd_pelayanan="+decodeURIComponent(myCellDataId)+"&kd_puskesmas="+decodeURIComponent(myCellDataId2)+"&kd_pasien="+decodeURIComponent(myCellDataId3));
				});	
			});
		}
		$(e.target).data('oneclicked','yes');
	});	
	
	$("#listt_apotik .lab-red").live('click', function(e){
		if($(e.target).data('oneclicked')!='yes')
		{
			var colid = $(this).parents('tr:last').attr('id');
			$("#listt_apotik").jqGrid('setSelection', colid );
			var id1 = jQuery('#listt_apotik').jqGrid('getCell', colid, 'kd_pelayanan');
			var id2 = jQuery('#listt_apotik').jqGrid('getCell', colid, 'kd_puskesmas');
			var id3 = jQuery('#listt_apotik').jqGrid('getCell', colid, 'idb');
			$("#dialogcari_apotikkomentar").dialog({
				autoOpen: false,
				modal:true,
				width: 711,
				height: 300
			});	
			$('#dialogcari_apotikkomentar').load('t_apotik/checkkomentar?id1='+id1, function() {
			$("#dialogcari_apotikkomentar").dialog("open");
			});
			$("#formkomentar").submit(function(){
					$.ajax({
						  url: 't_apotik/check',
						  type: "post",
						  data: {id1:id1,id2:id2,id3:id3},
						  dataType: "json",
						  success: function(msg){
							if(msg == 'OK'){
								$.achtung({message: 'Proses Permohonan Check Data Berhasil', timeout:2});
								$("#listt_apotik").trigger("reloadGrid");
							}
							else{						
								$.achtung({message: 'Maaf Proses Permohonan Check Data Gagal', timeout:2});
							}						
						  }
					});
			})
		}
		$(e.target).data('oneclicked','yes');
	});	
	
	$("#listt_apotik .lab-orange").live('click', function(s){
		var colid = $(this).parents('tr:last').attr('id');
		$("#listt_apotik").jqGrid('setSelection', colid );
		var id1 = jQuery('#listt_apotik').jqGrid('getCell', colid, 'kd_pelayanan');
		$("#dialogcari_lihatapotikkomentar").dialog({
			autoOpen: false,
			modal:true,
			width: 500,
			height: 300
		});	
		$('#dialogcari_lihatapotikkomentar').load('t_apotik/lihatcheck?id1='+id1, function() {
		$("#dialogcari_lihatapotikkomentar").dialog("open");
		
			$("#listt_apotik").trigger("reloadGrid");	
		});
	});	
	
	$('form').resize(function(e) {
		if($("#listt_apotik").getGridParam("records")>0){
			jQuery('#listt_apotik').setGridWidth(($(this).width()-28));
		}
		if($("#listt_apotik").getGridParam("records")>0){
			jQuery('#listt_apotik').setGridWidth(($(this).width()-28));
		}
	});
	
	//$('#darit_apotik').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onSelect: function(dateText, inst){$('#sampait_apotik').datepicker('option', 'minDate', dateText);$.datepicker._clearDate('#sampait_apotik');$('#listt_apotik').trigger("reloadGrid");}});
	$('#tanggalt_apotik').datepicker({dateFormat: "dd/mm/yy",changeYear: true,onClose: function(dateText, inst){$('#listt_apotik').trigger("reloadGrid");}});
	//$("#darit_apotik").mask("99/99/9999");
	$("#tanggalt_apotik").mask("99/99/9999");
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resett_apotik").live('click', function(event){
		event.preventDefault();
		$('#formt_apotik').reset();
		$('#listt_apotik').trigger("reloadGrid");
	});
	$("#carit_apotik").live('click', function(event){
		event.preventDefault();
		$('#listt_apotik').trigger("reloadGrid");
	});
	
})