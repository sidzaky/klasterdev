<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Data Klaster BRIspot 0.3
			<?php echo $this->session->userdata('name_uker'); ?>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="box box-solid">
			<div id="result" class="box-body">
				<div class="container-fluid control-box">
					<div class="row">
						<button class="btn btn-success waves-effect waves-light btn-sm" onclick="getform()" type="button"><i class="fa fa-plus"></i> Tambah Data</button>
						<button class="btn btn-primary waves-effect waves-light btn-sm" onclick="window.open('cluster/dldata')" type="button"><i class="fa fa-download"></i> Download All Data</button>
						<?php
						if ($this->session->userdata('permission') > 2) {
							echo '<button class="btn btn-info waves-effect waves-light btn-sm" onclick="window.open(\'\cluster/report_unit\')" type="button"><i class="fa fa-info"></i> Rekap unit</button> ';
							echo '<button class="btn btn-info waves-effect waves-light btn-sm" onclick="window.open(\'\cluster/getreport/harian\')" type="button"><i class="fa fa-info"></i> Laporan Harian</button> ';
						}
						if ($this->session->userdata('permission') > 3) {
							echo '<button class="btn btn-info waves-effect waves-light btn-sm" onclick="window.open(\'cluster/getreport/\')" type="button"><i class="fa fa-info"></i> Report akhir</button>';
						}
						?>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						$('#table-cluster').DataTable({
							"scrollX": true,
							"processing": true,
							"serverSide": true,
							"deferRender": true,
							"ajax": {
								"url": "./cluster/getdata",
								"type": "POST"
							},

						});
					});
				</script>
				<div class="table-responsive">
					<table id="table-cluster" class="table table-striped table-bordered" width="100%">
						<thead>
							<tr>
								<th>No</th>
								<th>Kantor Wilayah</th>
								<th>Nama Kanca</th>
								<th>Nama Uker</th>
								<th>Nama Kelompok Usaha</th>
								<th>Jml / Input Anggota </th>
								<th>Jenis Usaha</th>
								<th>Bentuk Produk/Jasa</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- Modal -->
<style>
	.modal-body {
		max-height: calc(100vh - 200px);
		overflow-y: auto;
	}

	.btn-file {
		position: relative;
		overflow: hidden;
	}

	.btn-file input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		min-width: 100%;
		min-height: 100%;
		font-size: 100px;
		text-align: right;
		filter: alpha(opacity=0);
		opacity: 0;
		outline: none;
		background: white;
		cursor: inherit;
		display: block;
	}

	.img-upload {
		width: 100%;
	}
