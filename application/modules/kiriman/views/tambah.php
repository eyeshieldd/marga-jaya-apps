<div class="block">
          <div class="block-content block-content-full">
           <div class="row">
            <div class="col-xs-12 col-md-12"><a class="btn btn-secondary btn-lg mb-10" href="<?= base_url('kiriman') ?>">Back</a>
             <button class="btn btn-primary btn-lg mb-10 pull-right" id="tombol-simpan"><i class="fa fa-save"></i> Simpan</button></div></div>

             <div class="row">
              <div class="col-xs-12 col-md-12">		        
               <div class="block">
                <div class="block-header block-header-default">
                 <h3 class="block-title">Input Pengiriman</h3>
               </div>		    	
               <div class="block-content">
                 <form id="form-tambah" enctype="multipart/form-data" onsubmit="return false">
                  <div class="row">
                    <div class="col-lg-4 col-xs-12 col-md-12">
                      <div class="form-group">
                       <label for="nama_kiriman">Tanggal</label>
                       <div>
                        <input placeholder="dd / mm / yy" type="text" class="datepicker form-control form-control-lg" name="tanggal" value="<?=date('d-m-Y')?>" id="tanggal">
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-4 col-xs-12 col-md-12">
                    <div class="form-group">
                     <label for="nama_sopir">Nama Supir</label>
                     <div>
                      <input type="text" class="form-control form-control-lg" id="nama_sopir" name="nama_sopir" placeholder="Input data nama supir..">
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-xs-12 col-md-12">
                  <div class="form-group">
                   <label>Pesanan A.N</label>
                   <select class="form-control form-control-lg" name="order_id" id="my_select">
                    <option value="">Pilih</option>
                    
                    <?php
                    if(isset($rs_pembeli) && !empty($rs_pembeli)){
                     foreach ($rs_pembeli as $vpembeli) {
                      echo'<option value ="'.$vpembeli['order_id'].'">'.$vpembeli['nama_pembeli'].'('.$vpembeli['nama_cabang'].')</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>		                    
          </div>

          <div class="row">
           <div class="col-lg-4 col-xs-12 col-md-12">
            <div class="form-group">
             <label>Barang</label>
             <select class="form-control form-control-lg" name="detail_id" id="select">
              <option value="">Pilih</option>


            </select>
          </div>
        </div>

        <div class="col-lg-4 col-xs-12 col-md-12">
          <div class="form-group">
           <label>Stok</label>
           <select class="form-control form-control-lg" name="stok_produksi_id" id="selecto">
            <option value="0">Pilih</option>

          </select>
        </div>
      </div>

      <div class="col-lg-4 col-xs-12 col-md-12">
       <div class="form-group">
        <label for="nama_sopir">Jumlah</label>
        <div>
         <input type="text" class="form-control form-control-lg jumlah" id="jumlah" name="jumlah">
       </div>
     </div>
   </div>
 </div>
</form>
</div>
</div>
<!-- ./col-md-12 -->
</div>
<!-- ./row -->
</div>
</div>
