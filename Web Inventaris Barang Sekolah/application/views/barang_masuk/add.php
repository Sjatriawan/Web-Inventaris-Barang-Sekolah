<meta charset="utf-8">
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Input Barang Masuk
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangmasuk') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open('', [], ['id_barang_masuk' => $id_barang_masuk, 'user_id' => $this->session->userdata('login_session')['user']]); ?>

               
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal_masuk">Tanggal Masuk</label>
                    <div class="col-md-4">
                        <input value="<?= set_value('tanggal_masuk', date('Y-m-d')); ?>" name="tanggal_masuk" id="tanggal_masuk" type="text" class="form-control date" placeholder="Tanggal Masuk...">
                        <?= form_error('tanggal_masuk', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="supplier_id">Pengadaan</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <select name="supplier_id" id="supplier_id" class="custom-select">
                                <option value="" selected disabled>Pilih Tim Pengadaan</option>
                                <?php foreach ($supplier as $s) : ?>
                                    <option <?= set_select('supplier_id', $s['id_supplier']) ?> value="<?= $s['id_supplier'] ?>"><?= $s['nama_supplier'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-primary" href="<?= base_url('supplier/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('supplier_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                  <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="pemeriksa_id">Pemeriksa</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <select name="pemeriksa_id" id="pemeriksa_id" class="custom-select">
                                <option value="" selected disabled>Pilih Pemeriksa</option>
                                <?php foreach ($pemeriksa as $p) : ?>
                                    <option <?= set_select('pemeriksa_id', $p['id_pemeriksa']) ?> value="<?= $p['id_pemeriksa'] ?>"><?= $p['nama_pemeriksa'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-primary" href="<?= base_url('pemeriksa/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('pemeriksa_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <select name="barang_id" id="barang_id" class="custom-select">
                                <option value="" selected disabled>Pilih Barang</option>
                                <?php foreach ($barang as $b) : ?>
                                    <option <?= $this->uri->segment(3) == $b['id_barang'] ? 'selected' : '';  ?> <?= set_select('barang_id', $b['id_barang']) ?> value="<?= $b['id_barang'] ?>"><?= $b['id_barang'] . ' | ' . $b['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-primary" href="<?= base_url('barang/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
            
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="jumlah_masuk">Jumlah Masuk</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input value="<?= set_value('jumlah_masuk'); ?>" name="jumlah_masuk" id="jumlah_masuk" type="number" class="form-control" placeholder="Jumlah Masuk...">
                            <div class="input-group-append">
                                <span class="input-group-text" id="satuan">Satuan</span>
                            </div>
                        </div>
                        <?= form_error('jumlah_masuk', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                 <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="stok">Stok</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="stok" type="number" class="form-control">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="total_stok" type="number" class="form-control">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total_harga">Total Harga</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input value="<?= set_value('total_harga'); ?>" name="total_harga" id="total_harga" type="number" class="form-control" placeholder="Total Harga...">
                        </div>
                        <?= form_error('total_harga', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="serah_terima">Berita Acara Serah Terima</label>
                    <div class="col-md-5">
                        <div class="info-group">
                             <div class="form-check">
                                <input type="radio" name="serah_terima" value="Terlampir" <?php echo set_radio('serah_terima', 'Terlampir', TRUE); ?> />
                               <label class="form-check-label" for="inlineCheckbox2">Terlampir</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="serah_terima" value="Tidak Terlampir" <?php echo set_radio('serah_terima', 'Terlampir'); ?> />
                               <label class="form-check-label" for="inlineCheckbox2">Tidak Terlampir</label>
                            </div>
                    </div>    
                </div>
            </div>


                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="ba_pemeriksaan">Berita Acara Pemeriksaan Barang</label>
                    <div class="col-md-5">
                        <div class="info-group">
                             <div class="form-check">
                                <input type="radio" name="ba_pemeriksaan" value="Terlampir" <?php echo set_radio('ba_pemeriksaan', 'Terlampir', TRUE); ?> />
                               <label class="form-check-label" for="inlineCheckbox2">Terlampir</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="ba_pemeriksaan" value="Tidak Terlampir" <?php echo set_radio('ba_pemeriksaan', 'Terlampir'); ?> />
                               <label class="form-check-label" for="inlineCheckbox2">Tidak Terlampir</label>
                            </div>
                    </div>    
                </div>
            </div>

                
             <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="boss">Sumber Dana</label>
                    <div class="col-md-5">
                        <div class="info-group">
                             <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="boss" id="inlineCheckbox2" value="3" <?php echo set_radio('boss', '3'); ?> />
                                  <label class="form-check-label" for="inlineCheckbox2">BOS</label>
                            </div>
                             <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="bpp" id="inlineCheckbox2" value="3" <?php echo set_radio('bpp', '3'); ?> />
                                  <label class="form-check-label" for="inlineCheckbox2">BPP</label>
                            </div>
                             <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="lainnya" id="inlineCheckbox2" value="3" <?php echo set_radio('lainnya', '3'); ?> />
                                  <label class="form-check-label" for="inlineCheckbox2">Lainnya</label>
                            </div>
                    </div>    
                </div>
            </div>

            <!--  <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="bpp"></label>
                    <div class="col-md-5">
                        <div class="info-group">
                             <div class="form-check">
                                <input type="radio" name="bpp" value="3" <?php echo set_radio('bpp', '3'); ?> />
                               <label class="form-check-label" for="inlineCheckbox2">BPP</label>
                            </div>
                    </div>    
                </div>
            </div> -->

                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>