</style>
<div class="modal " id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#modal').hide();" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h5 class="modal-title">Form klaster <?php echo $this->session->userdata('nama_uker') ?></h5>
			</div>
			<div class="modal-body">
				<div id="mod-content">
					<form>
						<div class="col-sm-12">
							<label for="thedata" class="col-sm-12 control-label">
								<h3 align="center">Isian terkait Unit BRI</h3>
							</label>
						</div>

						<div class="form-group" style="width: 0">
							<label style="padding:0;" for="thedata" class="col-sm-10 control-label" id="setuker"></label>
							<input type="hidden" class="form-control dform" id="id" placeholder="required" value="">
						</div>

						<div class="form-group required">
							<label class="control-label">Kode Uker</label>
							<div id="hsuk"></div>
							<input type="number" class="form-control dform" name="kode uker" <?php echo ($this->session->userdata('permission') > 1 ? '' : 'disabled') ?> id="kode_uker" onchange="getuker(this.value);" placeholder="required" value="<?php echo $this->session->userdata('kode_uker'); ?>" required>
						</div>

						<div class="form-group required">
							<label class="control-label">Nama Kaunit BRI</label>
							<input type="text" pattern="[a-zA-Z]" class="form-control dform required" id="kaunit_nama" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">PN Kaunit</label>
							<input type="number" class="form-control dform required" id="kaunit_pn" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">No Handphone Kaunit</label>
							<input type="text" pattern="[a-zA-Z]" class="form-control dform required" onchange="cekhp(this);" id="kaunit_handphone" value="" placeholder="08xxxxxxxx (required)" required>
						</div>

						<!-- Mantriii -->
						<div class="form-group required">
							<label class="control-label">Nama Mantri / Pekerja BRI (Pembina Klaster)</label>
							<input type="text" pattern="[a-zA-Z]" class="form-control dform required" id="nama_pekerja" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">PN Mantri / Pekerja BRI (Pembina Klaster)</label>
							<input type="number" class="form-control dform required" id="personal_number" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">No Handphone Mantri / Pekerja BRI (Pembina Klaster)</label>
							<input type="text" pattern="[a-zA-Z]" class="form-control dform required" id="handphone_pekerja" value="" placeholder="08xxxxxxxx (required)" required>
						</div>

						<!-- Kelompok Usaha -->

						<div class="col-sm-12">
							<label for="thedata" class="col-sm-12 control-label">
								<h3 align="center">Isian terkait Kelompok Usaha / Klaster</h3>
							</label>
						</div>

						<div class="form-group required">
							<label class="control-label">Nama Kelompok Usaha / Klaster</label>
							<input type="text" pattern="[a-zA-Z]" class="form-control dform required" id="kelompok_usaha" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">Jumlah Anggota (orang)</label>
							<input type="number" min="15" class="form-control dform required" id="kelompok_jumlah_anggota" value="" placeholder="required" required>
						</div>

						<div class="form-group">
							<label class="control-label">Sudah Punya Pinjaman?</label>
							<select class="form-control dform required" id="kelompok_anggota_pinjaman">
								<option value="Seluruh anggota sudah punya pinjaman">Seluruh anggota sudah punya pinjaman</option>
								<option value="Lebih dari 50% anggota punya pinjaman">Lebih dari 50% anggota punya pinjaman</option>
								<option value="Kurang dari 50% anggota punya pinjaman">Kurang dari 50% anggota punya pinjaman</option>
								<option value="Seluruh anggota belum punya pinjaman">Seluruh anggota belum punya pinjaman</option>
							</select>
						</div>

						<div class="form-group required">
							<label class="control-label">Sektor Usaha</label>
							<select class="form-control dform required" required onchange="fjum(this);" id="sektor_usaha">
								<option value="1">Produksi</option>
								<option value="2">Non Produksi</option>
							</select>
						</div>

						<div class="form-group">
							<label class="control-label">Kategori Jenis Usaha</label>
							<select class="form-control dform required" onchange="fju(this);" id="jenis_usaha_map">
							</select>
						</div>

						<div class="form-group">
							<label class="control-label drequired">Jenis Usaha</label>
							<select class="form-control dform required" id="jenis_usaha">
							</select>
						</div>

						<div class="form-group">
							<label class="control-label drequired">Bentuk Produk / Jasa</label>
							<input type="text" pattern="[a-zA-Z]" onchange="validatorreqtext(this, iname, this.id)" class="form-control dform  required" id="hasil_produk" value="" placeholder="required" required>
						</div>

						<div class="form-group">
							<label class="control-label drequired">Apakah sudah Masuk Pasar Ekspor?</label>
							<select class="form-control dform  required" id="pasar_ekspor" onchange="te(this);">
								<option value="Ya">Ya</option>
								<option value="Tidak" default>Tidak</option>
							</select>
						</div>

						<div class="form-group">
							<label class="control-label">Jika Ya sejak Tahun Berapa</label>
							<input type="number" class="form-control dform " id="pasar_ekspor_tahun" value="" placeholder="optional" required>
						</div>

						<div class="form-group">
							<label class="control-label">Jika ya, nilai ekspor rata-rata per bulan (Rp) ?</label>
							<input type="number" class="form-control dform " id="pasar_ekspor_nilai" value="" placeholder="optional" required>
						</div>

						<div class="form-group">
							<label class="control-label drequired">Foto/Dokument Ekspor</label>
							<button class="btn btn-primary waves-effect waves-light btn-sm" id="bfex" onclick="tambahform('fex');"><i class="fa fa-plus"></i> Tambah Foto Ekspor</button>
							<div id="fotoverifikasiexpor"></div>
						</div>

						<div class="form-group">
							<label class="control-label">Luas lahan / tempat usaha (m2)</label>
							<input type="number" class="form-control dform" id="kelompok_luas_usaha" value="" placeholder="optional" required>
						</div>

						<div class="form-group">
							<label class="control-label">Omset Usaha per Bulan (total kelompok - Rp)</label>
							<input type="number" class="form-control dform" id="kelompok_omset" value="" placeholder="optional" required>
						</div>

						<div class="form-group">
							<label class="control-label">Nama Pembeli (inti) Produk/Jasa yang dihasilkan</label>
							<input type="text" class="form-control dform" id="kelompok_pihak_pembeli" onchange="validatoropttext(this,ischar,this.id)" value="" placeholder="optional" required>
						</div>

						<div class="form-group">
							<label class="control-label">Nomor Handphone Pembeli</label>
							<input type="tel" class="form-control dform" onchange="cekhpnor(this);" id="kelompok_pihak_pembeli_handphone" value="" placeholder="08xxxxxxxx optional" required>
						</div>

						<div class="form-group">
							<label class="control-label">Nama Suplier (utama) bahan baku produk/jasa yang dihasilkan</label>
							<input type="text" class="form-control dform" id="kelompok_suplier_produk" value="" placeholder="optional" required>
						</div>

						<div class="form-group">
							<label class="control-label">Nama Suplier (utama) bahan baku produk/jasa yang dihasilkan</label>
							<input type="text" class="form-control dform" id="kelompok_suplier_produk" value="" placeholder="optional" required>
						</div>

						<div class="form-group">
							<label class="control-label">Nama Suplier (utama) bahan baku produk/jasa yang dihasilkan</label>
							<input type="text" class="form-control dform" id="kelompok_suplier_produk" value="" placeholder="optional" required>
						</div>

						<div class="form-group">
							<label class="control-label">Nomor Handphone Supplier</label>
							<input type="tel" class="form-control dform" onchange="cekhpnor(this);" id="kelompok_suplier_handphone" value="" placeholder="08xxxxxxxx optional" required>
						</div>

						<div class="form-group">
							<label class="control-label drequired">Sarana / prasarana yang dimiliki saat ini (perlengkapan / mesin atau aset yang mengubah value / bentuk barang - tidak termasuk mobil, gudang, rumah)</label>
							<input type="text" class="form-control dform required" id="kebutuhan_sarana_milik" value="" placeholder="required" required>
						</div>

						<div class="form-group">
							<label class="control-label drequired">Kebutuhan sarana / prasarana untuk peningkatan usaha kelompok? (usulan RAB Maks Rp 2 juta)</label>
							<select class="form-control dform required" id="kebutuhan_sarana">
								<option value="Renovasi tempat ibadah">Renovasi tempat ibadah</option>
								<option value="Sarana air bersih (Misal. MCK Umum, Penampungan Air, Pompa Air, Sumur Bor)">Sarana air bersih (Misal. MCK Umum, Penampungan Air, Pompa Air, Sumur Bor)</option>
								<option value="Peralatan penunjang produksi (Misal. Cangkul, Hand Traktor, Hand Press, Alat Bor)">Peralatan penunjang produksi (Misal. Cangkul, Hand Traktor, Hand Press, Alat Bor)</option>
								<option value="Lainnya">Lainnya</option>
							</select>
						</div>

						<div class="form-group">
							<label class="control-label">Jika lainnya, kebutuhan sarana / prasarana ? (usulan RAB Maks. Rp 2 juta)</label>
							<input type="text" class="form-control dform" id="kebutuhan_sarana_lainnya" value="" placeholder="optional misal cangkul, pasak, dll" required>
						</div>

						<div class="form-group">
							<label class="control-label drequired">Kebutuhan Pendidikan & Pelatihan untuk peningkatan usaha kelompok</label>
							<select class="form-control dform required" id="kebutuhan_pendidikan">
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

						<div class="form-group required">
							<label class="control-label">Kebutuhan skema kredit / pinjaman BRI ?</label>
							<select class="form-control dform required" id="kebutuhan_skema_kredit">
								<option value="KUR  Mikro">KUR Mikro</option>
								<option value="KUR Retail">KUR Retail</option>
								<option value="Kredit Kemitraan">Kredit Kemitraan</option>
								<option value="Kupedes">Kupedes</option>
							</select>
						</div>

						<div class="form-group">
							<label class="control-label">Cerita Terkait Usaha</label>
							<textarea type="text" class="form-control dform required" id="kelompok_cerita_usaha" value="" placeholder="Ceritakan Sedikit terkait Kelompok Usaha"></textarea>
						</div>

						<div class="form-group">
							<label class="control-label">Foto Kluster Usaha</label>
							<button class="btn btn-primary waves-effect waves-light btn-sm" onclick="tambahform('fku');"><i class="fa fa-plus"></i> Tambah Foto</button></label>
							<div id="fotoklusterusaha" class="col-sm-12"></div>
						</div>

						<!-- Isian untuk Ketua Kelompok / Klaster -->
						<label for="thedata" class="col-sm-12 control-label">
							<h3 align="center">Isian Ketua Kelompok</h3>
						</label>

						<div class="form-group required">
							<label class="control-label">Nama Ketua Kelompok / Klaster</label>
							<input type="text" class="form-control dform required" id="kelompok_perwakilan" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">Jenis Kelamin</label>
							<select class="form-control dform required" id="kelompok_jenis_kelamin">
								<option value="Pria">Pria</option>
								<option value="Wanita">Wanita</option>
							</select>
						</div>

						<div class="form-group required">
							<label class="control-label">Alamat Lengkap Usaha</label>
							<input type="text" class="form-control dform required" id="lokasi_usaha" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">Provinsi</label>
							<select class="form-control dform required" onchange="getkotakab(this.value);" id="provinsi">
								<?php foreach ($provinsi as $row) {
									echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
								} ?>
							</select>
						</div>

						<div class="form-group required">
							<label class="control-label">Kabupaten</label>
							<div id="selkab">
								<select class="form-control dform required" onchange="getkecamatan(this.value)" id="kabupaten">

								</select>
							</div>
						</div>

						<div class="form-group required">
							<label class="control-label">Kecamatan</label>
							<div id="selkec">
								<select class="form-control dform required" onchange="getkelurahan(this.value)" id="kecamatan">

								</select>
							</div>
						</div>

						<div class="form-group required">
							<label class="control-label">Kelurahan</label>
							<div id="selkel">
								<select class="form-control dform required" id="kelurahan">

								</select>
							</div>
						</div>

						<div class="form-group required">
							<label class="control-label">Kode pos</label>
							<input type="number" class="form-control required" id="kode_pos" value="" placeholder="required" required disabled>
						</div>

						<div class="form-group required">
							<label class="control-label">NIK Ketua Kelompok</label>
							<input type="number" class="form-control dform required" onchange="cnik(this.value);" id="kelompok_NIK" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">Tanggal Lahir Ketua Kelompok</label>
							<input type="date" data-date-format="DD-MM-YYYY" class="form-control dform required" id="kelompok_perwakilan_tgl_lahir" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">Tempat Lahir Ketua Kelompok</label>
							<input type="text" class="form-control dform required" id="kelompok_perwakilan_tempat_lahir" value="" placeholder="required" required>
						</div>

						<div class="form-group required">
							<label class="control-label">No Handphone Ketua Kelompok</label>
							<input type="tel" onchange="cekhp(this);" class="form-control dform required" id="kelompok_handphone" value="" placeholder="08xxxxxxxx (required)" required>
						</div>

						<div class="form-group required">
							<label class="control-label">Sudah Punya Pinjaman?</label>
							<select class="form-control dform required" id="pinjaman" required>
								<option value="BRI">BRI</option>
								<option value="Bank Lain">Bank Lain</option>
								<option value="Belum Ada">Belum Ada</option>
							</select>
						</div>

						<div class="form-group">
							<label class="control-label">Jika ada, nominal pinjaman (Rp) ?</label>
							<input type="number" class="form-control dform" id="nominal_pinjaman" value="" placeholder="optional">
						</div>

						<div class="form-group">
							<label class="control-label">Jika di BRI, Norek Pinjaman BRI?</label>
							<input type="number" class="form-control dform" id="norek_pinjaman_bri" value="" placeholder="optional">
						</div>

						<div class="form-group">
							<label class="control-label">Sudah Punya Simpanan di Bank ?</label>
							<select class="form-control dform required" id="simpanan_bank">
								<option value="BRI">BRI</option>
								<option value="Bank Lain">Bank Lain</option>
								<option value="Belum Ada">Belum Ada</option>
							</select>
						</div>

						<div class="form-group">
							<label class="control-label">Jika di BRI, apakah sudah jadi agen BRILink ?</label>
							<select class="form-control dform" id="agen_brilink">
								<option value="Ya">Ya</option>
								<option value="Tidak">Tidak</option>
							</select>
						</div>

						<div class="form-group">
							<input type="checkbox" class="form-check-input form-control-lg" id="checkvalidkunjungan" required>
							<b>Dengan ini saya menyatakan bahwa data ini benar adanya sesuai kenyataan di lapangan</b>
						</div>

						<div class="form-group">
							<input type="checkbox" class="form-check-input form-control-lg" id="checkvalidpotensi" required>
							<b>Data ini memiliki potensi yang baik untuk meningkatkan bisnis BRI melalui pendekatan komunitas</b>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary waves-effect waves-light" onclick="$('#modal').hide();">Batal</button>
				<button class="btn btn-success waves-effect waves-light" id="sbt" onclick="inputform();">Kirim</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if ($this->session->userdata('notif') == 1) { ?>
	<div class="modal " id="modalnotif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" onclick="$('#modalnotif').hide();" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title">Notif <?php echo $this->session->userdata('nama_uker') ?></h5>
				</div>
				<div class="modal-body">
					<div id="mod-content">
						<title>Site Maintenance</title>
						<h2>Update Klaster Binaan BRI 0.3 4 Juli 2020</h2>
						<h4>04 Juli 2020</h4>
						<div>
							<ul>
								<li>Terhitung tanggal 6 Juli 2020, alamat "https://tinyurl.com/s4gxhba" akan dimatikan dan berpindah menuju halaman "https://www.klasterkuhidupku.com"</li>
								<li>Tambahan Form Upload Foto Klaster Usaha </li>
								<li>Tambahan Form Upload Foto dokument Ekspor (optional)</li>
								<li>Tambahan Form Cerita kelompok Usaha</li>
							</ul>
						</div>
						<h4>MAJOR UPDATE 2 Februari 2020</h4>
						<div>
							<ul>
								<li>Perbaikan fungsi Upload Anggota Menggunakan Excel</li>
								<li>Halaman ini Bejalan Lebih baik jika menggunakan Browser Firefox</li>
							</ul>
						</div>
						<h4>04 Januari 2020</h4>
						<div>
							<ul>
								<li>Terhitung tanggal 5 Juli 2020, alamat "https://tinyurl.com/s4gxhba" akan dimatikan dan berpindah menuju halaman https://www.klasterkuhidupku.com</li>
								<li></li>
								<li>Mohon Cek kembali terkait data provinsi, kabupaten/kota, kecamatan dan kelurahan setelah update 26 Januari 2020</li>
								<li>Pada Tabel Kluster, Kolom Jml/Input Anggota adalah jumlah data berbanding data yang telah diinput di dalam halaman Anggota</li>
								<li>Terdapat Pembaharuan pada Klasifikasi data Jenis usaha</li>
								<li>Halaman anggota untuk menginput data anggota pada data kluster</li>
								<li>Anggota dapat diinput manual atau diinput menggunakan template excel yang telah disediakan</li>
							</ul>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary waves-effect waves-light" onclick="endnotif();">close</button>
			</div>
		</div>
	</div>
	</div>
	<script>
		function fjum(i) {
			var data1 = {
				'id_cluster_sektor_usaha': i.value
			};
			$.ajax({
				type: "POST",
				url: "./cluster/fjum",
				data: data1,
				success: function(smsg) {
					var msg = JSON.parse(smsg);
					var select = document.getElementById('jenis_usaha_map');
					$(select).empty();
					$(select).append('<option> Pilih Kategori Usaha</option>');
					for (var i = 0; i <= msg.length; i++) {
						$(select).append('<option value="' + msg[i]['id_cluster_jenis_usaha_map'] + '">' + msg[i]['nama_cluster_jenis_usaha_map'] + '</option>');
					}
				}
			});
		}

		function fju(i) {
			var data1 = {
				'id_cluster_jenis_usaha_map': i.value,
			};
			$.ajax({
				type: "POST",
				url: "./cluster/fju",
				data: data1,
				success: function(smsg) {
					var msg = JSON.parse(smsg);
					var select = document.getElementById('jenis_usaha');
					$(select).empty();
					$(select).append('<option> Pilih Jenis Usaha</option>')
					for (var i = 0; i <= msg.length; i++) {
						$(select).append('<option value="' + msg[i]['id_cluster_jenis_usaha'] + '">' + msg[i]['nama_cluster_jenis_usaha'] + '</option>');
					}
				}
			});
		}

		function te(i) {
			if (i.value === "Ya") {
				$("#pasar_ekspor_tahun").removeAttr("disabled");
				$("#pasar_ekspor_nilai").removeAttr("disabled");
				$("#bfex").removeAttr("disabled");

			} else {
				$("#pasar_ekspor_tahun").attr("disabled", "disabled");
				$("#pasar_ekspor_nilai").attr("disabled", "disabled");
				$("#bfex").attr("disabled", "disabled");
			}
		}

		function tambahform(id) {
			var count = $('.' + id);
			var newid;
			var ccount = count.length == 0 ? 0 : count.length;
			if (count.length == 0) newid = 0
			else {
				count = count[(count.length) - 1].id.split("_");
				newid = parseInt(count[1]) + 1;
			}

			switch (id) {
				case ('fku'):
					if (ccount < 5) vfku(newid);
					break;
				case ('fex'):
					if (ccount < 3) vfex(newid);
					break;
			}
		}
	</script>
<?php }

