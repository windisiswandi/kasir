<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."third_party/Mike42/autoloader.php";
use Escpos\PrintConnectors\WindowsPrintConnector;
use Escpos\CapabilityProfile;
use Escpos\Printer;

class Dashboard extends CI_Controller {
	protected $_data = [];

	function __construct()
	{
		parent::__construct();
		$this->load->model("Data_model");
		$this->load->library("form_validation");

		if (!$this->session->userdata("username")) {
			redirect("Auth/login");
		}else {
			$this->_data["earningToday"] = $this->db->select("sum(invoice_total) as total_bayar")
													->from("invoices")->where("tgl_invoice", date("Y-m-d"))
													->get()->row_array();
			// $this->_data["soldProduk"] = $this->db->get_where("penjualan", ["tgl_beli" => date("Y-m-d")])->num_rows();
			$this->_data["produks"] = $this->db->select("*")
											   ->from("produk")
											   ->join("kategori", "kategori.id_kategori = produk.id_kategori")
											   ->get()->result_array();
			$this->_data['kategori'] = $this->db->get('kategori')->result_array();
			$this->_data["produk_kategory"] = $this->db->get("kategori")->result_array();
			$this->_data['notice_produk'] = $this->db->get_where('produk', 'produk.stok_produk <= produk.notice_stok')->result_array();
			$this->_data["dataUser"] = $this->db->get_where("user", ["username" =>  $this->session->userdata("username")])->row_array();
		}
	}

	public function index()
	{
		$this->_data["title"] = "DASHBOARD";
		$this->_data['dActive'] = true;
		$this->load->view('templates/header', $this->_data);
		$this->load->view('Dashboard/main', $this->_data);
		$this->load->view('templates/footer', $this->_data);
	}

	public function produks()
	{
		$this->_data["title"] = "DASHBOARD | PRODUK";
		$this->_data['pActive'] = true;
		$this->load->view('templates/header', $this->_data);
		$this->load->view('Dashboard/produks', $this->_data);
		$this->load->view('templates/footer', $this->_data);
	}

	public function kategori_produk()
	{
		$this->_data["title"] = "DASHBOARD | KATEGORI PRODUK";
		$this->_data['kActive'] = true;
		$this->load->view('templates/header', $this->_data);
		$this->load->view('Dashboard/kategori_produk', $this->_data);
		$this->load->view('templates/footer', $this->_data);
	}

	public function transaksi()
	{
		$this->_data["tLast"] = $this->db->select("nama_produk, jml_beli, hrg_jual, diskon, id_item")
										 ->from("temp_penjualan")
										 ->where('id_user', $this->_data['dataUser']['id_user'])
										 ->join("produk", "produk.kd_produk = temp_penjualan.kd_produk")
										 ->get()->result_array();
		$this->_data["title"] = "Transaksi";
		$this->_data['tActive'] = true;
		$this->load->view('templates/header', $this->_data);
		$this->load->view('Dashboard/transaksi', $this->_data);
		$this->load->view('templates/footer');
	}

// ======================================== CRUD PRODUK =============================================== //

	public function addProduct()
	{
		$file_foto = $_FILES['file_foto'];
		$tempdirfoto = FCPATH."/assets/img/imgProduk/";
		$data = [
			"kd_produk" => $this->input->post("kd_produk"),
			"nama_produk" => $this->input->post("nama_produk"),
			"hrg_beli" => $this->input->post("hrg_beli"),
			"hrg_jual" => $this->input->post("hrg_jual"),
			"id_kategori" => $this->input->post("id_kategori"),
			"stok_produk" => $this->input->post("stok"),
			"notice_stok" => $this->input->post('notice_stok'),
			"ket_produk" => $this->input->post('ket_produk')
		];

		if (!($file_foto['error'] == 4)) {
			$extensiFoto = explode('.', $file_foto['name']);
			$extensiFoto = end($extensiFoto);
			$extensiGambar = ['jpg', 'JPEG', 'jpeg', 'png'];

			if (in_array($extensiFoto, $extensiGambar)) {
				$namaFoto = uniqid().".$extensiFoto";
				$target_path = $tempdirfoto.$namaFoto;
				move_uploaded_file($file_foto['tmp_name'], $target_path);
				$data["foto_produk"] = $namaFoto;
			}else {
				$this->session->set_userdata('crudfailed', "File yang diinput harus tipe gambar");
				redirect("Dashboard/produks");
			}

		}

		if ($this->Data_model->insertProduk($data)) {
			$this->session->set_userdata("crudsukses", "Produk Successfully to Added");
			redirect("Dashboard/produks");
		}
	}

