<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_user_group.js"></script>

<div class="mycontent">
<div id="dialogmasterusergroup" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Group Pengguna</div>
	<form id="formmasterusergroup">
		<div class="gridtitle">Daftar User Group<span class="tambahdata" id="v_master_user_group_add">Input User Group</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Group Name</label>
						<input type="text" name="group" class="group" id="groupmastergroup"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterusergroup"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterusergroup"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterusergroup"></table>
		<div id="pagermasterusergroup"></div>
		</div >
	</form>
</div>