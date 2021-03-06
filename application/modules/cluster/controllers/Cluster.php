<?php

/**
 *
 *
 * @autor 
 * @dzaky Hidayat
 *
 **/
?>
 
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cluster extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->module('login');
		$this->login->is_logged_in();
		$this->load->model('cluster_m');
		$this->load->helper(array('url', 'form', 'html'));
		// print_r ($this->session->all_userdata());
    }
    
    ////////////////////////////////////////////////////////////
    /////////////////get pengajuan klaster usaha ///////////////
    ////////////////////////////////////////////////////////////

	public function index()
	{	
	
		$data['navbar'] = 'navbar';
        $data['sidebar'] = 'sidebar';
        $data['cluster_sektor_usaha'] = $this->cluster_m->get_cluster_sektor_usaha();
		$data['cluster_kebutuhan_pendidikan_pelatihan'] = $this->cluster_m->get_cluster_kebutuhan_pendidikan_pelatihan();
		$data['cluster_kebutuhan_sarana'] = $this->cluster_m->get_cluster_kebutuhan_sarana();
		$data['cluster_kebutuhan_skema_kredit'] = $this->cluster_m->get_cluster_kebutuhan_skema_kredit();
		$data['kanwil'] = $this->cluster_m->get_data_kanwil_m();
		$data['content'] = $this->session->userdata('kode_uker') == 'kanpus' ? 'cluster_kanpus_v' : 'cluster_v';
		$data['provinsi'] = $this->cluster_m->getprovinsi_m();
		$this->load->view('template', $data);
	}

	public function getdata($status = null)
	{
		$datafilter=json_decode($_POST['custom_field']);
		$list = $this->cluster_m->get_datafield($status, $datafilter);
		$data = array();
		$no = $_POST['start'];
		foreach ($list->result_array() as $field) {
			$totalanggota = $this->cluster_m->countanggota_m($field['id']);

			$jenis_usaha = $this->cluster_m->getdata_j($field['id_cluster_jenis_usaha']);
			$status=$field["checker_status"]=="" ? "check" : "sign";
            $colstatus  = "";
			$ca 	    = '<button class="btn btn-info waves-effect waves-light btn-sm btn-block" name="id" value="' . $field['id'] . '" type="submit" ><i class="fa fa-users"></i> Anggota</button>';
			$upload     = '<button class="btn btn-primary waves-effect waves-light btn-sm btn-block" onclick="upform(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-upload"></i> Upload</button>';
            $info	    = '<button class="btn btn-default waves-effect waves-light btn-sm btn-block" onclick="showClusterInfo(\'' . $field['id'] . '\')" type="button"><i class="fa fa-info"></i> Info</button>';
            $appr       = '<button class="btn btn-success waves-effect waves-light btn-sm btn-block" onclick="setappr(\'' . $field['id'] . '\' , \''.$status.'\' );" type="button" ><i class="fa fa-check"></i> Setuju </button>';
            $reject     = '<button class="btn btn-warning waves-effect waves-light btn-sm btn-block" onclick="modalreject(\'' . $field['id'] . '\' , \''.$status.'\' );" type="button" ><i class="fa fa-check"></i> Tolak </button>';
			$checker_username 	= $field['checker_user_update'] !== "" ? $this->cluster_m->cekuker_m($field['checker_user_update']) : "";
			$signer_username 	= $field['signer_user_update'] !== "" ? $this->cluster_m->cekuker_m($field['signer_user_update']) : "";
			
			if ($this->session->userdata('kode_uker') == $field['kode_uker']){
				$del 	    = '<button class="btn btn-danger waves-effect waves-light btn-sm btn-block" onclick="deldata(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-close"></i> Hapus</button>';
				$update     = '<button class="btn btn-success waves-effect waves-light btn-sm btn-block" onclick="getform(\'' . $field['id'] . '\');" type="button" ><i class="fa fa-pencil"></i> Update</button>';
			}
			else {
				if ($this->session->userdata('permission')>3){
					$del 	    = '<button class="btn btn-danger waves-effect waves-light btn-sm btn-block" onclick="deldata(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-close"></i> Hapus</button>';
					$update     = '<button class="btn btn-success waves-effect waves-light btn-sm btn-block" onclick="getform(\'' . $field['id'] . '\');" type="button" ><i class="fa fa-pencil"></i> Update</button>';
				}
				else {
					$del ="";
					$update ="";
				}
			}
			//exection button//


	///////////////////// button for MCS /////////////////////////////////
		
			if ($field["checker_status"]!=""){

				if ($field["checker_status"]=='1'){
					
					if ($field["signer_status"]!=""){
						if ($field["signer_status"]==0) $colstatus = " Pengajuan ditolak Divisi SEI </br>". $field['reject_reason'];
					}

					else {
						switch ($this->session->userdata['approve_level']) {
							case (0) :
							case (1) :
								$colstatus = "Pengajuan telah diriview oleh " . $checker_username[0]['BRDESC'] . " </br> Menunggu Divisi SEI ";
							break;
		
							case (2) :  
								$colstatus = "Pengajuan telah diriview oleh " . $checker_username[0]['BRDESC'] . " </br> " .  $appr . $reject ;
							break;
						}
					}
				}

				else {
					$colstatus =" Pengajuan ditolak oleh ". $checker_username[0]['BRDESC'] ."</br>". $field['reject_reason'];
				}
			}
			else {
				switch ($this->session->userdata['approve_level']) {
					case (0) :
					case (2) :
						$colstatus = " Pengajuan sedang menunggu Checker ";
					break;

					case (1) :  
						$colstatus = $appr . $reject ;
					break;
				}
			}

    ///////////////////// End button for MCS /////////////////////////////////
			$action     =  $info . $ca . ($this->session->userdata('kode_uker') == 'kanpus' ? '' : $update . $del);
			

	///////////////////////check for local heroes/////////////////////////////
			
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['kanwil'];
			$row[] = $field['kanca'];
			$row[] = $field['uker'];
			$row[] = $field['kelompok_usaha'] . ( $field['lh_flag'] == 1 ? '<i class="fa fa-check" style="color:green"></i>' : '');
			$row[] = $field['kelompok_jumlah_anggota'] . " / " . $totalanggota[0]['sum'];
			$row[] = count($jenis_usaha) > 0 ? $jenis_usaha[0]['nama_cluster_jenis_usaha'] : $field['id_cluster_jenis_usaha'];
			$row[] = $field['hasil_produk'];
            $row[] = $colstatus;
            $row[] = '<form action="cluster/cluster_anggota" target="_blank" method="POST"><input type="hidden" name="kelompok_usaha" value="' . $field['kelompok_usaha'] . '">' . $action . '</form>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $list->num_rows(),
			"recordsFiltered" => $this->cluster_m->count_all($status, $datafilter),
			"data" => $data,
		);
		echo json_encode($output);
	}


	public function deldata()
	{
		$this->cluster_m->deldata_m();
	}

	public function setapproved(){
		$this->cluster_m->setapproved_m();
	}

	public function setreject(){
		$this->cluster_m->setreject_m();
	}

	public function countpengajuan(){
		$data = $this->cluster_m->get_datafield()->num_rows();
		return $data;
	}
   
    ////////////////////////////////////////////////////////////
    /////////////////end pengajuan klaster usaha ///////////////
    ////////////////////////////////////////////////////////////


    ////////////////////////////////////////////////////////////
    /////////////////get approved klaster usaha ////////////////
    ////////////////////////////////////////////////////////////

	public function approve()
	{
        $data['navbar'] = 'navbar';
        $data['sidebar'] = 'sidebar';
        $data['cluster_sektor_usaha'] = $this->cluster_m->get_cluster_sektor_usaha();
		$data['cluster_kebutuhan_pendidikan_pelatihan'] = $this->cluster_m->get_cluster_kebutuhan_pendidikan_pelatihan();
		$data['cluster_kebutuhan_sarana'] = $this->cluster_m->get_cluster_kebutuhan_sarana();
		$data['cluster_kebutuhan_skema_kredit'] = $this->cluster_m->get_cluster_kebutuhan_skema_kredit();
		$data['content'] = $this->session->userdata('kode_uker') == 'kanpus' ? '' : 'cluster_approve_v';
		$data['provinsi'] = $this->cluster_m->getprovinsi_m();
		$this->load->view('template', $data);
    }
    
    public function get_clusterapproved(){
        $list = $this->cluster_m->get_clusterapprove_m();
		$no = $_POST['start'];
		foreach ($list->result_array() as $field) {

			$totalanggota = $this->cluster_m->countanggota_m($field['id']);
			
			$jenis_usaha = $this->cluster_m->getdata_j($field['id_cluster_jenis_usaha']);
			$info		= '<button class="btn btn-default waves-effect waves-light btn-sm btn-block" onclick="showClusterInfo(\'' . $field['id'] . '\')" type="button"><i class="fa fa-info"></i> Info</button>';
			$ca 	    = '<button class="btn btn-info waves-effect waves-light btn-sm btn-block" name="id" value="' . $field['id'] . '" type="submit" ><i class="fa fa-users"></i> Anggota</button>';

			

			if ($this->session->userdata('kode_uker') == $field['kode_uker']){
				$del 	    = '<button class="btn btn-danger waves-effect waves-light btn-sm btn-block" onclick="deldata(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-close"></i> Hapus</button>';
				$update     = '<button class="btn btn-success waves-effect waves-light btn-sm btn-block" onclick="getform(\'' . $field['id'] . '\');" type="button" ><i class="fa fa-pencil"></i> Update</button>';
			}
			else {
				if ($this->session->userdata('permission')>3){
					$del 	    = '<button class="btn btn-danger waves-effect waves-light btn-sm btn-block" onclick="deldata(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-close"></i> Hapus</button>';
					$update     = '<button class="btn btn-success waves-effect waves-light btn-sm btn-block" onclick="getform(\'' . $field['id'] . '\');" type="button" ><i class="fa fa-pencil"></i> Update</button>';
				}
				else {
					$del ="";
					$update ="";
				}
			}

			$action     =  $info . $ca . ($this->session->userdata('kode_uker') == 'kanpus' ? '' : $update);

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['kanwil'];
			$row[] = $field['kanca'];
			$row[] = $field['uker'];
			$row[] = $field['kelompok_usaha'] . ( $field['lh_flag'] == 1 ? '<i class="fa fa-check" style="color:green"></i>' : '');
			$row[] = $field['kelompok_jumlah_anggota'] . " / " . $totalanggota[0]['sum'];
			$row[] = count($jenis_usaha) > 0 ? $jenis_usaha[0]['nama_cluster_jenis_usaha'] : $field['id_cluster_jenis_usaha'];
			$row[] = $field['hasil_produk'];
			$row[] = '<form action="cluster/cluster_anggota" target="_blank" method="POST"><input type="hidden" name="kelompok_usaha" value="' . $field['kelompok_usaha'] . '">' . $action . '</form>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $list->num_rows(),
			"recordsFiltered" => $this->cluster_m->count_all_approved(),
			"data" => $data,
		);
		echo json_encode($output);
	}
	
    ////////////////////////////////////////////////////////////
    /////////////////end approved klaster usaha ////////////////
    ////////////////////////////////////////////////////////////


    public function cekuker()
	{
		if ($_POST['kode_uker'] != "") {
			$data = $this->cluster_m->cekuker_m();
			if ($data != false) {
				echo json_encode($data[0]['BRDESC']);
			} else echo json_encode("data uker tidak ditemukan");
		}
	}

	public function getdata_s()
	{
		if (isset($_POST['id'])) {
			$data['cluster'] = $this->cluster_m->getdata_m();
			$data['rfku'] = $this->cluster_m->getdatafoto_m('cluster_foto_usaha');
			$data['rfex'] = $this->cluster_m->getdatafoto_m('cluster_doc_ekspor');
			echo json_encode($data);
		}
	}

	function fjum()
	{

		$data = $this->cluster_m->getdata_jum();
		echo json_encode($data);
	}

	function fju()
	{
		$data = $this->cluster_m->getdata_ju();
		echo json_encode($data);
	}

	public function inputdata()
	{
		$rfku = null;
		$rfex = null;

		if (count($_POST['efku']) > 0) {
			$z = 0;
			for ($i = 0; $i < count($_POST['efku']); $i++) {
				
				if (isset($_POST['rfku'])){
					if ($_POST['rfku'][$i] != "") {
						$rfku[$z] = $this->camphotoupload($_POST['rfku'][$i], $_POST['tfku'][$i]);
						$z++;
					}
				} else {
					if ($_POST['efku'][$i] != "") {
						$rfku[$z] = $_POST['efku'][$i];
						$z++;
					}
				}
				echo $z;
			}
			unset($_POST['rfku']);
			unset($_POST['tfku']);
			unset($_POST['efku']);
		}

		if (isset($_POST['efex'])){
			if (count($_POST['efex']) > 0) {
				$z = 0;
				for ($i = 0; $i < count($_POST['efex']); $i++) {
					if ($_POST['rfex'][$i] != "") {
						$rfex[$z] = $this->camphotoupload($_POST['rfex'][$i], $_POST['tfex'][$i]);
						$z++;
					} else {
						if ($_POST['efex'][$i] != "") {
							$rfex[$z] = $_POST['efex'][$i];
							$z++;
						}
					}
					echo $z;
				}
				unset($_POST['rfex']);
				unset($_POST['tfex']);
				unset($_POST['efex']);
			}
		}

		if ($_POST['id'] != "") {
			$this->cluster_m->updatedata_m($rfex, $rfku);
			echo "update";
		} else {
			$this->cluster_m->insertdata_m($rfex, $rfku);
			echo "insert";
		}
	}


	public function getreport($harian = "")
	{
		ini_set('memory_limit', '-1');
		$data['kanwil'] = array();
		$q = $this->cluster_m->getreport_m($harian);
		$data['listkategori'] = $this->cluster_m->getlist_jum();
		foreach ($q as $row) {
			if ($row['kanwil'] != false) {
				foreach ($data['listkategori'] as $zrow) {
					if (!isset($data['total'][$zrow['id_cluster_jenis_usaha_map']])) {
						$data['total'][$zrow['id_cluster_jenis_usaha_map']] = 0;
					}
					if ($zrow['id_cluster_jenis_usaha_map'] == $row['id_cluster_jenis_usaha_map']) {
						if (isset($data['kanwil'][$row['kanwil']][$zrow['id_cluster_jenis_usaha_map']])) {
							$data['kanwil'][$row['kanwil']][$zrow['id_cluster_jenis_usaha_map']]++;
						} else $data['kanwil'][$row['kanwil']][$zrow['id_cluster_jenis_usaha_map']] = 1;
						$data['total'][$zrow['id_cluster_jenis_usaha_map']]++;
						break;
					}
				}
			}
		}
		$data['harian'] = $harian;
		$data['navbar'] = 'navbar';
		$data['sidebar'] = 'sidebar';
		$data['content'] = 'cluster_report_v';
		$this->load->view('template', $data);
	}


	public function dldata($harian = null)
	{
		ini_set('memory_limit', '-1');
		$headerexcel[0] = array(
			'No', 'id', 'Waktu Input', 'kanwil', 'kanca',
			"Kode Kanca", "Uker", "Kode Uker", "Nama Kaunit", "PN Kaunit", "Handphone Kaunit", "Nama Mantri", "PN Mantri", "Handphone Mantri",
			"Nama Kelompok Usaha", "Jumlah Anggota (orang)", "Pinjaman anggota Kelompok", "Lokasi Usaha", "Kode Pos", "Provinsi", "Kabupaten/Kota", "Kecamantan", "Kelurahan",
			"Sektor Usaha", "Jenis Usaha Map", "Jenis Usaha", "Hasil Produk", "varian", "Pasar Ekspor", "Tahun Pasar Ekspor", "Nilai Pasas Ekspor", "Pihak Pembeli Produk/Jasa yang Dihasilkan", "Handphone Pihak Pembeli", "Suplier Bahan Baku Produk/Jasa yang Dihasilkan", "Handphone Suplier",
			"Luas Lahan/Tempat Usaha (m2)", "Omset Usaha Perbulan (total Kelompok - Rp)",
			"Nama Ketua Kelompok", "Jenis Kelamin", "NIK", "Handphone Ketua Kelompok", "Tanggal Lahir", "Tempat lahir",
			"Punya Pinjaman", "Nominal Pinjaman BRI", "Norek Pinjaman BRI", "Kebutuhan Kredit",
			"Kebutuhan Sarana", "Kebutuhan Sarana Lainnya", "Kebutuhan Pendidikan",
			"Simpanan Bank", "Agen Brilink"
		);

		$data = $this->cluster_m->getdataall_m($harian);
		$no = 1;
		$z = 1;
		foreach ($data as $cell) {
			$col = 0;
			$headerexcel[$z][$col] = $no;
			foreach (array_keys($cell) as $key) {
				$col++;
				$cell[$key] = str_replace(';', ' ', $cell[$key]);
				$cell[$key] = str_replace(',', ' ', $cell[$key]);
				$headerexcel[$z][$col] = $cell[$key];
			}
			$z++;
			$no++;
		}

		echo json_encode($headerexcel, true);
	}


	public function cekkpos()
	{
		if ($_POST['kodepos'] != "") {
			$data = $this->cluster_m->cekkpos_m();
			if ($data != false) {
				echo json_encode($data[0]);
			} else echo json_encode("false");
		}
	}

	public function getprovinsi()
	{
		$data = $this->cluster_m->getprovinsi_m();
		echo json_encode($data);
	}

	public function getkotakab($select = null)
	{
		$datakota = $this->cluster_m->getkotakab_m();
		echo json_encode($datakota);
	}

	public function getkecamatan()
	{
		$datakecamatan = $this->cluster_m->getkecamatan_m();
		echo json_encode($datakecamatan, true);
	}
	public function getkelurahan()
	{
		$datakelurahan = $this->cluster_m->getkelurahan_m();
		echo json_encode($datakelurahan);
	}

	/////////////////////////////////////////////////////////////////////////////
	///////////////////////////cluster anggota
	////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function cluster_anggota()
	{
		if (isset($_POST['id'])) {
			$cluster=$this->cluster_m->getdata_m();
			foreach ($cluster as $row){
				$data['id']				= $row['id'];
				$data['kelompok_usaha']	= $row['kelompok_usaha'];
				$data['approval']		= $row['cluster_approval'];
			}
			$data['content'] = 'cluster_anggota';
			$data['navbar'] = 'navbar';
			$data['sidebar'] = 'sidebar';
			$this->load->view('template', $data);
		} else {
			echo "<script>alert('ups, ada kesalahan')</script>";
			redirect('cluster', 'refresh');
		}
	}

	public function getdata_anggota()
	{

		$list = $this->cluster_m->get_datafield_anggota();
		$data = array();
		$no = $_POST['start'];
		foreach ($list->result_array() as $field) {
			$del = '<button class="btn bg-maroon waves-effect waves-light btn-sm" onclick="deldata_anggota(\'' . $field['id_ca'] . '\')" type="button" ><i class="fa fa-close"></i> Hapus</button>';
			$update = '<button class="btn btn-success waves-effect waves-light btn-sm" onclick="getform_anggota(\'' . $field['id_ca'] . '\')" type="button" ><i class="fa fa-pencil"></i> Update</button>';
			$action = ($this->session->userdata('kode_uker') == 'kanpus' ? '' : $update . $del);

			if (isset($_POST['approval'])) $action="";

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $field['ca_nama'];
			$row[] = $field['ca_nik'];
			$row[] = $field['ca_norek'];
			$row[] = $field['ca_jk'];
			$row[] = $field['ca_kodepos'];
			$row[] = $field['ca_pinjaman'];
			$row[] = $field['ca_simpanan'];
			$row[] = $field['ca_handphone'];
			$row[] = $action;
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $list->num_rows(),
			"recordsFiltered" => $this->cluster_m->count_all_anggota(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function getdata_anggota_s()
	{
		if (isset($_POST['id_ca'])) {
			echo json_encode($this->cluster_m->getdata_anggota_m());
		}
	}

	public function inputdata_anggota()
	{
		if ($_POST['id_ca'] != "") {
			$this->cluster_m->updatedata_anggota_m();
			echo "udpate";
		} else {
			$this->cluster_m->insertdata_anggota_m();
			echo "insert";
		}
	}

	public function deldata_anggota()
	{
		$this->cluster_m->deldata_anggota_m();
	}

	public function inputanggotacsv()
	{
		$anggota = json_decode($_POST['anggota'], true);
		$this->cluster_m->inputanggotacsv_m($anggota);
	}

	public function dldataanggota()
	{
		$headerexcel[0] = array('No', 'Nama Anggota', 'NIK','Nomor Rekening', 'Jenis Kelamin', "Kode Pos", "Pinjaman", "Simpanan", "Handphone", "alamat", "Provinsi", "Kota/Kabupaten", "kecamatan" , "kelurahan", "branch", "Waktu input");

		$data = $this->cluster_m->dldataanggota_m();
		$no = 1;
		$z = 1;
		foreach ($data as $cell) {
			$col = 0;
			$headerexcel[$z][$col] = $no;
			foreach (array_keys($cell) as $key) {
				$col++;
				if ($cell[$key]=="'") $cell[$key]="-";
				$headerexcel[$z][$col] = $cell[$key];
			}
			$z++;
			$no++;
		}

		echo json_encode($headerexcel);
	}

	public function report_unit()
	{
		$pdata = array();
		$data['kanwil'] = array();
		$z = array();
		foreach ($this->cluster_m->get_data_kanwil_m() as $row) {
			foreach ($this->cluster_m->report_unit_count_m($row['kode_kanwil']) as $srow) {
				(isset($z[$row['kode_kanwil']][$srow['kode_uker']])) ? $z[$row['kode_kanwil']][$srow['kode_uker']]++ : $z[$row['kode_kanwil']][$srow['kode_uker']] = 1;
			};
		}
		$i = 0;
		foreach ($this->cluster_m->report_unit_m() as $srow) {
			$pdata['data'][$srow['REGION']]['RGDESC'] = $srow['RGDESC'];
			$pdata['data'][$srow['REGION']]['REGION'] = $srow['REGION'];
			if (!isset($z[$srow['REGION']][$srow['BRANCH']])) {
				(isset($pdata['data'][$srow['REGION']]['kosong'])) ? $pdata['data'][$srow['REGION']]['kosong']++ : $pdata['data'][$srow['REGION']]['kosong'] = 1;
			} else {
				if ($z[$srow['REGION']][$srow['BRANCH']] == 1) {
					(isset($pdata['data'][$srow['REGION']]['isi_sebagian'])) ? $pdata['data'][$srow['REGION']]['isi_sebagian']++ : $pdata['data'][$srow['REGION']]['isi_sebagian'] = 1;
				}
				if ($z[$srow['REGION']][$srow['BRANCH']] > 1) {
					(isset($pdata['data'][$srow['REGION']]['terisi'])) ? $pdata['data'][$srow['REGION']]['terisi']++ : $pdata['data'][$srow['REGION']]['terisi'] = 1;
				}
			}
			$i++;
		}
		$pdata['navbar'] = 'navbar';
		$pdata['sidebar'] = 'sidebar';
		$pdata['content'] = 'cluster_report_unit_v';
		$this->load->view('template', $pdata);
	}

	public function report_unit_detail()
	{
		$pdata = array();
		$data['kanwil'] = array();
		$z = array();
		foreach ($this->cluster_m->get_data_kanwil_m() as $row) {
			foreach ($this->cluster_m->report_unit_count_m($row['kode_kanwil']) as $srow) {
				if (!isset($z[$row['kode_kanwil']][$srow['kode_uker']])) $z[$row['kode_kanwil']][$srow['kode_uker']] = 0;
				$z[$row['kode_kanwil']][$srow['kode_uker']]++;
			};
		}
		$i = 1;
		$table = "";
		foreach ($this->cluster_m->report_unit_m() as $srow) {
			if (!isset($z[$srow['REGION']][$srow['BRANCH']])) {
				if ($_POST['case'] == 'kosong') {
					$table .= '<tr><td>' . $i . '</td>
										<td>' . $srow['MBDESC'] . '</td>
										<td>' . $srow['BRDESC'] . '</td>
										<td>0</td></tr>';
					$i++;
				}
			} else if ($z[$srow['REGION']][$srow['BRANCH']] == 1) {
				if ($_POST['case'] == 'sebagian') {
					$table .= '<tr><td>' . $i . '</td>
										<td>' . $srow['MBDESC'] . '</td>
										<td>' . $srow['BRDESC'] . '</td>
										<td>' . $z[$srow['REGION']][$srow['BRANCH']] . '</td></tr>';
					$i++;
				}
			} else if ($z[$srow['REGION']][$srow['BRANCH']] > 1) {
				if ($_POST['case'] == 'terisi') {
					$table .= '<tr><td>' . $i . '</td>
										<td>' . $srow['MBDESC'] . '</td>
										<td>' . $srow['BRDESC'] . '</td>
										<td>' . $z[$srow['REGION']][$srow['BRANCH']] . '</td></tr>';
					$i++;
				}
			}
		}
		echo '<table class="table table-striped table-bordered" style="width:100%">
						<thead>
							<tr>
								<th>No</th>
								<th>Kanca</th>
								<th>Unit</th>
								<th>Total Isian</th>
							</tr>
						</thead>
						<tbody>' . $table . '
						</tbody>
					 </table>';
	}

	public function report_kanca()
	{
		$pdata = array();
		$data['kanwil'] = array();
		$z = array();
		foreach ($this->cluster_m->get_data_kanwil_m() as $row) {
			foreach ($this->cluster_m->report_kc_count_m($row['kode_kanwil']) as $srow) {
				(isset($z[$row['kode_kanwil']][$srow['kode_kanca']])) ? $z[$row['kode_kanwil']][$srow['kode_kanca']]++ : $z[$row['kode_kanwil']][$srow['kode_kanca']] = 1;
			};
		}
		$i = 0;
		foreach ($this->cluster_m->report_kc_m() as $srow) {
			$pdata['data'][$srow['REGION']]['RGDESC'] = $srow['RGDESC'];
			$pdata['data'][$srow['REGION']]['REGION'] = $srow['REGION'];
			if (!isset($z[$srow['REGION']][$srow['BRANCH']])) {
				(isset($pdata['data'][$srow['REGION']]['kosong'])) ? $pdata['data'][$srow['REGION']]['kosong']++ : $pdata['data'][$srow['REGION']]['kosong'] = 1;
			} else {
				if ($z[$srow['REGION']][$srow['BRANCH']] < 3) {
					(isset($pdata['data'][$srow['REGION']]['isi_sebagian'])) ? $pdata['data'][$srow['REGION']]['isi_sebagian']++ : $pdata['data'][$srow['REGION']]['isi_sebagian'] = 1;
				}
				if ($z[$srow['REGION']][$srow['BRANCH']] >= 3) {
					(isset($pdata['data'][$srow['REGION']]['terisi'])) ? $pdata['data'][$srow['REGION']]['terisi']++ : $pdata['data'][$srow['REGION']]['terisi'] = 1;
				}
			}
			$i++;
		}
		$pdata['navbar'] = 'navbar';
		$pdata['sidebar'] = 'sidebar';
		$pdata['content'] = 'cluster_report_kanca_v';
		$this->load->view('template', $pdata);
	}

	public function report_kanca_detail()
	{
		$pdata = array();
		$data['kanwil'] = array();
		$z = array();
		foreach ($this->cluster_m->get_data_kanwil_m() as $row) {
			foreach ($this->cluster_m->report_kc_count_m($row['kode_kanwil']) as $srow) {
				if (!isset($z[$row['kode_kanwil']][$srow['kode_kanca']])) $z[$row['kode_kanwil']][$srow['kode_kanca']] = 0;
				$z[$row['kode_kanwil']][$srow['kode_kanca']]++;
			};
		}
		$i = 1;
		$table = "";
		foreach ($this->cluster_m->report_kc_m() as $srow) {
			if (!isset($z[$srow['REGION']][$srow['BRANCH']])) {
				if ($_POST['case'] == 'kosong') {
					$table .= '<tr><td>' . $i . '</td>
										<td>' . $srow['BRDESC'] . '</td>
										<td>0</td></tr>';
					$i++;
				}
			} else if ($z[$srow['REGION']][$srow['BRANCH']] < 3) {
				if ($_POST['case'] == 'sebagian') {
					$table .= '<tr><td>' . $i . '</td>
										<td>' . $srow['BRDESC'] . '</td>
										<td>' . $z[$srow['REGION']][$srow['BRANCH']] . '</td></tr>';
					$i++;
				}
			} else if ($z[$srow['REGION']][$srow['BRANCH']] >= 1) {
				if ($_POST['case'] == 'terisi') {
					$table .= '<tr><td>' . $i . '</td>
										<td>' . $srow['BRDESC'] . '</td>
										<td>' . $z[$srow['REGION']][$srow['BRANCH']] . '</td></tr>';
					$i++;
				}
			}
		}
		echo '<table class="table table-striped table-bordered" style="width:100%">
						<thead>
							<tr>
								<th>No</th>
								<th>Kanca</th>
								<th>Total Isian</th>
							</tr>
						</thead>
						<tbody>' . $table . '
						</tbody>
					 </table>';
	}

	public function report_local_heroes()
	{
		$pdata['klaster']=$this->cluster_m->report_local_heroes_m();
		$pdata['navbar'] = 'navbar';
		$pdata['sidebar'] = 'sidebar';
		$pdata['content'] = 'cluster_report_local_heroes_v';
		$this->load->view('template', $pdata);
	}

	

	public function report_anggota()
	{
		ini_set('memory_limit', '-1');
		$data['kanwil'] = array();
		$z = array();
		foreach ($this->cluster_m->get_data_kanwil_m() as $row) {
			foreach ($this->cluster_m->report_anggota_m($row['kode_kanwil']) as $zrow) {
				if (!isset($z[$row['kanwil']]['kosong'])) {
					$z[$row['kanwil']]['kode_kanwil'] = $row['kode_kanwil'];
					$z[$row['kanwil']]['kosong'] = 0;
					$z[$row['kanwil']]['terisi'] = 0;
					$z[$row['kanwil']]['total_anggota'] = 0;
				}
				if ($zrow['total_anggota'] == 0) $z[$row['kanwil']]['kosong']++;
				else $z[$row['kanwil']]['terisi']++;
				$z[$row['kanwil']]['total_anggota'] += $zrow['total_anggota'];
			};
		};
		$pdata['anggota'] = $z;
		$pdata['navbar'] = 'navbar';
		$pdata['sidebar'] = 'sidebar';
		$pdata['content'] = 'cluster_report_anggota_v';
		$this->load->view('template', $pdata);
	}

	public function dldatareportanggota()
	{
		ini_set('memory_limit', '-1');
		$headerexcel[0] = array('No', 'Nama Anggota', 'NIK','Nomor Rekening', 'Jenis Kelamin', "Kode Pos", "Pinjaman", "Simpanan", "Handphone", "alamat", "Provinsi", "Kota/Kabupaten", "kecamatan" , "kelurahan", "branch", "Waktu input");
		$no = 1;
		$z = 1;
		$data = $this->cluster_m->dl_report_anggota_m($_POST['kode_kanwil']);
		foreach ($data as $cell) {
			$col = 0;
			$headerexcel[$z][$col] = $no;
			foreach (array_keys($cell) as $key) {
				$col++;
				if ($cell[$key]=="'") $cell[$key]="-";
				$headerexcel[$z][$col] = $cell[$key];
			}
			$z++;
			$no++;
		}
		echo json_encode($headerexcel);
	}

	public function dldatareportlocalheroes()
	{
		ini_set('memory_limit', '-1');
		$headerexcel[0] = array(
			'No', 'Waktu Input', 'kanwil', 'kanca',
			"Kode Kanca", "Uker", "Kode Uker", "Nama Kaunit", "PN Kaunit", "Handphone Kaunit", "Nama Mantri", "PN Mantri", "Handphone Mantri",
			"Nama Kelompok Usaha", "Jumlah Anggota (orang)", "Pinjaman anggota Kelompok", "Lokasi Usaha", "Kode Pos", "Provinsi", "Kabupaten/Kota", "Kecamantan", "Kelurahan",
			"Sektor Usaha", "Jenis Usaha Map", "Jenis Usaha", "Hasil Produk", "varian",  "Pasar Ekspor", "Tahun Pasar Ekspor", "Nilai Pasas Ekspor", "Pihak Pembeli Produk/Jasa yang Dihasilkan", "Handphone Pihak Pembeli", "Suplier Bahan Baku Produk/Jasa yang Dihasilkan", "Handphone Suplier",
			"Luas Lahan/Tempat Usaha (m2)", "Omset Usaha Perbulan (total Kelompok - Rp)",
			"Nama Ketua Kelompok", "Jenis Kelamin", "NIK", "Handphone Ketua Kelompok", "Tanggal Lahir", "Tempat lahir",
			"Punya Pinjaman", "Nominal Pinjaman BRI", "Norek Pinjaman BRI", "Kebutuhan Kredit",
			"Kebutuhan Sarana", "Kebutuhan Sarana Lainnya", "Kebutuhan Pendidikan",
			"Simpanan Bank", "Agen Brilink"
		);

		$data = $this->cluster_m->dlDataReportLocalHeroes_m();
		$no = 1;
		$z = 1;
		foreach ($data as $cell) {
			$col = 0;
			$headerexcel[$z][$col] = $no;
			foreach (array_keys($cell) as $key) {
				$col++;
				$cell[$key] = str_replace(';', ' ', $cell[$key]);
				$cell[$key] = str_replace(',', ' ', $cell[$key]);
				$headerexcel[$z][$col] = $cell[$key];
			}
			$z++;
			$no++;
		}

		echo json_encode($headerexcel, true);
	}

	public function custom_search()
	{
		$data['kanwil'] = $this->cluster_m->get_data_kanwil_m();
		$data['navbar'] = 'navbar';
		$data['sidebar'] = 'sidebar';
		$data['content'] = 'cluster_custom_search_v';
		$this->load->view('template', $data);
	}

	public function getdatacustom($status = null)
	{
		if ($this->session->userdata('permission') >= 3) {

			$list = $this->cluster_m->get_datafield_custom($status, json_decode($_POST['custom_field']));
			$data = array();
			$no = $_POST['start'];
			foreach ($list->result_array() as $field) {
				$totalanggota = $this->cluster_m->countanggota_m($field['id']);

				$jenis_usaha = $this->cluster_m->getdata_j($field['id_cluster_jenis_usaha']);

				$del = '<button class="btn btn-danger waves-effect waves-light btn-sm btn-block" onclick="deldata(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-close"></i> Hapus</button>';
				$ca = '<button class="btn btn-info waves-effect waves-light btn-sm btn-block" name="id" value="' . $field['id'] . '" type="submit" ><i class="fa fa-users"></i> Anggota</button>';
				$update = '<button class="btn btn-success waves-effect waves-light btn-sm btn-block" onclick="getform(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-pencil"></i> Update</button>';
				$upload = '<button class="btn btn-primary waves-effect waves-light btn-sm btn-block" onclick="upform(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-upload"></i> Upload</button>';
				$info	= '<button class="btn btn-info waves-effect waves-light btn-sm btn-block" onclick="infocluster(\'' . $field['id'] . '\')" type="button" ><i class="fa fa-Info"></i> Info</button>';
				$action = $ca . ($this->session->userdata('kode_uker') == 'kanpus' ? '' : $update . $del);
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $field['kanwil'];
				$row[] = $field['kanca'];
				$row[] = $field['uker'];
				$row[] = $field['kelompok_usaha'];
				$row[] = $field['kelompok_jumlah_anggota'] . " / " . $totalanggota[0]['sum'];
				$row[] = count($jenis_usaha) > 0 ? $jenis_usaha[0]['nama_cluster_jenis_usaha'] : $field['id_cluster_jenis_usaha'];
				$row[] = $field['hasil_produk'];
				if ($status == null) {
					$row[] = "status on progress";
					$row[] = '<form action="cluster/cluster_anggota" target="_blank" method="POST"><input type="hidden" name="kelompok_usaha" value="' . $field['kelompok_usaha'] . '">' . $action . '</form>';
				} else {
					$row[] = $info;
				}
				$data[] = $row;
			}
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $list->num_rows(),
				"recordsFiltered" => $this->cluster_m->count_all_custom($status,  json_decode($_POST['custom_field'])),
				"data" => $data,
			);
			echo json_encode($output);
		} else redirect('dashboard');
	}

	public function get_kanca()
	{

		$datakanca = $this->cluster_m->get_kanca_m();
		echo json_encode($datakanca);
	}

	public function get_unit()
	{
		$dataunit = $this->cluster_m->get_unit_m();
		echo json_encode($dataunit);
	}

	function get_pendidikan()
	{
		$data = $this->cluster_m->get_cluster_kebutuhan_pendidikan_pelatihan();
		echo json_encode($data);
	}

	function get_sarana()
	{
		$data = $this->cluster_m->get_cluster_kebutuhan_sarana();
		echo json_encode($data);
	}

	function get_kredit()
	{
		$data = $this->cluster_m->get_cluster_kebutuhan_skema_kredit();
		echo json_encode($data);
	}

	function get_hp(){
		$data = $this->cluster_m->get_list_hasil_produk_m();
		echo json_encode($data);
	}

	function get_v(){
		$data = $this->cluster_m->get_list_varian_m();
		echo json_encode($data);
	}

	// private function filephotoupload(){

	// $type = explode('.', $_FILES["foto"]["name"]);
	// $type = $type[count($type)-1];
	// $url = "images/".uniqid(rand()).'.'.$type;
	// //$_POST["foto"]=$url;
	// move_uploaded_file($_FILES["foto"]["tmp_name"], $url);
	// if(is_uploaded_file($_FILES["foto"]["tmp_name"])){
	// if(move_uploaded_file($_FILES["foto"]["tmp_name"], $url)){
	// return $url;
	// }
	// }
	// }

	// function migrate(){
	// 	ini_set('memory_limit', '-1');

	// 	$query="select * from cluster order by timestamp desc";
	// 	$a=$this->db->query("select * from cluster_kebutuhan_pendidikan_pelatihan")->result_array();
	// 	$b=$this->db->query("select * from cluster_kebutuhan_sarana")->result_array();
	// 	$c=$this->db->query("select * from cluster_kebutuhan_skema_kredit")->result_array();
	// 	foreach ($this->db->query($query)->result_array() as $q){
	// 			foreach ($a as $ra ){
	// 				$ia="";
	// 				if (strtolower($ra['kebutuhan_pendidikan_pelatihan'])==strtolower($q['kebutuhan_pendidikan'])) {
	// 						$ia=$ra['id_cluster_kebutuhan_pendidikan_pelatihan'];
	// 						break;
	// 				}
	// 			}
	// 			foreach ($b as $rb ){
	// 				$ib="";
	// 				if (strtolower($rb['kebutuhan_sarana'])==strtolower($q['kebutuhan_sarana'])) {
	// 						$ib=$rb['id_cluster_kebutuhan_sarana'];
	// 						break;
	// 				}
	// 			}
	// 			foreach ($c as $rc ){
	// 				$ic="";
	// 				if (($rc['kebutuhan_skema_kredit'])==($q['kebutuhan_skema_kredit'])) {
	// 						$ic=$rc['id_cluster_kebutuhan_skema_kredit'];
	// 						break;
	// 				}
	// 			}
	// 			$nq="update cluster set kebutuhan_pendidikan='".$ia."', kebutuhan_sarana='".$ib."', kebutuhan_skema_kredit='".$ic."' where id='".$q['id']."'";
	// 			//echo $nq.'</br>';
	// 			$this->db->query($nq);
	// 	}
	// }

	// 	function migrate_cluster_produk(){

	// 		$sql = $this->db->query('select DISTINCT(a.hasil_produk) as hasil, a.id_cluster_jenis_usaha, b.nama_cluster_jenis_usaha from cluster a
	// 		left join cluster_jenis_usaha b on a.id_cluster_jenis_usaha=b.id_cluster_jenis_usaha
	// 		where a.id_cluster_jenis_usaha !="" and a.hasil_produk!=""');
	// 		foreach ($sql->result_array() as $row){
	// 		    $q="insert into cluster_hasil_produk values ('".$this->uuid->v4(true)."', '".$row['id_cluster_jenis_usaha']."', '".$row['hasil']."','1');";
	// 		    echo $q."</br>";
	// 		  //  $this->db->query($q);
				
	// 		}
	// 	}
		
	// 	function migrate_cluster_varian(){
	// 	    $sql = $this->db->query('select distinct(b.varian), a.hasil_produk  from cluster_hasil_produk a
	//                 inner join cluster b on a.hasil_produk=b.hasil_produk
	//                 where b.hasil_produk!="" and b.varian!=""');
	// 		foreach ($sql->result_array() as $row){
	// 		    $q="insert into cluster_varian values ('".$this->uuid->v4(true)."', '".$row['hasil_produk']."', '".$row['varian']."', '1');";
	// 		    echo $q."</br>";
	// 		  //  $this->db->query($q);
				
	// 		}
	// 	}

	// function migrate_pendidikan(){
	// 		$sql="select * from cluster a
	// 				left join cluster_kebutuhan_pendidikan_pelatihan b on a.kebutuhan_pendidikan=b.id_cluster_kebutuhan_pendidikan_pelatihan ";
	// 		$data = $this->db->query($sql);
	// 		foreach ($data->result_array() as $row){
	// 			$q="update cluster set kebutuhan_pendidikan='".$row['kebutuhan_pendidikan_pelatihan']."' where id='".$row['id']."';";
	// 			echo $q."</br>";
	// 			$this->db->query($q);
	// 		}
	// }

	// function update_data_cleanshing(){
	// 		$sql="select * from cluster where uker is null ";
	// 		foreach ($this->db->query($sql)->result_array() as $row){
	// 				$q="select BRDESC, RGDESC from branch where BRANCH='".$row['kode_uker']."'";
	// 				foreach ($this->db->query($q)->result_array() as $srow){
	// 					$w="update cluster set uker='".$srow['BRDESC']."' where id='".$row['id']."';";
	// 					echo $w."</br>";
	// 				}
	// 			}
	// }
	// function setapprove_level(){

	// 	//set all user to maker
	// 	$q="update user set approve_level=0";
	// 	$this->db->query($q);

	// 	//set kanwil to checker
	// 	$qq='SELECT MAINBR FROM branch where MAINBR=BRANCH AND MBDESC LIKE "%KANWIL%"';
	// 	foreach ($this->db->query($qq)->result_array() as $row){
	// 		$qa="update user set approve_level=1 where username='".$row['MAINBR']."'";
	// 		echo $qa;
	// 		$this->db->query($qa);
	// 	}

	// 	//set admin as signer
	// 	$qqq='update user set approve_level=2 where username="admin"';
	// 	$this->db->query($qqq);
	// }

	private function camphotoupload($i = null, $j = null)
	{
		$encoded_data = $i;
		$binary_data = base64_decode($encoded_data);
		$url = "images/" . uniqid(rand()) . '.' . $j;
		//$_POST["foto"]=$url;
		//file_put_contents('http://www.ninadentalcare.com/'.$url, $binary_data);
		$result = file_put_contents($url, $binary_data);
		if (!$result) die("Could not save image!  Check file permissions.");
		else return './' . $url;
	}

	function getClusterInfo()
	{
		$id = $this->input->post("id");
		if (isset($id)) {
			$clusterInfo = $this->cluster_m->getClusterInfo($id);
			$clusterInfo["uker"] = empty($clusterInfo["uker"]) ? "-" : $clusterInfo["uker"];
			$clusterInfo["kaunit_nama"] = empty($clusterInfo["kaunit_nama"]) ? "-" : $clusterInfo["kaunit_nama"];
			$clusterInfo["kaunit_handphone"] = empty($clusterInfo["kaunit_handphone"]) ? "-" : $clusterInfo["kaunit_handphone"];
			$clusterInfo["nama_pekerja"] = empty($clusterInfo["nama_pekerja"]) ? "-" : $clusterInfo["nama_pekerja"];
			$clusterInfo["handphone_pekerja"] = empty($clusterInfo["handphone_pekerja"]) ? "-" : $clusterInfo["handphone_pekerja"];
			$clusterInfo["kelompok_usaha"] = empty($clusterInfo["kelompok_usaha"]) ? "-" : $clusterInfo["kelompok_usaha"];
			$clusterInfo["kelompok_pihak_pembeli"] = empty($clusterInfo["kelompok_pihak_pembeli"]) ? "-" : $clusterInfo["kelompok_pihak_pembeli"];
			$clusterInfo["kelompok_pihak_pembeli_handphone"] = empty($clusterInfo["kelompok_pihak_pembeli_handphone"]) ? "-" : $clusterInfo["kelompok_pihak_pembeli_handphone"];
			$clusterInfo["kelompok_suplier_produk"] = empty($clusterInfo["kelompok_suplier_produk"]) ? "-" : $clusterInfo["kelompok_suplier_produk"];
			$clusterInfo["kelompok_suplier_handphone"] = empty($clusterInfo["kelompok_suplier_handphone"]) ? "-" : $clusterInfo["kelompok_suplier_handphone"];
			$clusterInfo["kelompok_jumlah_anggota"] = empty($clusterInfo["kelompok_jumlah_anggota"]) ? "-" : $clusterInfo["kelompok_jumlah_anggota"];
			$clusterInfo["kelompok_cerita_usaha"] = empty($clusterInfo["kelompok_cerita_usaha"]) ? "-" : $clusterInfo["kelompok_cerita_usaha"];
			$clusterInfo["kelompok_perwakilan"] = empty($clusterInfo["kelompok_perwakilan"]) ? "-" : $clusterInfo["kelompok_perwakilan"];
			$clusterInfo["kelompok_handphone"] = empty($clusterInfo["kelompok_handphone"]) ? "-" : $clusterInfo["kelompok_handphone"];
			$clusterInfo["lokasi_usaha"] = empty($clusterInfo["lokasi_usaha"]) ? "-" : $clusterInfo["lokasi_usaha"];
			$clusterInfo["agen_brilink"] = empty($clusterInfo["agen_brilink"]) ? "-" : $clusterInfo["agen_brilink"];
			$clusterInfo["simpanan_bank"] = empty($clusterInfo["simpanan_bank"]) ? "-" : $clusterInfo["simpanan_bank"];
			$clusterInfo["pinjaman"] = empty($clusterInfo["pinjaman"]) ? "-" : $clusterInfo["pinjaman"];
			$clusterInfo["varian"] = empty($clusterInfo["varian"]) ? "-" : $clusterInfo["varian"];
			$clusterInfo["kapasitas_produksi"] = empty($clusterInfo["kapasitas_produksi"]) ? "-" : $clusterInfo["kapasitas_produksi"];
			$clusterInfo["periode_panen"] = empty($clusterInfo["periode_panen"]) ? "-" : $clusterInfo["periode_panen"];
			$clusterInfo["satuan_produksi"] = empty($clusterInfo["satuan_produksi"]) ? "-" : $clusterInfo["satuan_produksi"];
			$clusterInfo["longitude"] = $clusterInfo["longitude"] =="" ? "-" : $clusterInfo["longitude"];
			$clusterInfo["latitude"] = $clusterInfo["latitude"] =="" ? "-" : $clusterInfo["latitude"];


			$clusterPhotos = $this->cluster_m->getClusterPhotos($id);
			$clusterInfo["photos"] = $clusterPhotos;
			echo json_encode($clusterInfo);
		}
	}
	
	//////////////////cleansing data////////////////////
	// function clq(){
	// 	$q="select * from cluster_cek";
	// 	$s="";
	// 	$n=0;
	// 	$t=0;
	// 	$r=0;
	// 	foreach ($this->db->query($q)->result_array() as $row){
	// 		echo "id : ". $row['id'] ." || ".$row['kelompok_usaha'].' || '.$row['ketua_klaster'].' || '.$row['NIK'].' </br>';
	// 		$nq='select * from cluster_backup where kelompok_NIK like "%'.$row['NIK'].'%" and kelompok_handphone like "%'.$row['hp_ketua_kaster'].'%" and cluster_status=1 ';
	// 		$z=0;
	// 		foreach ($this->db->query($nq)->result_array() as $srow){
	// 			$this->db->insert('cluster',$srow);
	// 			// $this->db->query("delete from cluster where id='".$srow['id']."'");

	// 			echo 'id : '.$srow['id'].' || '.$srow['kelompok_usaha'].' || '.$srow['kelompok_perwakilan'].' || '.$srow['kelompok_NIK'].'</br>';
	// 			$z++;
	// 		}
	// 		if ($z==0) {
	// 			$t++;
	// 			$s .='no data with id '.$row['id'].'</br>';
	// 		}
			
	// 		elseif ($z==1){
	// 			$n++;
	// 			// $s .='data found id '.$row['id'].'</br>';
	// 		}
	// 		else {
	// 			$r++;
	// 			$s .='data duplicate '.$row['id'].'</br>';
	// 		}
	// 		echo '<hr></br>';
	// 	}
	// 	echo $n.'</br>';
	// 	echo $r.'</br>';
	// 	echo $t.'</br>';
	// 	echo $s;
	
	// }

	// /////////////////////set approve data///////////////////
		// function clap(){
		// 	$time=time();
		// 	$q="select * from cluster";
		// 	$r="SELECT a.username, b.REGION, b.BRDESC FROM user a 
		// 		left join branch b on a.username=b.BRANCH
		// 		where permission=3";
		// 	$r=$this->db->query($r)->result_array();
		// 	foreach ($this->db->query($q)->result_array()  as $row){
		// 		$kodekanwil="";
		// 		foreach ($r as $srow){
		// 				if ($srow['REGION'] == $row['kode_kanwil']) $kodekanwil=$srow['username'];
		// 		}
		// 		echo $nq;
		// 		$nq="update cluster set 
		// 				checker_status=1,
		// 				checker_user_update='".$kodekanwil."',
		// 				signer_status=1,
		// 				signer_user_update=2,
		// 				cluster_approval=1 
		// 				where id='".$row['id']."'";
		// 		$this->db->query($nq);
				
		// 	}
		// }

    

    // public function getalluser(){
    //     $sql="select * from user ";
    //     $i=1;
    //     foreach ($this->db->query($sql)->result_array() as $row){
    //         if ($row['username']!="admin" && $row['username']!="kanpus") {
    //             echo $i." || ".$row['username']." || " . $row['approve_level'] ."</br>";
    //             $checker=" insert into user values ('','" .$row['username']. "_c','".md5($row['username']."_c")."', '".$row['username']."' ,1,". $row['permission'].",1,1)";
    //             $signer =" insert into user values ('','" .$row['username']. "_s','".md5($row['username']."_s")."', '".$row['username']."' ,1,". $row['permission'].",1,2)";
    //             $maker  =" update user set approve_level='0' , branch='".$row['username']."' where username='".$row['username']."'"; 
    //             echo $maker ."; </br>";
    //             echo $checker."; </br>";
    //             echo $signer."; </br>";

    //             $this->db->query($maker);
    //             $this->db->query($checker);
    //             $this->db->query($signer);
    //             $i++;
    //         }
    //     }
    // }
}
