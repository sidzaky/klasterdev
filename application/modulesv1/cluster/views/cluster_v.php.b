            <div class="container-fluid">
                <div class="row bg-title">
                </div>
				<div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0"  align="center"><b>Data Klaster BRIspot <?php echo $this->session->userdata('name_uker');?></b></h3>
							<div id="result">
							<script>$(document).ready(function() {
										 $('#example').DataTable( {
												"scrollX": true,
												"processing": true,
												"serverSide": true,
												 "ajax": {
													"url": "<?php echo base_url();?>cluster/getdata",
													"type": "POST" 
													},
													
											});
											var tambah='&nbsp<button class="btn btn-success waves-effect waves-light btn-sm" onclick="getform()" type="button"><i class="fa fa-plus"></i> Tambah Data</button>';
											var download='&nbsp<button class="btn btn-primary waves-effect waves-light btn-sm" onclick="window.open(\'\cluster/dldata\')" type="button"><i class="fa fa-download"></i> Download All Data</button>';
											var report='&nbsp<button class="btn btn-info waves-effect waves-light btn-sm" onclick="window.open(\'\cluster/getreport/harian\')" type="button"><i class="fa fa-info"></i> Laporan Harian</button><?php echo ($this->session->userdata('permission')>3 ? '&nbsp<button class="btn btn-info waves-effect waves-light btn-sm" onclick="window.open(\\\'\cluster/getreport/\\\')" type="button"><i class="fa fa-info"></i> Report akhir</button>\'' : '\'' )?>;
											var logout='&nbsp<button class="btn btn-warning waves-effect waves-light btn-sm" onclick="window.location = \'\login/logout\';" type="button"><i class="fa fa-sign-out"></i> Keluar</button>';
											var userm='&nbsp<button class="btn btn-primary waves-effect waves-light btn-sm" onclick="userm();" type="button"><i class="fa fa-sign-out"></i> Ganti Password Uker</button>';
											$("#example_length").append(tambah<?php echo ($this->session->userdata('permission')>2 ? '+report' : '')?>+userm+logout);
										
										});</script>
								<div class="col-sm-12">
									<table id="example" class="table table-striped table-bordered" style="width:100%">
											<thead>
												<tr>
													<th>No</th>
													<th>Kantor Wilayah</th>
													<th>Nama Kanca</th>
													<th>Nama Uker</th>
													<th>Nama Kelompok Usaha</th>
													<th>Jml Anggota </th>
													<th>Jenis Usaha</th>
													<th>Bentuk Produk/Jasa</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
								</div>
							</div>
					</div>
				</div>
            </div>
          <!-- Modal -->
		<style>
			.modal-body{
					max-height: calc(100vh - 200px);
					overflow-y: auto;
			}
		
		</style>
      <div class="modal " id="modal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" onclick="$('#modal').hide();" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h5 class="modal-title">Form klaster <?php echo $this->session->userdata('nama_uker')?></h5>
            </div>
            <div class="modal-body">
				<div id="mod-content">
						<div class="row">
							
							<div class="col-sm-12"><label for="thedata" class="col-sm-12 control-label"><h3 align="center">Isian terkait Unit BRI</h3></label></div>
							<label for="thedata" class="col-sm-10 control-label" id="setuker"></label>
							<div class="col-sm-12">
								<input type="hidden" class="form-control dform "   id="id" placeholder="required" value="" required>
							</div>
							<label for="thedata" class="col-sm-2 control-label drequired">Kode Uker</label><div id="hsuk"></div>
							<div class="col-sm-12">
								<input type="number" class="form-control dform  required" name="kode uker" <?php echo ($this->session->userdata('permission')>1 ? '' : 'disabled') ?>  id="kode_uker" onchange="getuker(this.value);" placeholder="required" value="<?php echo $this->session->userdata('kode_uker');?>" required>
							</div>
							<label for="thedata" class="col-sm-12 control-label drequired">Nama Kaunit BRI</label>
							<div class="col-sm-12">
								<input type="text" pattern="[a-zA-Z]" class="form-control dform  required"   id="kaunit_nama" value="" placeholder="required" required>
							</div>
							<label for="thedata" class="col-sm-12 control-label drequired">PN Kaunit</label>
							<div class="col-sm-12">
								<input type="number" class="form-control dform  required"  id="kaunit_pn" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">No Handphone Kaunit</label>
							<div class="col-sm-12">
								<input type="text" pattern="[a-zA-Z]"  class="form-control dform  required"  onchange="cekhp(this);" id="kaunit_handphone" value="" placeholder="08xxxxxxxx (required)" required>
							</div>
							
							<!-- Mantriii -->
							<label for="thedata" class="col-sm-12 control-label drequired">Nama Mantri / Pekerja BRI (Pembina Klaster)</label>
							<div class="col-sm-12">
								<input type="text" pattern="[a-zA-Z]"  class="form-control dform  required"  id="nama_pekerja" value="" placeholder="required" required>
							</div>
							<label for="thedata" class="col-sm-12 control-label drequired">PN Mantri / Pekerja BRI (Pembina Klaster)</label>
							<div class="col-sm-12">
								<input type="number" class="form-control dform  required"  id="personal_number" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">No Handphone Mantri / Pekerja BRI (Pembina Klaster)</label>
							<div class="col-sm-12">
								<input type="text" pattern="[a-zA-Z]"  class="form-control dform  required"  onchange="cekhp(this);" id="handphone_pekerja" value="" placeholder="08xxxxxxxx (required)" required>
							</div>
							
							
							<!-- Kelompok Usaha -->
							
							<div class="col-sm-12"><label for="thedata" class="col-sm-12 control-label"><h3 align="center">Isian terkait Kelompok Usaha / Klaster</h3></label></div>
							<label for="thedata" class="col-sm-12 control-label drequired">Nama Kelompok Usaha / Klaster</label>
							<div class="col-sm-12">
								<input type="text" pattern="[a-zA-Z]"  class="form-control dform  required"  id="kelompok_usaha" value="" placeholder="required" required>
							</div>
							<label for="thedata" class="col-sm-12 control-label drequired">Jumlah Anggota (orang)</label>
							<div class="col-sm-12">
								<input type="number" min="15" class="form-control dform  required"  id="kelompok_jumlah_anggota" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Sudah Punya Pinjaman?</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="kelompok_anggota_pinjaman">
									<option value="Seluruh anggota sudah punya pinjaman">Seluruh anggota sudah punya pinjaman</option>
									<option value="Lebih dari 50% anggota punya pinjaman">Lebih dari 50% anggota punya pinjaman</option>
									<option value="Kurang dari 50% anggota punya pinjaman">Kurang dari 50% anggota punya pinjaman</option>
									<option value="Seluruh anggota belum punya pinjaman">Seluruh anggota belum punya pinjaman</option>
								</select>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Sektor Usaha</label>
							<div class="col-sm-12">
									<select class="form-control dform  required"  id="sektor_usaha">
									<option value="Produksi">Produksi</option>
									<option value="Non Produksi">Non Produksi</option>
								</select>
							</div>
							<label for="thedata" class="col-sm-12 control-label drequired">Jenis Usaha</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="jenis_usaha">
									<option value="Pertanian - Pangan">Pertanian - Pangan</option>
									<option value="Pertanian - Holtikultura" >Pertanian - Holtikultura</option>
									<option value="Pertanian - Perkebunan">Pertanian - Perkebunan</option>
									<option value="Peternakan">Peternakan</option>
									<option value="Jasa Pertanian dan Perburuan">Jasa Pertanian dan Perburuan</option>
									<option value="Kehutanan & Penebangan Kayu">Kehutanan & Penebangan Kayu</option>
									<option value="Perikanan">Perikanan</option>
									<option value="Pertambangan Minyak & Gas Bumi">Pertambangan Minyak & Gas Bumi</option>
									<option value="Pertambangan Batubara & Lignit">Pertambangan Batubara & Lignit</option>
									<option value="Pertambangan Biji Logam">Pertambangan Biji Logam</option>
									<option value="Pertambangan & Penggalian Lainnya">Pertambangan & Penggalian Lainnya</option>
									<option value="Industri Batubara & Pengilangan Migas">Industri Batubara & Pengilangan Migas</option>
									<option value="Industri Makanan & Minuman">Industri Makanan & Minuman</option>
									<option value="Pengolahan Tembakau">Pengolahan Tembakau</option>
									<option value="Industri Tekstil dan Pakaian Jadi">Industri Tekstil dan Pakaian Jadi</option>
									<option value="Industri Kulit, Barang dari Kulit dan Alas Kaki">Industri Kulit, Barang dari Kulit dan Alas Kaki</option>
									<option value="Industri Kayu, Barang dari Kayu, Gabus dan Barang Anyaman dari Bambu, Rotan dan sejenisnya">Industri Kayu, Barang dari Kayu, Gabus dan Barang Anyaman dari Bambu, Rotan dan sejenisnya</option>
									<option value="Industri Kimia, Farmasi dan Obat Tradisional">Industri Kimia, Farmasi dan Obat Tradisional</option>
									<option value="Industri Karet, Barang dari Karet dan Plastik">Industri Karet, Barang dari Karet dan Plastik</option>
									<option value="Industri Barang Galian bukan logam">Industri Barang Galian bukan logam</option>
									<option value="Industri Logam Dasar">Industri Logam Dasar</option>
									<option value="Industri Barang dari Logam, Komputer, Barang Elektronik, Optik dan Peralatan Listrik">Industri Barang dari Logam, Komputer, Barang Elektronik, Optik dan Peralatan Listrik</option>
									<option value="Industri Mesin dan Perlengkapan">Industri Mesin dan Perlengkapan</option>
									<option value="Industri Alat Angkutan">Industri Alat Angkutan</option>
									<option value="Industri Furnitur">Industri Furnitur</option>
									<option value="Industri Pengolahan Lainnya, Jasa Reparasi dan Pemasangan Mesin dan Peralatan">Industri Pengolahan Lainnya, Jasa Reparasi dan Pemasangan Mesin dan Peralatan</option>
									<option value="Pengadaan Listrik dan Gas">Pengadaan Listrik dan Gas</option>
									<option value="Pengadaan Gas dan Produksi Es">Pengadaan Gas dan Produksi Es</option>
									<option value="Pengadaan Air, Pengelolaan Sampah, Limbah dan Daur Ulang">Pengadaan Air, Pengelolaan Sampah, Limbah dan Daur Ulang</option>
									<option value="Konstruksi">Konstruksi</option>
									<option value="Perdagangan Mobil, Sepeda Motor dan Reparasinya">Perdagangan Mobil, Sepeda Motor dan Reparasinya</option>
									<option value="Perdagangan Besar dan Eceran, bukan Mobil dan Sepeda">Perdagangan Besar dan Eceran, bukan Mobil dan Sepeda</option>
									<option value="Transportasi Angkutan Rel">Transportasi Angkutan Rel</option>
									<option value="Transportasi Angkutan Darat">Transportasi Angkutan Darat</option>
									<option value="Transportasi Angkutan Laut">Transportasi Angkutan Laut</option>
									<option value="Transportasi Angkutan Sungai, Danau & Penyeberangan">Transportasi Angkutan Sungai, Danau & Penyeberangan</option>
									<option value="Transportasi Angkutan Udara">Transportasi Angkutan Udara</option>
									<option value="Pergudangan dan Jasa Penunjang Angkutan, Pos dan Kurir">Pergudangan dan Jasa Penunjang Angkutan, Pos dan Kurir</option>
									<option value="Penyediaan Akomodasi dan makan minum">Penyediaan Akomodasi dan makan minum</option>
									<option value="Informasi dan Komunikasi">Informasi dan Komunikasi</option>
									<option value="Jasa Keuangan dan Asuransi">Jasa Keuangan dan Asuransi</option>
									<option value="Real Estate">Real Estate</option>
									<option value="Jasa Perusahaan">Jasa Perusahaan</option>
									<option value="Administrasi Pemerintahan, Pertahanan dan Jaminan Sosial Wajib">Administrasi Pemerintahan, Pertahanan dan Jaminan Sosial Wajib</option>
									<option value="Jasa Pendidikan">Jasa Pendidikan</option>
									<option value="Jasa Kesehatan dan Kegiatan Lainnya">Jasa Kesehatan dan Kegiatan Lainnya</option>
									<option value="Pariwisata">Pariwisata</option>
									<option value="Jasa Lainnya">Jasa Lainnya</option>
								</select>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Bentuk Produk / Jasa</label>
							<div class="col-sm-12">
								<input type="text" pattern="[a-zA-Z]"  class="form-control dform  required"   id="hasil_produk" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Apakah sudah Masuk Pasar Ekspor?</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="pasar_ekspor">
									<option value="Ya">Ya</option>
									<option value="Tidak">Tidak</option>
								</select>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label">Jika Ya sejak Tahun Berapa</label>
							<div class="col-sm-12">
								<input type="number"  class="form-control dform "  id="pasar_ekspor_tahun" value="" placeholder="optional" required>
							</div>
							<label for="thedata" class="col-sm-12 control-label">Jika ya, nilai ekspor rata-rata per bulan (Rp)  ?</label>
							<div class="col-sm-12">
								<input type="number"  class="form-control dform "  id="pasar_ekspor_nilai" value="" placeholder="optional" required>
							</div>
							
							
							
							<label for="thedata" class="col-sm-12 control-label">Luas lahan / tempat usaha (m2)</label>
							<div class="col-sm-12">
								<input type="number" class="form-control dform "  id="kelompok_luas_usaha" value="" placeholder="optional" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label">Omset Usaha per Bulan (total kelompok - Rp)</label>
							<div class="col-sm-12">
								<input type="number" class="form-control dform "  id="kelompok_omset" value="" placeholder="optional" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label">Nama Pembeli (inti) Produk/Jasa yang dihasilkan</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform "  id="kelompok_pihak_pembeli" value="" placeholder="optional" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label">Nomor Handphone Pembeli</label>
							<div class="col-sm-12">
								<input type="tel" class="form-control dform "  onchange="cekhpnor(this);" id="kelompok_pihak_pembeli_handphone" value="" placeholder="08xxxxxxxx optional" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label">Nama Suplier (utama) bahan baku produk/jasa yang dihasilkan</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform "  id="kelompok_suplier_produk" value="" placeholder="optional" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label">Nomor Handphone Supplier</label>
							<div class="col-sm-12">
								<input type="tel" class="form-control dform " onchange="cekhpnor(this);" id="kelompok_suplier_handphone" value="" placeholder="08xxxxxxxx optional" required>
							</div>
							
							
							
							
							<label for="thedata" class="col-sm-12 control-label drequired">Sarana / prasarana yang dimiliki saat ini (perlengkapan / mesin atau aset yang mengubah value / bentuk barang - tidak termasuk mobil, gudang, rumah)</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform  required"  id="kebutuhan_sarana_milik" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Kebutuhan sarana / prasarana untuk peningkatan usaha kelompok? (usulan RAB Maks Rp 2 juta)</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="kebutuhan_sarana">
									<option value="Renovasi tempat ibadah">Renovasi tempat ibadah</option>
									<option value="Sarana air bersih (Misal. MCK Umum, Penampungan Air, Pompa Air, Sumur Bor)">Sarana air bersih (Misal. MCK Umum, Penampungan Air, Pompa Air, Sumur Bor)</option>
									<option value="Peralatan penunjang produksi (Misal. Cangkul, Hand Traktor, Hand Press, Alat Bor)">Peralatan penunjang produksi (Misal. Cangkul, Hand Traktor, Hand Press, Alat Bor)</option>
									<option value="Lainnya">Lainnya</option>
								</select>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label">Jika lainnya, kebutuhan sarana / prasarana ? (usulan RAB Maks. Rp 2 juta)</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform "  id="kebutuhan_sarana_lainnya" value="" placeholder="optional" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Kebutuhan Pendidikan & Pelatihan untuk peningkatan usaha kelompok</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="kebutuhan_pendidikan">
									<option value="Kepemimpinan">Kepemimpinan</option>
									<option value="Pola Pikir & Cara Pandang">Pola Pikir & Cara Pandang</option>
									<option value="Budaya Inovasi">Budaya Inovasi</option>
									<option value="Manajemen Pemasaran">Manajemen Pemasaran</option>
									<option value="Manajemen Operasional">Manajemen Operasional</option>
									<option value="Manajemen Keuangan">Manajemen Keuangan</option>
									<option value="Manajemen SDM">Manajemen SDM</option>
									<option value="Legalitas & Kepatuhan">Legalitas & Kepatuhan</option>
									<option value="Kepedulian Sosial & Lingkungan">Kepedulian Sosial & Lingkungan</option>
									<option value="Pemahaman Industri & Pasar">Pemahaman Industri & Pasar</option>
									<option value="Manajemen Rantai Pasok">Manajemen Rantai Pasok</option>
									<option value="Skala Usaha / Ekspor">Skala Usaha / Ekspor</option>
								</select>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Kebutuhan skema kredit / pinjaman BRI ?</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="kebutuhan_skema_kredit">
									<option value="KUR  Mikro">KUR  Mikro</option>
									<option value="KUR Retail">KUR Retail</option>
									<option value="Kredit Kemitraan">Kredit Kemitraan</option>
									<option value="Kupedes">Kupedes</option>
								</select>
							</div>
							<div class="col-sm-12">
							
							
							
							<!-- Isian untuk Ketua Kelompok / Klaster -->
							<label for="thedata" class="col-sm-12 control-label"><h3 align="center">Isian Ketua Kelompok</h3></label></div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Nama Ketua Kelompok / Klaster</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform  required"  id="kelompok_perwakilan" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Jenis Kelamin</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="kelompok_jenis_kelamin">
										<option value="Pria">Pria</option>
										<option value="Wanita">Wanita</option>
									</select>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Alamat Lengkap Usaha</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform  required"  id="lokasi_usaha" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Kode Pos</label>
							<div class="col-sm-12">
								<input type="number" class="form-control dform  required"  id="kode_pos" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Provinsi</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform  required"  id="provinsi" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Kabupaten</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform  required"  id="kabupaten" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Kecamatan</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform  required"  id="kecamatan" value="" placeholder="required" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Kelurahan</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform  required"  id="kelurahan" value="" placeholder="required" required>
							</div>
							
							
							<label for="thedata" class="col-sm-12 control-label drequired">NIK Ketua Kelompok</label>
							<div class="col-sm-12">
								<input type="number" class="form-control dform  required" onchange="cnik(this.value);" id="kelompok_NIK" value="" placeholder="required" required>
							</div>
							<label for="thedata" class="col-sm-12 control-label drequired">Tanggal Lahir Ketua Kelompok</label>
							<div class="col-sm-12">
								<input type="date" data-date-format="DD-MM-YYYY" class="form-control dform  required"  id="kelompok_perwakilan_tgl_lahir" value="" placeholder="required" required>
							</div>
							<label for="thedata" class="col-sm-12 control-label drequired">Tempat Lahir Ketua Kelompok</label>
							<div class="col-sm-12">
								<input type="text" class="form-control dform  required"  id="kelompok_perwakilan_tempat_lahir" value="" placeholder="required" required>
							</div>
							
							
							<label for="thedata" class="col-sm-12 control-label drequired">No Handphone Ketua Kelompok</label>
							<div class="col-sm-12">
								<input type="tel"  onchange="cekhp(this);" class="form-control dform  required"  id="kelompok_handphone" value="" placeholder="08xxxxxxxx (required)" required>
							</div>
							
							
							<label for="thedata" class="col-sm-12 control-label drequired">Sudah Punya Pinjaman?</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="pinjaman">
									<option value="BRI">BRI</option>
									<option value="Bank Lain">Bank Lain</option>
									<option value="Belum Ada">Belum Ada</option>
								</select>
							</div>	
							
							
							
							<label for="thedata" class="col-sm-12 control-label">Jika ada, nominal pinjaman (Rp) ?</label>
							<div class="col-sm-12">
								<input type="number" class="form-control dform "  id="nominal_pinjaman" value="" placeholder="optional" required>
							</div>	
							
							<label for="thedata" class="col-sm-12 control-label">Jika di BRI, Norek Pinjaman BRI?</label>
							<div class="col-sm-12">
								<input type="number" class="form-control dform "  id="norek_pinjaman_bri" value="" placeholder="optional" required>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Sudah Punya Simpanan di Bank ?</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="simpanan_bank">
									<option value="BRI">BRI</option>
									<option value="Bank Lain">Bank Lain</option>
									<option value="Belum Ada">Belum Ada</option>
								</select>
							</div>
							
							<label for="thedata" class="col-sm-12 control-label drequired">Jika di BRI, apakah sudah jadi agen BRILink ?</label>
							<div class="col-sm-12">
								<select class="form-control dform  required"  id="agen_brilink">
									<option value="Ya">Ya</option>
									<option value="Tidak">Tidak</option>
								</select>
							</div>	
							
							</br>
							<label for="thedata" class="col-sm-12 control-label">Dengan ini saya menyatakan bahwa data ini benar adanya sesuai kenyataan di lapangan <input type="checkbox" class="form-check-input form-control-lg"  id="checkvalidkunjungan" required> </label>
							</br>
							<label for="thedata" class="col-sm-12 control-label">Data ini memiliki potensi yang baik untuk meningkatkan bisnis BRI melalui pendekatan komunitas <input type="checkbox" class="form-check-input form-control-lg"  id="checkvalidpotensi" required> </label>
							</br>
						</div>
				</div>
            </div>
				<div class="modal-footer">
						<button class="btn btn-primary waves-effect waves-light" onclick="$('#modal').hide();">Batal</button>
						<button class="btn btn-success waves-effect waves-light" id="sbt" onclick="inputform();">Kirim</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
	 
	 <!-- modal-->
	 
	  <div class="modal " id="modalz" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" onclick="$('#modalz').hide();" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class="modal-title">Form klaster <?php echo $this->session->userdata('nama_uker')?></h5>
					</div>
					<div class="modal-body">
						<div id="mod-content">
							<div class="row">
							<?php 
								$dker='<label for="thedata" class="col-sm-2 control-label">Kode Uker</label><div id="chker"></div>
									<div class="col-sm-12">
											<input type="number" class="form-control"   id="kode_uker_c" onchange="getuker(this.value);" placeholder="required" value="" required>
									</div>';
								echo ($this->session->userdata('permission')>1 ? $dker : ''); 
								?>
									
									<label for="thedata" class="col-sm-12 control-label">Password Baru</label>
									<div class="col-sm-12">
										<input type="password" onchange="myFunction();" class="form-control" placeholder="Password" name="password" id="password" >
										<span class="glyphicon glyphicon-lock form-control-feedback"></span>
									</div> 
									<label for="thedata" class="col-sm-12 control-label">RePassword Baru</label>
									<div class="col-sm-12">
										<input type="password" onchange="myFunction();" class="form-control" placeholder="Confirm Password" name="Cpassword" id="Cpassword">
										<span class="glyphicon glyphicon-lock form-control-feedback"></span>
									</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary waves-effect waves-light" onclick="$('#modalz').hide();">Batal</button>
						<button class="btn btn-success waves-effect waves-light" disabled id="dsubmit" onclick="userm(true);">Kirim</button>
					</div>
				</div>
			</div>
		</div>
			
	 
	
	<script>
		
		var valuker=true;
		var valhp=true;
		var valnik=true;
		
		function getuker(i){
				var data1 = { 
							'kode_uker' :  i,
						};
				$.ajax({ 
						   type:"POST",
						   url: "<?php echo base_url();?>cluster/cekuker",
						   data: data1,
						   success:function(smsg){
								var msg=JSON.parse(smsg);
								document.getElementById("hsuk").innerHTML='<label for="thedata" class="col-sm-8 control-label">'+msg+'</label>';
								document.getElementById("chker").innerHTML='<label for="thedata" class="col-sm-8 control-label">'+msg+'</label>';
								valuker=(msg=="data uker tidak ditemukan" ? false : true);
							}
					});
		}
		
		
		
		function getform(i=null){
			$("#sbt").removeAttr("disabled");
			document.getElementById("checkvalidpotensi").checked = false;
			document.getElementById("checkvalidkunjungan").checked = false;
			if (i!=null){
				var data1 = { 
							'id' :  i,
						};
				$.ajax({ 
						   type:"POST",
						   url: "<?php echo base_url();?>cluster/getdata_s",
						   data: data1,
						   success:function(nmsg){
								var msg=JSON.parse(nmsg);
							    document.getElementById('id').value=msg[0].id;
							    document.getElementById('kode_uker').value=msg[0].kode_uker;
								getuker(msg[0].kode_uker);
								
								document.getElementById('kaunit_nama').value=msg[0].kaunit_nama;
							    document.getElementById('kaunit_pn').value=msg[0].kaunit_pn;
							    document.getElementById('kaunit_handphone').value=msg[0].kaunit_handphone;
								
							    document.getElementById('nama_pekerja').value=msg[0].nama_pekerja;
							    document.getElementById('personal_number').value=msg[0].personal_number;
							    document.getElementById('handphone_pekerja').value=msg[0].handphone_pekerja;
								
								
							    document.getElementById('kelompok_usaha').value=msg[0].kelompok_usaha;
							    document.getElementById('kelompok_jumlah_anggota').value=msg[0].kelompok_jumlah_anggota;
							    document.getElementById('kelompok_perwakilan').value=msg[0].kelompok_perwakilan;
							    document.getElementById('kelompok_jenis_kelamin').value=msg[0].kelompok_jenis_kelamin;
							    document.getElementById('kelompok_NIK').value=msg[0].kelompok_NIK;
								cnik(msg[0].kelompok_NIK,true);
							    document.getElementById('kelompok_perwakilan_tgl_lahir').value=msg[0].kelompok_perwakilan_tgl_lahir;
							    document.getElementById('kelompok_perwakilan_tempat_lahir').value=msg[0].kelompok_perwakilan_tempat_lahir;
							    document.getElementById('kelompok_handphone').value=msg[0].kelompok_handphone;
							    document.getElementById('lokasi_usaha').value=msg[0].lokasi_usaha;
							    document.getElementById('kode_pos').value=msg[0].kode_pos;
							    document.getElementById('provinsi').value=msg[0].provinsi;
							    document.getElementById('kabupaten').value=msg[0].kabupaten;
							    document.getElementById('kecamatan').value=msg[0].kecamatan;
							    document.getElementById('kelurahan').value=msg[0].kelurahan;
							    document.getElementById('sektor_usaha').value=msg[0].sektor_usaha;
							    document.getElementById('jenis_usaha').value=msg[0].jenis_usaha;
								
							    document.getElementById('pasar_ekspor').value=msg[0].pasar_ekspor;
							    document.getElementById('pasar_ekspor_tahun').value=msg[0].pasar_ekspor_tahun;
							    document.getElementById('pasar_ekspor_nilai').value=msg[0].pasar_ekspor_tahun;
								
							    document.getElementById('kelompok_anggota_pinjaman').value=msg[0].kelompok_anggota_pinjaman;
							    document.getElementById('hasil_produk').value=msg[0].hasil_produk;
								document.getElementById('kelompok_pihak_pembeli').value=msg[0].kelompok_pihak_pembeli;
								document.getElementById('kelompok_pihak_pembeli_handphone').value=msg[0].kelompok_pihak_pembeli_handphone;
								document.getElementById('kelompok_suplier_produk').value=msg[0].kelompok_suplier_produk;
								document.getElementById('kelompok_suplier_handphone').value=msg[0].kelompok_suplier_handphone;
								document.getElementById('kelompok_luas_usaha').value=msg[0].kelompok_luas_usaha;
								document.getElementById('kelompok_omset').value=msg[0].kelompok_omset;
							    document.getElementById('pinjaman').value=msg[0].pinjaman;
								document.getElementById('nominal_pinjaman').value=msg[0].nominal_pinjaman;
							    document.getElementById('norek_pinjaman_bri').value=msg[0].norek_pinjaman_bri;
							    document.getElementById('agen_brilink').value=msg[0].agen_brilink;
							    
								document.getElementById('kebutuhan_sarana_milik').value=msg[0].kebutuhan_sarana_milik;
								document.getElementById('kebutuhan_sarana').value=msg[0].kebutuhan_sarana;
							    document.getElementById('kebutuhan_sarana_lainnya').value=msg[0].kebutuhan_sarana_lainnya;
							    document.getElementById('kebutuhan_skema_kredit').value=msg[0].kebutuhan_skema_kredit;
							    
								document.getElementById('kebutuhan_pendidikan').value=msg[0].kebutuhan_pendidikan;
								document.getElementById('simpanan_bank').value=msg[0].simpanan_bank;
								$('#modal').show();
							}
					});
			}
			else {
				var dd = $('.form-control');
				document.getElementById('setuker').innerHTML="";
				for (var j=0;j<dd.length;j++){
					dd[j].value = "";
					valnik=false;
					valhp=false;
					$('#modal').show();
				}
				document.getElementById('kode_uker').value="<?php echo $this->session->userdata('kode_uker');?>";
				document.getElementById('kelompok_jumlah_anggota').value="15";
			}
		}
		
		function userm(i=false){
			if (i==false){
				var dd = $('.form-control');
				for (var j=0;j<dd.length;j++){
					dd[j].value = "";
				}
				$('#modalz').show();
			}
			else {
				var data1 = { 
							'kode_uker_c' 	:  $('#kode_uker_c').val(),
							'password'			: $('#password').val()
						};
				$.ajax({ 
						   type:"POST",
						   url: "<?php echo base_url();?>login/chpassuker",
						   data: data1,
						   success:function(smsg){
							   alert('ganti password uker berhasil');
								$('#modalz').hide();
							}
					});
			}
		}
		
		function inputform(){
			var data1={};
			var dform=document.getElementsByClassName('dform');
			for (var i=0;i<dform.length;i++){
				data1[dform[i].id]=dform[i].value;
			}	
			
			if (document.getElementById("checkvalidkunjungan").checked == true && document.getElementById("checkvalidpotensi").checked == true){
					if (valuker==true){
						reval();
						if (valnik==true){
							if (valhp==true){
								var msg="";
								var z=0;
								var form=document.getElementsByClassName('required');
								var label=document.getElementsByClassName('drequired');
								for (var i=0; i<form.length; i++){
									if(form[i].value==""){
											alert("form "+label[i].innerHTML+" tidak boleh kosong");
											z=z+1;
											i=form.length;
									}
								}
								if (z==0) {
									$("#sbt").attr("disabled", "disabled");
									$.ajax({ 
											   type:"POST",
											   url: "<?php echo base_url();?>cluster/inputdata",
											   data: data1,
											   success:function(msg){
												  alert('data berhasil diinput');
												  $("#sbt").removeAttr("disabled");
												  $('#modal').hide();
												  $('#example').DataTable().ajax.reload(null, false);
												}
										});
								}
							}
							else alert('data Handphone salah');
						}
						else alert("Data NIK Ketua Kelompok Tidak Valid");
					}
					else alert("Data Uker salah");
				}
			else alert ("Harap isi checkbox pertanyaan diatas!!")
		}
		
		
		
		function cnik(i=null,j=null){
			var validator=["0000000000000000","1111111111111111","2222222222222222","3333333333333333","4444444444444444","5555555555555555","6666666666666666","7777777777777777","8888888888888888","9999999999999999"];
			// return true;
			if (i!=null){
				if (i.toString().length==16){
					if (validator.includes(i.toString)==false){
						return true;
					}
					else {
						if (j==null){
							alert ('Data NIK tidak valid');
						}
						return false;
					}
				}
				else {
					if (j==null){
						alert ('NIK harus 16 digit');
					}
					return false;
				}
			}
			else return false;
		}
		
		
		function cekhp(i,j=null){
					if (j==null) i=i.value;
					//console.log(i);
					var number=/^[0-9]+$/;
					var res = i.substring(0, 2);
					if (i==null || i==""){
						if (j==null) alert ('nomer handphone tidak boleh kosong')
						return false;
					}
					else if (!i.match(number)){
						if (j==null) alert ("nomer handphone  harus angka");
						return false;
						
					}
					else if (i.length<8){
						if (j==null)  alert ("nomor handphone tidak valid");
						return false;
					}
					else if (res!="08"){
						if (j==null) alert (d.name+" Harus diawali 08");
						return false;
					}
					else return true;
		}
		
		function reval(){
			valhp= (cekhp($('#kaunit_handphone').val(), true)==true && cekhp($('#handphone_pekerja').val(), true)==true && cekhp($('#kelompok_handphone').val(), true)==true ? true : false );
			valnik=(cnik($('#kelompok_NIK').val(), true)==true ?  true : false);
			
		}
		
		
		function cekhpnor(i){
			var number=/^[0-9]+$/;
			var res = i.value.substring(0, 2);
			
			if (!i.value.match(number)){
				alert ("nomer handphone harus angka");
			}
			else if (i.value.length<8){
				alert ("nomor handphone tidak valid");
			}
		}
		
		function deldata(i){
			if (confirm('Apakah anda yakin akan menghapus data ini?')){
				var data1={ 
							'id' :  i,
						};
				$.ajax({ 
						   type:"POST",
						   url: "<?php echo base_url();?>cluster/deldata",
						   data: data1,
						   success:function(msg){
							  alert('data berhasil dihapus');
							  $('#example').DataTable().ajax.reload(null, false);
							}
					});
			}
		}
		
		function myFunction() {
				var pass1 = $("#password").val();
				var pass2 = $("#Cpassword").val();
				if (pass1 !== pass2) {
					document.getElementById("password").style.borderColor = "#E34234";
					document.getElementById("Cpassword").style.borderColor = "#E34234";
					$("#dsubmit").attr("disabled", "disabled");
				}
				else {
					document.getElementById("password").style.borderColor = "";
					document.getElementById("Cpassword").style.borderColor = "";
					$("#dsubmit").removeAttr("disabled");
				}
			}
	
		
	
	</script>
	
	
       