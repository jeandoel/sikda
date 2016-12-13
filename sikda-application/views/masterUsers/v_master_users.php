<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_users.js"></script>

<div class="mycontent">
<div id="dialogmasterusers" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Pengguna</div>
	<form id="formmasterusers">
		<div class="gridtitle">Daftar Pengguna<span class="tambahdata" id="v_master_users_add">Input Users Baru</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Username/Pengguna</label>
						<input type="text" name="user" class="user" id="usermasteruser"/>
						<input type="hidden" name="group_id" class="group_id" id="group_id" value="<?=$this->session->userdata('group_id')?>"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterusers"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterusers"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterusers"></table>
		<div id="pagermasterusers"></div>
		</div >
	</form>
</div>