<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>SIKDA Generik</title>

	<link href="<?=base_url()?>assets/images/icon-kemkes.png" rel="shortcut icon" type="text/css" />
	<link href="<?=base_url()?>assets/css/layout.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url()?>assets/jquerytree/jquery.treeview.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url()?>assets/jquery-ui-1.9.0.custom/css/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"  />
	<link href="<?=base_url()?>assets/jqgrid/css/ui.jqgrid.css" rel="stylesheet" type="text/css"/>
	<link href="<?=base_url()?>assets/achtung/ui.achtung-mins.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/global.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/achtung/ui.achtung-min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/achtung/achtung.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/formresize.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/jquery-ui-1.9.0.custom/js/jquery-ui-1.9.0.custom.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/jqgrid/js/i18n/grid.locale-en.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/jqgrid/js/jquery.jqGrid.src.js"></script>
	<!--<script type="text/javascript" src="<?=base_url()?>assets/jqgrid/js/jquery.jqGrid.min.js"></script>-->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.layout-latest.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/jquerytree/jquery.treeview.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/moment.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/customjs/layout.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-validation/dist/jquery.validate.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.chained.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.chained.remote.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/jqplot/jquery.jqplot.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/jqplot/excanvas.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/jqplot/jquery.jqplot.css" />
	<style>
	</style>
	<script>
	$(document).ready(function(){
		$.jqplot.config.enablePlugins = true;
		var line1=[<?=$kunjungantotal?>];
		var plot1;
		plot(line1);

		/**
		 * Auto refresh, loading, auto loading, jqgrid, settimeout, setinterval, reloadgrid
		 * To auto refresh jqgrid after a set of time
		 */
		// // setInterval(function(){$('table:not(#west-grid)').trigger("reloadGrid")},50000);
		/* -----------------------------------------------------------------------------------*/


		/*setInterval(function(){
			$.ajax({
			url: <?base_url()?>'dashboard/getKunjungan',
			type: "get",
			dataType: "text",
			success: function(msg){
						var line=[msg];
						plot(line);
					 }
			});
		},10000);*/

		$('.cell-wrapperleaf').live('click',function(){
			$.ajax({
			url: '<?=base_url()?>login/checksession',
			type: "post",
			dataType: "text",
			success: function(msg){
						if(msg !== 'ok'){
							location.reload();
						}
					 }
			});
		});
	});

	function plot(line1){//alert(line1);
		$('#chartsatu').empty();
		var plot1 = $.jqplot('chartsatu', [line1], {
			animate: !$.jqplot.use_excanvas,
			axes:{
				xaxis:{
					renderer:$.jqplot.DateAxisRenderer,
					tickOptions:{formatString:'%d-%m-%Y'},
				}
			},
			series:[{lineWidth:4, markerOptions:{style:'square'}}]
		});
	}
	</script>
	<!-- Add IntroJs styles -->
    <link href="<?=base_url()?>assets/intro/introjs.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/intro/example/assets/css/bootstrap-responsive.min.css" rel="stylesheet">
	<script type="text/javascript" src="<?=base_url()?>assets/intro/intro.js"></script>	
	<!-- end Add IntroJs styles -->
</head>
<body>
<!--  --------------------------------------------------NORTH START ------------------------------------------------------------- -->
<div class="ui-layout-north">
<div class="header">
<div class="myuserinfo"><div>User: <span><?=$this->session->userdata('user_name')?></span> <?=$this->session->userdata('level_aplikasi')=='PUSKESMAS'?'Puskesmas: <span>'.$this->session->userdata('puskesmas').'</span>':'Kabupaten: <span>'.$this->session->userdata('nama_kabupaten').'</span>'?> <span class="keluar"><a href="<?=site_url()?>login/mlogout" style="color:#8B0000;padding-left:19px">KELUAR</a></span> <span id="date" style="color:#333333;font-weight:normal!important"></span></div></div>
<?php if($this->session->userdata('level_aplikasi')=='KABUPATEN'){?>
<img src="<?=base_url()?>assets/images/right-kab.png" alt="logo-sikda" />
<?php }else{ ?>
<img src="<?=base_url()?>assets/images/left.png" alt="logo-sikda" />
<?php } ?>
<span style="float:right"><img src="<?=base_url()?>assets/images/right.png" alt="logo-kemkes" /></span>
</div>

</div>
    <div class="clear"></div>
</div>
<!-------------------------------------------------------NORTH END ------------------------------------------------------------------>

<!------------------------------------------------------CENTER START ---------------------------------------------------------------->
<div class="ui-layout-center">
<div id="tabs" class="jqgtabs">
			<ul>
				<li><a href="#tabs-1">Dashboard</a></li>
			</ul>
			<div id="tabs-1">
							<div class="formtitle">Dashboard</div>
							<form>
							<div class="onecolumns">
								<!--COLUMN START-->
								<div class="col">
									<div class="modulebox">
										<h3 class="module-header">Grafik Kunjungan 7 Hari Terakhir</h3>
										<div class="module-content2">
										<div id="chartsatu"style="width:925px; height:155px;margin-left:11px;margin-right:11px"></div>
										</div>
										<!--module-content -->
									</div>
									<!--modulebox -->
								</div>
								<!--COL END -->
							</div>

							<div class="threecolumns">
								<!--COLUMN FIRST START-->
								<div class="col first">
									<div class="modulebox">
										<h3 class="module-header">5 Diagnosa Terbanyak 30 hari Terakhir</h3>
										<div class="module-content">
											<table class="rptRevenue" rel="total">
												<tr class="thead">
													<th>KD Penyakit</th>
													<th>Penyakit</th>
													<th>Jumlah</th>
												</tr>
												<?php foreach($top5diagnose as $res =>$val):?>
												<tr>
													<td><?=$val['KD_PENYAKIT']?></td>
													<td><?=$val['PENYAKIT']?></td>
													<td><?=$val['BANYAK']?></td>
												</tr>
												<?php endforeach;?>
											</table>
										</div>
										<!--module-content -->
									</div>
									<!--modulebox -->
								</div>
								<!--COLUMN FIRST END-->

								<!--COLUMN SECOND START-->
								<div class="col ">
									<div class="modulebox">
										<h3 class="module-header">5 Kunjungan Poli Terbanyak 30 hari Terakhir</h3>
										<div class="module-content">
											<table class="rptRevenue" rel="total">
												<tr class="thead">
													<th>Nama Poli</th>
													<th>Jumlah</th>
												</tr>
												<?php foreach($top5unit as $res2 =>$val2):?>
												<tr>
													<td><?=$val2['UNIT']?></td>
													<td><?=$val2['BANYAK']?></td>
												</tr>
												<?php endforeach;?>
											</table>
										</div>
										<!--module-content -->
									</div>
									<!--modulebox -->
								</div>
								<!--COL SECOND END-->
							</div>
			</div>
			</form>
</div>

</div>
<!--  -------------------------------------------------- CENTER END ------------------------------------------------------------- -->


<!--  --------------------------------------------------WEST START ------------------------------------------------------------- -->
<div class="ui-layout-west">
		<table id="west-grid"></table>
	</ul>
</div>
<!--  --------------------------------------------------WEST END ------------------------------------------------------------- -->


<!--  --------------------------------------------------SOUTH START ------------------------------------------------------------- -->
<div class="ui-layout-south">
		<div id="footer"><span class="footertext">&copy; 2014 SIKDA Generik - All Rights Reserved</span></div>
</div>
<!--  --------------------------------------------------SOUTH END ------------------------------------------------------------- -->
</body>
</html>