	public function updateProduk($kd_produk = null)
	{
		$data = $this->db->get_where("produk", ["kd_produk" => $kd_produk])->row_array();

		if ($kd_produk) {

			if ($data) {

				if ($this->input->post("submit")) {
					$file_foto = $_FILES['file_foto'];
					$tempdirfoto = FCPATH."/assets/img/imgProduk/";
					$dataUpdate = [
						"kd_produk" => $this->input->post("kd_produk"),
						"nama_produk" => $this->input->post("nama_produk"),
						"hrg_beli" => $this->input->post("hrg_beli"),
						"hrg_jual" => $this->input->post("hrg_jual"),
						"id_kategori" => $this->input->post("id_kategori"),
						"stok_produk" => $this->input->post("stok_produk"),
						"notice_stok" => $this->input->post('notice_stok'),
						"ket_produk" => $this->input->post('ket_produk')
					];

					if (!($file_foto['error'] == 4)) {
						$extensiFoto = explode('.', $file_foto['name']);
						$extensiFoto = end($extensiFoto);
						$extensiGambar = ['jpg', 'JPEG', 'jpeg', 'png'];
			
						if (in_array($extensiFoto, $extensiGambar)) {
							$namaFoto = uniqid().".$extensiFoto";
							$target_path = $tempdirfoto.$namaFoto;
							move_uploaded_file($file_foto['tmp_name'], $target_path);
							$dataUpdate["foto_produk"] = $namaFoto;
							unlink($tempdirfoto.$data['foto_produk']);
						}else {
							$this->session->set_userdata('crudfailed', "File yang diinput harus tipe gambar");
							redirect("Dashboard/updateProduk/$kd_produk");
						}
			
					}
					
					if ($this->Data_model->updateProduk($dataUpdate)) {
						$this->session->set_userdata("crudsukses", "Produk Successfully to Updated");
						redirect("Dashboard/produks");
					}
	
				}else {
					$this->_data["title"] = "DASHBOARD | UPDATE PRODUK";
					$this->load->view('templates/header', $this->_data);
					$this->load->view('Dashboard/update_produk', $data);
					$this->load->view('templates/footer');
				}

			}else {
				echo "Kode Barang Tidak di temukan";
			}

		}else {
			redirect("Dashboard/produks");
		}
	}

	public function deleteProduk($kd_produk = null)
	{
		if ($kd_produk) {
			$data = $this->db->select('foto_produk')
							 ->from('produk')
							 ->where('kd_produk', $kd_produk)
							 ->get()->row_array();

			unlink(FCPATH."/assets/img/imgProduk/".$data['foto_produk']);
			if ($this->db->delete("produk", ["kd_produk" => $kd_produk])) {
				$this->session->set_userdata("crudsukses", "Produk Successfullt to Deleted");
				redirect("Dashboard/produks");
			}
		}else {
			redirect("Dashboard/produks");
		}
	}

	public function insertKategory()
	{
		$data["nama_kategori"] = $this->input->post("kategory");
		if ($this->db->insert("kategori", $data)) {
			echo json_encode(["status"=>true, "msg"=>"kategory berhasil di tambahkan"]);
		}else {
			echo json_encode(["status"=>false, "msg"=>"Gagal menambah kategory"]);
		}
	}

	public function deleteKategori($id_kategori)
	{
		$getProduk = $this->db->get_where('produk', ['id_kategori' => $id_kategori]);

		if (!$getProduk->num_rows()) {
			$this->db->delete('kategori', ['id_kategori' => $id_kategori]);
			$this->session->set_userdata("crudsukses", "Kategori Successfull to Deleted");
			redirect("Dashboard/kategori_produk");
		}else {
			$this->session->set_userdata("crudfailed", "Produk dengan kategori ini masih ada");
			redirect("Dashboard/kategori_produk");
		}
	}