?>

<script src="./assets/js/send.js"></script>

<script>
	function tambahform(id) {
		var count = $('.' + id);
		var newid;
		var ccount = count.length == 0 ? 0 : count.length;
		if (count.length == 0) newid = 0
		else {
			count = count[(count.length) - 1].id.split("_");
			newid = parseInt(count[1]) + 1;
		}

		switch (id) {
			case ('fku'):
				if (ccount < 5) vfku(newid);
				break;
			case ('fex'):
				if (ccount < 3) vfex(newid);
				break;
		}
	}

	function minform(id) {
		$('#' + id).remove();
	}


	function readURL(input, j) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			var typeimages = ["jpg", "jpeg", "png", "bmp"];
			if (j == "cku_0") typeimages = ["txt, pdf, word"];
			var typedoc = ["text/plain", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
			reader.onload = function(e) {
				// console.log(input.files[0].type.toLowerCase());
				if (typeimages.includes(input.files[0].type.replace('image/', "").toLowerCase()) == true) {
					$('#sh' + j).attr('src', e.target.result);
					$('#t' + j).attr('value', input.files[0].type.replace('image/', ""));
					processImage(reader.result, input.files[0].type, j);
				} else alert("type file tidak ada yang didukung")
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	function processImage(dataURL, fileType, j) {
		var maxWidth = 1920;
		var maxHeight = 1080;
		var image = new Image();
		image.src = dataURL;
		image.onload = function() {
			var width = image.width;
			var height = image.height;
			var shouldResize = (width > maxWidth) || (height > maxHeight);
			if (!shouldResize) {
				document.getElementById('r' + j).value = dataURL.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
				return;
			}
			var newWidth;
			var newHeight;
			if (width > height) {
				newHeight = height * (maxWidth / width);
				newWidth = maxWidth;
			} else {
				newWidth = width * (maxHeight / height);
				newHeight = maxHeight;
			}
			var canvas = document.createElement('canvas');
			canvas.width = newWidth;
			canvas.height = newHeight;
			var context = canvas.getContext('2d');
			context.drawImage(this, 0, 0, newWidth, newHeight);
			dataURL = canvas.toDataURL(fileType);
			document.getElementById('r' + j).value = dataURL.replace(/^data:image\/(png|jpg|jpeg);base64,/, "");
		};
		image.onerror = function() {
			alert('There was an error processing your file!');
		};
	}


	var valuker = true;
	var valhp = true;
	var valnik = true;

	function getuker(i) {
		var data1 = {
			'kode_uker': i,
		};
		$.ajax({
			type: "POST",
			url: "./cluster/cekuker",
			data: data1,
			success: function(smsg) {
				var msg = JSON.parse(smsg);
				document.getElementById("hsuk").innerHTML = '<label for="thedata" class="col-sm-8 control-label">' + msg + '</label>';
				document.getElementById("chker").innerHTML = '<label for="thedata" class="col-sm-8 control-label">' + msg + '</label>';
				valuker = (msg == "data uker tidak ditemukan" ? false : true);
			}
		});
	}

	function getform(i = null) {
		$("#sbt").removeAttr("disabled");
		document.getElementById("checkvalidpotensi").checked = false;
		document.getElementById("checkvalidkunjungan").checked = false;
		document.getElementById('fotoklusterusaha').innerHTML = "";
		document.getElementById('fotoverifikasiexpor').innerHTML = "";
		if (i != null) {
			var data1 = {
				'id': i,
			};
			$.ajax({
				type: "POST",
				url: "./cluster/getdata_s",
				data: data1,
				success: function(nmsg) {
					var tempdata = JSON.parse(nmsg);
					var msg = tempdata.cluster;
					//data cluster//
					document.getElementById('id').value = msg[0].id;
					document.getElementById('kode_uker').value = msg[0].kode_uker;
					getuker(msg[0].kode_uker);

					document.getElementById('kaunit_nama').value = msg[0].kaunit_nama;
					document.getElementById('kaunit_pn').value = msg[0].kaunit_pn;
					document.getElementById('kaunit_handphone').value = msg[0].kaunit_handphone;

					document.getElementById('nama_pekerja').value = msg[0].nama_pekerja;
					document.getElementById('personal_number').value = msg[0].personal_number;
					document.getElementById('handphone_pekerja').value = msg[0].handphone_pekerja;


					document.getElementById('kelompok_usaha').value = msg[0].kelompok_usaha;
					document.getElementById('kelompok_jumlah_anggota').value = msg[0].kelompok_jumlah_anggota;
					document.getElementById('kelompok_perwakilan').value = msg[0].kelompok_perwakilan;
					document.getElementById('kelompok_jenis_kelamin').value = msg[0].kelompok_jenis_kelamin;

					document.getElementById('kelompok_NIK').value = msg[0].kelompok_NIK;
					document.getElementById('kelompok_perwakilan_tgl_lahir').value = msg[0].kelompok_perwakilan_tgl_lahir;
					document.getElementById('kelompok_perwakilan_tempat_lahir').value = msg[0].kelompok_perwakilan_tempat_lahir;
					document.getElementById('kelompok_handphone').value = msg[0].kelompok_handphone;
					document.getElementById('lokasi_usaha').value = msg[0].lokasi_usaha;


					setprov(msg[0].provinsi);
					getkotakab(msg[0].provinsi, msg[0].kabupaten);
					getkecamatan(msg[0].kabupaten, msg[0].kecamatan);
					getkelurahan(msg[0].kecamatan, msg[0].kelurahan);


					document.getElementById('sektor_usaha').value = msg[0].sektor_usaha;
					document.getElementById('jenis_usaha').value = msg[0].jenis_usaha;

					document.getElementById('pasar_ekspor').value = msg[0].pasar_ekspor;
					document.getElementById('pasar_ekspor_tahun').value = msg[0].pasar_ekspor_tahun;
					document.getElementById('pasar_ekspor_nilai').value = msg[0].pasar_ekspor_tahun;

					document.getElementById('kelompok_anggota_pinjaman').value = msg[0].kelompok_anggota_pinjaman;
					document.getElementById('hasil_produk').value = msg[0].hasil_produk;
					document.getElementById('kelompok_pihak_pembeli').value = msg[0].kelompok_pihak_pembeli;
					document.getElementById('kelompok_pihak_pembeli_handphone').value = msg[0].kelompok_pihak_pembeli_handphone;
					document.getElementById('kelompok_suplier_produk').value = msg[0].kelompok_suplier_produk;
					document.getElementById('kelompok_suplier_handphone').value = msg[0].kelompok_suplier_handphone;
					document.getElementById('kelompok_luas_usaha').value = msg[0].kelompok_luas_usaha;
					document.getElementById('kelompok_omset').value = msg[0].kelompok_omset;
					document.getElementById('kelompok_cerita_usaha').value = msg[0].kelompok_cerita_usaha;
					document.getElementById('pinjaman').value = msg[0].pinjaman;
					document.getElementById('nominal_pinjaman').value = msg[0].nominal_pinjaman;
					document.getElementById('norek_pinjaman_bri').value = msg[0].norek_pinjaman_bri;
					document.getElementById('agen_brilink').value = msg[0].agen_brilink;


					document.getElementById('kebutuhan_sarana_milik').value = msg[0].kebutuhan_sarana_milik;
					document.getElementById('kebutuhan_sarana').value = msg[0].kebutuhan_sarana;
					document.getElementById('kebutuhan_sarana_lainnya').value = msg[0].kebutuhan_sarana_lainnya;
					document.getElementById('kebutuhan_skema_kredit').value = msg[0].kebutuhan_skema_kredit;

					document.getElementById('kebutuhan_pendidikan').value = msg[0].kebutuhan_pendidikan;
					document.getElementById('simpanan_bank').value = msg[0].simpanan_bank;
					// end data cluster//

					for (var i = 0; i < tempdata.rfku.length; i++) {
						vfku(i, tempdata.rfku[i].location);
					}
					for (var i = 0; i < tempdata.rfex.length; i++) {
						vfex(i, tempdata.rfex[i].location);
					}

					$('#modal').show();
				}
			});
		} else {
			var dd = $('.form-control');
			document.getElementById('setuker').innerHTML = "";
			for (var j = 0; j < dd.length; j++) {
				dd[j].value = "";
				valnik = false;
				valhp = false;
				$('#modal').show();
			}
			document.getElementById('kode_uker').value = "<?php echo $this->session->userdata('kode_uker'); ?>";
			document.getElementById('kelompok_jumlah_anggota').value = "15";
		}
	}

	function vfku(newid, rfku = null) {
		$("#fotoklusterusaha").append('<div class="col-sm-4"  id="mfku_' + newid + '"><div class="input-group"><span class="input-group-btn"><span class="btn btn-default btn-file"><i class="fa fa-upload"></i> Upload ' + (newid + 1) + '<input class="fku" type="file" id="fku_' + newid + '"  onchange="readURL(this,\'fku_' + newid + '\');" > 	 <input type="hidden" name="rfku" id="rfku_' + newid + '" value=""> <input type="hidden" name="tfku" id="tfku_' + newid + '" value="">  <input type="hidden" name="idfku" id="idfku_' + newid + '" value=""> </span><span class="btn btn-default btn-file" onclick="minform(\'mfku_' + newid + '\');"><i class="fa fa-close"></i>  Hapus</span></span></div><img class="img-upload" id="shfku_' + newid + '"  src="' + (rfku != null ? rfku : '') + '"/></div>');
	}

	function vfex(newid, rfex = null) {
		$("#fotoverifikasiexpor").append('<div class="col-sm-4"  id="mfex_' + newid + '"><div class="input-group"><span class="input-group-btn"><span class="btn btn-default btn-file"><i class="fa fa-upload"></i> Upload ' + (newid + 1) + '<input class="fex" type="file" id="fex_' + newid + '"  onchange="readURL(this,\'fex_' + newid + '\');" >	 <input type="hidden"  name="rfex" id="rfex_' + newid + '" value=""> <input type="hidden" name="tfex" id="tfex_' + newid + '" value="">  <input type="hidden" name="idfex" id="idfex_' + newid + '" value=""> </span><span class="btn btn-default btn-file" onclick="minform(\'mfex_' + newid + '\');"><i class="fa fa-close"></i>  Hapus</span></span></div><img class="img-upload" id="shfex_' + newid + '" src="' + (rfex != null ? rfex : '') + '"/></div>');
	}

	function inputform() {
		if (document.getElementById("checkvalidkunjungan").checked == true && document.getElementById("checkvalidpotensi").checked == true) {
			if (valuker == true) {
				var data1 = {};
				var dform = document.getElementsByClassName('dform');
				for (var i = 0; i < dform.length; i++) {
					data1[dform[i].id] = dform[i].value;
				}

				var msg = "";
				msg = reval();

				data1['rfku'] = [];
				data1['tfku'] = [];
				data1['idfku'] = [];
				data1['efku'] = [];
				data1['rfex'] = [];
				data1['tfex'] = [];
				data1['idfex'] = [];
				data1['efex'] = [];

				if ($("input[name='rfku']").length != 0) {
					var rfku = ($("input[name='rfku']")[($("input[name='rfku']").length) - 1]);
					rfku = rfku.id.split("_");
					var valid = 0;
					for (var i = 0; i <= rfku[1]; i++) {
						console.log(i);
						if ($("#rfku_" + i).val() !== "") {
							data1['rfku'][i] = $("#rfku_" + i).val();
							data1['tfku'][i] = $("#tfku_" + i).val();
							data1['efku'][i] = "";
							valid++;
						} else {
							data1['efku'][i] = $("#shfku_" + i).attr('src') != "" ? $("#shfku_" + i).attr('src') : "";
							if (data1['efku'][i] != "") valid++;
						}
					}
					if (valid == 0) msg += "foto kluster usaha minimal ada 1";
				} else msg += "foto kluster usaha minimal ada 1";

				if ($("#pasar_ekspor").val() === "Ya") {
					if ($("input[name='rfex']").length != 0) {
						var rfex = ($("input[name='rfex']")[($("input[name='rfex']").length) - 1]);
						rfex = rfex.id.split("_");
						var valid = 0;
						for (var i = 0; i <= rfex[1]; i++) {
							if ($("#rfex_" + i).val() !== "") {
								data1['rfex'][i] = $("#rfex_" + i).val();
								data1['tfex'][i] = $("#tfex_" + i).val();
								data1['efex'][i] = "";
								valid++;
							} else {
								data1['efex'][i] = $("#shfex_" + i).attr('src') != "" ? $("#shfex_" + i).attr('src') : "";
								if (data1['efex'][i] != "") valid++;
							}
						}
						if (valid == 0) msg += "foto/gambar dokument minimal ada 1";
					} else msg += "foto/gambar dokument minimal ada 1";
				}

				if (msg == "") {
					$("#sbt").attr("disabled", "disabled");
					$.ajax({
						type: "POST",
						url: "./cluster/inputdata",
						data: data1,
						success: function(msg) {
							alert('data berhasil diinput');
							$("#sbt").removeAttr("disabled");
							$('#modal').hide();
							$('#example').DataTable().ajax.reload(null, false);
						}
					});
				} else alert(msg);
			} else alert("Data Uker salah");
		} else alert("Harap isi checkbox pertanyaan diatas!!")
	}



	function cnik(i = null, j = null) {
		var validator = ["0000000000000000", "1111111111111111", "2222222222222222", "3333333333333333", "4444444444444444", "5555555555555555", "6666666666666666", "7777777777777777", "8888888888888888", "9999999999999999"];
		// return true;
		if (i != null) {
			if (i.toString().length == 16) {
				if (validator.includes(i.toString) == false) {
					return true;
				} else {

					if (j != null) alert('Data NIK tidak valid');

					return false;
				}
			} else {

				if (j != null) alert('NIK harus 16 digit');

				return false;
			}
		} else return false;
	}




	function reval() {
		var msg = "";
		msg += (validatorreqtext(document.getElementById('kaunit_nama'), iname) == false ? "data Nama Kaunit tidak valid \n" : "");
		msg += (validatorreqnumber(document.getElementById('kaunit_pn')) == false ? "data PN Kaunit tidak valid \n" : "");
		msg += (cekhp(document.getElementById('kaunit_handphone')) == false ? "data PN Kaunit tidak valid \n" : "");

		msg += (validatorreqtext(document.getElementById('nama_pekerja'), iname) == false ? "data nama_pekerja tidak valid \n" : "");
		msg += (validatorreqnumber(document.getElementById('personal_number')) == false ? "data personal_number pekerja tidak valid \n" : "");
		msg += (cekhp(document.getElementById('handphone_pekerja')) == false ? "data handphone_pekerja tidak valid \n" : "");

		msg += (validatorreqtext(document.getElementById('kelompok_usaha'), iname) == false ? "data Kelompok usaha tidak valid \n" : "");
		msg += (validatorreqnumber(document.getElementById('kelompok_jumlah_anggota')) == false ? "data kelompok_jumlah_anggota  tidak valid \n" : "");
		msg += (validatorreqtext(document.getElementById('hasil_produk'), ischar) == false ? "data hasil_produk tidak valid \n" : "");




		msg += (validatoroptnumber(document.getElementById('pasar_ekspor_tahun')) == false ? "data pasar_ekspor_tahun  tidak valid \n" : "");
		msg += (validatoroptnumber(document.getElementById('pasar_ekspor_nilai')) == false ? "data pasar_ekspor_nilai  tidak valid \n" : "");
		msg += (validatoroptnumber(document.getElementById('kelompok_luas_usaha')) == false ? "data kelompok_luas_usaha  tidak valid \n" : "");

		msg += (validatoropttext(document.getElementById('kelompok_pihak_pembeli'), ischar) == false ? "data kelompok_pihak_pembeli  tidak valid \n" : "");
		msg += (cekhpnor(document.getElementById('kelompok_pihak_pembeli_handphone')) == false ? "data kelompok_pihak_pembeli_handphone tidak valid \n" : "");
		msg += (validatoropttext(document.getElementById('kelompok_suplier_produk'), ischar) == false ? "data kelompok_suplier_produk  tidak valid \n" : "");
		msg += (cekhpnor(document.getElementById('kelompok_suplier_handphone')) == false ? "data kelompok_suplier_handphone tidak valid \n" : "");

		msg += (validatorreqtext(document.getElementById('kebutuhan_sarana_milik'), ischar) == false ? "data kebutuhan_sarana_milik tidak valid \n" : "");
		msg += (validatoropttext(document.getElementById('kebutuhan_sarana_lainnya'), ischar) == false ? "data kebutuhan_sarana_lainnya tidak valid \n" : "");

		msg += (validatorreqtext(document.getElementById('kelompok_perwakilan'), iname) == false ? "data nama ketua kelompok tidak valid \n" : "");
		msg += (validatorreqtext(document.getElementById('lokasi_usaha'), ischar) == false ? "data lokasi_usaha tidak valid \n" : "");
		msg += (validatorreqtext(document.getElementById('kelompok_cerita_usaha'), ischar) == false ? "Cerita Usaha kosong atau mengandung karakter yang tidak diperbolehkan (!@#$%^&*()+=[]\\\';/{}|\":<>?)  \n" : "");

		msg += (validatorreqtext(document.getElementById('provinsi'), ischar) == false ? "data provinsi tidak valid \n" : "");
		msg += (validatorreqtext(document.getElementById('kabupaten'), ischar) == false ? "data kabupaten tidak valid \n" : "");
		msg += (validatorreqtext(document.getElementById('kecamatan'), ischar) == false ? "data kecamatan tidak valid \n" : "");
		msg += (validatorreqtext(document.getElementById('kelurahan'), ischar) == false ? "data kelurahan tidak valid \n" : "");
		msg += (validatorreqnumber(document.getElementById('kode_pos')) == false ? "data kode_pos pekerja tidak valid \n" : "");

		msg += (cnik(document.getElementById('kelompok_NIK').value) == false ? "data kelompok_NIK pekerja tidak valid \n" : "");
		msg += (validatorreqtext(document.getElementById('kelompok_perwakilan_tgl_lahir'), ischar) == false ? "data kelompok_perwakilan_tgl_lahir pekerja tidak valid \n" : "");
		msg += (validatorreqtext(document.getElementById('kelompok_perwakilan_tempat_lahir'), ischar) == false ? "data kelompok_perwakilan_tempat_lahir tidak valid \n" : "");
		msg += (cekhp(document.getElementById('kelompok_handphone')) == false ? "data kelompok_handphone tidak valid \n" : "");

		msg += (validatoroptnumber(document.getElementById('nominal_pinjaman')) == false ? "data nominal_pinjaman  tidak valid \n" : "");
		msg += (validatoroptnumber(document.getElementById('norek_pinjaman_bri')) == false ? "data norek_pinjaman_bri  tidak valid \n" : "");
		msg += (document.getElementById('kelompok_anggota_pinjaman').value == "" ? "data kelompok angota pinjaman tidak boleh kosong \n" : "");
		msg += (document.getElementById('sektor_usaha').value == "" ? "data sektor usaha tidak boleh kosong \n" : "");
		msg += (document.getElementById('jenis_usaha').value == "" ? "data  Jenis usaha tidak boleh kosong \n" : "");
		msg += (document.getElementById('pasar_ekspor').value == "" ? "data Pasar Ekspor tidak boleh kosong\n" : "");
		msg += (document.getElementById('kebutuhan_sarana').value == "" ? "data  Kebutuhan Sarana tidak boleh kosong\n" : "");
		msg += (document.getElementById('kebutuhan_pendidikan').value == "" ? "data Kebutuhan pendidikan tidak boleh kosong\n" : "");
		msg += (document.getElementById('kebutuhan_skema_kredit').value == "" ? "data Skema Kredit  tidak boleh kosong\n" : "");
		msg += (document.getElementById('kelompok_jenis_kelamin').value == "" ? "data  Jenis Kelamin ketua/Perwakilan usaha tidak boleh kosong\n" : "");
		msg += (document.getElementById('pinjaman').value == "" ? "data punya Pinjaman tidak boleh kosong\n" : "");
		msg += (document.getElementById('simpanan_bank').value == "" ? "data  simpanan tidak boleh kosong\n" : "");
		msg += (document.getElementById('agen_brilink').value == "" ? "data agen brilink tidak boleh kosong\n" : "");
		return msg;
	}

	var iname = "!@#$%^&*()+=-[]\\\';,/{}|0123456789\":<>?";
	var ischar = "!@#$%^&*()+=[]\\\';/{}|\":<>?";

	///z for value, y for select iname char, x if call from input then alert from id, w if optional
	function validatorreqtext(z, y, x = null) {
		if (z.value.length != 0) {
			var dfalse = 0;
			for (var i = 0; i < (z.value.length); i++) {
				if (y.indexOf(z.value.charAt(i)) != -1) dfalse++;
			}
			if (dfalse == 0) return true;
			else {
				if (x != null) alert("Data " + x + " Tidak Valid (mengandung karakter yang tidak diperbolehkan)");
				return false;
			}
		} else {
			if (x != null) alert("Data " + x + " tidak boleh kosong");
			return false;
		}
	}

	function validatoropttext(z, y, x = null) {
		if (z.value.length != 0) {
			var dfalse = 0;
			for (var i = 0; i < (z.value.length); i++) {
				if (y.indexOf(z.value.charAt(i)) != -1) dfalse++;
			}
			if (dfalse == 0) return true;
			else {
				if (x != null) alert("Data " + x + " Tidak Valid (mengandung karakter yang tidak diperbolehkan)");
				return false;
			}
		}
		return true;
	}
	///i for value, j if call from input, k if optional	

	function validatorreqnumber(i, j = null, k = null) {
		if (i.value.length != 0) {
			var number = /^[0-9]+$/;
			var res = i.value.substring(0, 2);

			if (!i.value.match(number)) {
				if (j != null) alert("data " + j + " tidak valid");
				return false;
			} else if (i.value.length == 0) {
				if (j != null) alert("data " + j + " tidak valid");
				return false;
			} else return true;
		} else {
			if (j != null) alert("data " + j + " tidak boleh kosong");
			return false;
		}
	}

	function validatoroptnumber(i, j = null, k = null) {
		if (i.value.length != 0) {
			var number = /^[0-9]+$/;
			var res = i.value.substring(0, 2);

			if (!i.value.match(number)) {
				if (j != null) alert("data " + j + " tidak valid");
				return false;
			} else if (i.value.length == 0) {
				if (j != null) alert("data " + j + " tidak valid");
				return false;
			} else return true;
		} else return true;
	}


	function cekhp(i, j = null) {
		if (j == null) i = i.value;
		//console.log(i);
		var number = /^[0-9]+$/;
		var res = i.substring(0, 2);
		if (i == null || i == "") {
			if (j != null) alert('nomer handphone tidak boleh kosong')
			return false;
		} else if (!i.match(number)) {
			if (j != null) alert("nomer handphone  harus angka");
			return false;

		} else if (i.length < 8) {
			if (j != null) alert("nomor handphone tidak valid");
			return false;
		} else if (res != "08") {
			if (j != null) alert(j + " Harus diawali 08");
			return false;
		} else return true;
	}



	function cekhpnor(i, j = null) {
		if (i.value.length != 0) {
			var number = /^[0-9]+$/;
			var res = i.value.substring(0, 2);
			if (!i.value.match(number)) {
				if (j != null) alert("nomer handphone harus angka");
				return false;
			} else if (i.value.length < 8) {
				if (j != null) alert("nomor handphone tidak valid");
				return false
			} else if (res != "08") {
				if (j != null) alert(j + " Harus diawali 08");
				return false;
			} else return true;
		} else return true;
	}

	function deldata(i) {
		if (confirm('Apakah anda yakin akan menghapus data ini?')) {
			var data1 = {
				'id': i,
			};
			$.ajax({
				type: "POST",
				url: "./cluster/deldata",
				data: data1,
				success: function(msg) {
					alert('data berhasil dihapus');
					$('#example').DataTable().ajax.reload(null, false);
				}
			});
		}
	}

	function setprov(i) {
		$("#provinsi").val(i);
	}

	function getkotakab(i, j = null) {
		var data1 = {
			'provinsi_id': i
		};
		var address = "./cluster/getkotakab";
		var get = sendajaxreturn(data1, address, 'json');
		var select = '<select class="form-control dform  required" onchange="getkecamatan(this.value)" id="kabupaten"><option></option>';
		get.forEach(function(e) {
			select += "<option value='" + e.id + "' " + (j != null ? (j == e.id ? "selected" : "") : "") + ">" + e.nama + "</option>";
		})
		document.getElementById("selkab").innerHTML = '' + select + '</select>';
	}

	function getkecamatan(i, j = null) {
		var data1 = {
			'kabupaten_kota_id': i
		};
		var address = "./cluster/getkecamatan";
		var get = sendajaxreturn(data1, address, 'json');
		var select = '<select class="form-control dform  required" onchange="getkelurahan(this.value)" id="kecamatan"><option></option>';
		get.forEach(function(e) {
			select += "<option value='" + e.id + "' " + (j != null ? (j == e.id ? "selected" : "") : "") + ">" + e.nama + "</option>";
		})
		document.getElementById("selkec").innerHTML = '' + select + '</select>';
	}

	function getkelurahan(i, j = null) {
		var data1 = {
			'kecamatan_id': i
		};
		var address = "./cluster/getkelurahan";
		var get = sendajaxreturn(data1, address, 'json');
		var select = '<select class="form-control dform  required" onchange="setkdpos(this)" id="kelurahan"><option></option>';
		get.forEach(function(e) {
			select += "<option value='" + e.id + "' " + (j != null ? (j == e.id ? "selected" : "") : "") + " kdpos='" + e.kode_pos + "'>" + e.nama + "</option>";
			if (j != null && j == e.id) setkdpos("", e.kode_pos);
		})
		document.getElementById("selkel").innerHTML = '' + select + '</select>';
	}

	function setkdpos(i, j = null) {
		var element = (j == null ? $("option:selected", i).attr('kdpos') : j);
		document.getElementById("kode_pos").innerHTML = element;
		document.getElementById("kode_pos").value = element;
	}
</script>