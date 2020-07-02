<div class="block">
    <div class="block-content block-content-full">
        <div class="row ">
            <div class="col-xs-12 col-md-12">
            	<a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('user') ?>">Back</a>
            	<button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </div>

		<div class="row">
		    <div class="col-xs-12 col-md-12">		        
		        <div class="block">
		            <div class="block-header block-header-default">
		                <h3 class="block-title">Edit User</h3>
		            </div>		            
		            <div class="block-content">
		                <form id="form-edit" enctype="multipart/form-data" onsubmit="return false">
		                	<input type="hidden" name="user_id" value="<?=$user['user_id']?>">
	    					<div class="row">
	    						<div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label class="control-label">Full Name</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" name="nama_lengkap" value="<?=$user['nama_lengkap']?>">
				                        </div>
				                    </div>
			                    </div>
								<div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label class="control-label">Username</label>
				                        <div>
				                            <input type="text" class="form-control form-control-lg" name="username" value="<?=$user['username']?>">
				                        </div>
				                    </div>
			                    </div>
								<div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="telepon">Password</label>
				                        <div>
				                            <input type="password" class="form-control form-control-lg" name="password">
				                        </div>
				                    </div>
				                </div>
				                <div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label for="nama_cabang">Retype Password</label>
				                        <div>
				                            <input type="password" class="form-control form-control-lg" name="repassword" >
				                        </div>
				                    </div>
			                    </div>
								<div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label class="control-label">Cabang</label>
				                        <div>
				                            <select class="form-control" name="cabang_id">
			                                <option></option>
			                                <?php
			                                    if(isset($rs_cabang) && !empty($rs_cabang)){
			                                        foreach ($rs_cabang as $vcabang) {
			                                        	$selected = $vcabang['cabang_id'] == $user['cabang_id']?'selected="selected"':'';
			                                            echo'<option '.$selected.' value="'.$vcabang['cabang_id'].'">'.$vcabang['nama_cabang'].'</option>';
			                                        }
			                                    }
			                                ?>
			                            </select>
				                        </div>
				                    </div>
			                    </div>
			                    <div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label class="control-label">Group</label>
				                        <div>
				                            <select class="form-control" name="group_id">
			                                <option></option>
			                                <?php
			                                    if(isset($rs_group) && !empty($rs_group)){
			                                        foreach ($rs_group as $vugroup) {
			                                        	$selected = $vugroup['group_id'] == $user['group_id']?'selected="selected"':'';
			                                            echo'<option '.$selected.' value="'.$vugroup['group_id'].'">'.$vugroup['group_name'].'</option>';
			                                        }
			                                    }
			                                ?>
			                            </select>
				                        </div>
				                    </div>
			                    </div>
								<div class="col-lg-6 col-xs-12 col-md-12">
				                    <div class="form-group">
				                        <label class="control-label">Status</label>
				                        <select class="form-control" name="status">
				                            <option <?=$user['status'] == 1?'selected="selected"':''?> value="1">Active</option>
				                            <option <?=$user['status'] == 0?'selected="selected"':''?> value="0">Deactived</option>
				                        </select>
				                    </div>
				                </div>
	    					</div>
		                </form>
		            </div>
		        </div>
		    </div>
			<!-- ./col-md-12 -->
		</div>
		<!-- ./row -->
	</div>
</div>