	public function getKategori()
	{
		$kategory = $this->db->get("kategori")->result_array();
		$data["data"] = [];
		foreach ($kategory as $k) {
			$data["data"][] = [
				"kategory" => $k["nama_kategori"],
				"id_kategory" => $k["id_kategori"]
			];
		}

		echo json_encode($data);
	}

// ======================================== CRUD TRANSAKSI =============================================== //

	public function insertTransaksi()
	{
		$kd_produk = $this->input->post("kd_produk");
		$diskon = $this->input->post("diskon");
		$jml = $this->input->post("qty");
		$produk = $this->db->get_where("produk", ["kd_produk" => $kd_produk]);

		if ($produk->num_rows()) {
			if ($produk->row_array()["stok_produk"] < $jml) {
				echo json_encode(["error"=>false, "msg"=>"Stok produk tidak mencukupi"]);
				die;
			}else {
				if (!($produk->row_array()["stok_produk"] <= 0)) {
					$this->db->update("produk", ["stok_produk"=>$produk->row_array()["stok_produk"]-$jml], "kd_produk = $kd_produk");
				}
			}

			$dataTransaksi = [
				"kd_produk" => $kd_produk,
				"jml_beli" => $jml,
				"diskon" => $diskon,
				"id_user" => $this->_data["dataUser"]["id_user"]
			];
			
			if ($this->db->insert("temp_penjualan", $dataTransaksi)) {
				$result["data"] = $this->db->select("*")->from("temp_penjualan")
															->where("id_user", $this->_data["dataUser"]["id_user"])
															->join("produk", "produk.kd_produk = temp_penjualan.kd_produk")
															->get()->result_array();

				return $this->load->view("transaksi/data", $result);
			}

		}else {
			echo json_encode(["error"=>false, "msg"=>"Kode Barang Tidak Valid atau Tidak Ditemukan"]);
		}
	}
	
	public function deleteItemTransaksi()
	{
		if (!$this->input->post("id")) {
			$this->Data_model->returnTempPenjualan();

			$this->db->where("id_user",  $this->_data["dataUser"]["id_user"]);
			$this->db->delete("temp_penjualan");
		}else {
			$this->Data_model->returnTempPenjualan($this->input->post("id"));

			$this->db->where("id_item", $this->input->post("id"));
			$this->db->where("id_user", $this->_data["dataUser"]["id_user"]);
			if ($this->db->delete('temp_penjualan')) {
				$result["data"] = $this->db->select("*")
										   ->from("temp_penjualan")
										   ->where("id_user", $this->_data["dataUser"]["id_user"])
										   ->join("produk", "produk.kd_produk = temp_penjualan.kd_produk")
										   ->get()->result_array();

				return $this->load->view("transaksi/data", $result);
			}
		}
	}

	public function totalBayar()
	{
		$data = $this->db->select("*")->from("temp_penjualan")
										->where("id_user", $this->_data["dataUser"]["id_user"])
										->join("produk", "produk.kd_produk = temp_penjualan.kd_produk")
										->get()->result_array();
		$totalBayar = 0;
		foreach ($data as $bayar) {
			$totalBayar += ($bayar["hrg_jual"] * $bayar["jml_beli"]) - $bayar['diskon'];
		}
		echo json_encode(["totalBayar" => "Rp ".number_format($totalBayar,0,'','.')]);
	}

	public function prosesPayment()
	{
		$kode_pembayaran = str_shuffle("1234567890");
		$jml_bayar = $this->input->post("jml_bayar");
		$noresi = $this->createFaktur();
		$pembayaran = [
			"kode_pembayaran" => $kode_pembayaran,
			"jml_bayar" => $jml_bayar,
			"tgl_pembayaran" => date("Y-m-d")
		];

		if ($this->db->insert("pembayaran", $pembayaran)) {
			$dataTemp = $this->db->get_where("temp_penjualan", ["id_user" => $this->_data["dataUser"]["id_user"]])->result_array();
			foreach ($dataTemp as $dp) {
				$data = [
					"kd_produk" => $dp["kd_produk"],
					"jml_beli" => $dp["jml_beli"],
					"tgl_beli" => $dp["tgl_beli"],
					"no_resi" => $noresi,
					"kode_pembayaran" => $kode_pembayaran
				];
				$this->db->insert("penjualan", $data);
			}

			$this->deleteItemTransaksi();
			$this->session->set_userdata("crudsukses", "Transaction Successfully");
			redirect("Dashboard/transaksi");
		}
	}

	public function createFaktur()
	{
		$transaksi = $this->db->get_where("penjualan", ["tgl_beli" => date("Y-m-d")])->result_array();
		if (count($transaksi)) {
			$noresi = $transaksi[count($transaksi) - 1]["no_resi"];
			$noresi = substr($noresi, -5);
			$noresi = intval($noresi) + 1;
			$noresi = "T-".date("dmy").sprintf("%05s", strval($noresi));
		}else {
			$noresi = "T-".date("dmy")."00001";
		}

		return $noresi;
	}


	
	public function riwayat_transaksi($day = null)
	{
		$this->_data["title"] = "DASHBOARD | RIWAYAT TRANSAKSI";
		if ($day) {
			$this->_data["product_sold"] = $this->db->select("nama_produk, hrg_jual, kategory, jml_beli, tgl_beli, no_resi")
														->order_by("no_resi", "ASC")
														->from("penjualan")
														->where("tgl_beli", date("Y-m-d"))
														->join("produk", "produk.kd_produk = penjualan.kd_produk")
														->join("kategory_produk", "kategory_produk.id_kategory = produk.id_kategory")
														->get()->result_array();
		}else {
			$this->_data["product_sold"] = $this->db->select("nama_produk, hrg_jual, kategory, jml_beli, tgl_beli, no_resi")
														->order_by("no_resi", "ASC")
														->from("penjualan")
														->join("produk", "produk.kd_produk = penjualan.kd_produk")
														->join("kategory_produk", "kategory_produk.id_kategory = produk.id_kategory")
														->get()->result_array();
		}
		$this->_data['rActive'] = true;
		$this->load->view("templates/header", $this->_data);
		$this->load->view("Dashboard/product_sold", $this->_data);
		$this->load->view("templates/footer");
	}

// ======================================== LAPORAN =============================================== //

	public function laporan_harian()
	{
		$this->_data["title"] = "DASHBOARD | LAPORAN HARIAN";
		// $this->_data["pHarian"] = $this->db->select("nama_produk, hrg_jual, jml_beli, tgl_beli")
		// 								   ->from("penjualan")
		// 								   ->where("tgl_beli", date("Y-m-d"))
		// 								   ->join("produk", "produk.kd_produk = penjualan.kd_produk")
		// 								   ->get()->result_array();

		$this->load->view("templates/header", $this->_data);
		$this->load->view("Dashboard/laporan_harian", $this->_data);
		$this->load->view("templates/footer");
	}

	public function getDataHarian($date)
	{
		$data["soldProduk"] = $this->db->get_where("penjualan", ["tgl_beli" => $date])->num_rows();
		$data["earningToday"] = $this->db->select("sum(jml_bayar) as total_bayar")
													->from("pembayaran")->where("tgl_pembayaran", $date)
													->get()->row_array();
		$data["pHarian"] = $this->db->select("nama_produk, hrg_jual, jml_beli, tgl_beli")
										   ->from("penjualan")
										   ->where("tgl_beli", $date)
										   ->join("produk", "produk.kd_produk = penjualan.kd_produk")
										   ->get()->result_array();
		if (count($data["pHarian"])) {
			return $this->load->view("transaksi/data_laporan_harian", $data);
		}else {
			echo json_encode(["msg" => "Tidak ada data transaksi pada tanggal ini"]);
		}
	}

	public function laporan_bulanan()
	{
		echo "coming soon";
	}


// ==================================================================================================== //

	public function tesPrint()
	{
		$name_printer = "EPSON L3110 Series";
		$profile = CapabilityProfile::load("simple");
		$connector = new WindowsPrintConnector($name_printer);
		$printer = new Printer($connector, $profile);

		$printer->text("windi ganteng");
		$printer->feed(4);
		$printer->cut();
		$printer->close();
	}

	
}
