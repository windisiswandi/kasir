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

		if ($this->session->userdata("passwordLogin")) {
			$this->_data["dataUser"] = $this->db->select("*")
											->from("user")
											->where("email", $this->session->userdata("email"))
											->join('role_user', 'role_user.role_id = user.role_id')
											->get()->row_array();
			
			if ($this->_data["dataUser"]["role_id"] == 2) {		

				$this->dbuser = $this->Data_model->dbuser($this->_data["dataUser"]);
				
				$this->make_table_user();
				$this->_data["produks"] = $this->dbuser->select("*")
													   ->from("produk")
													   ->join("kategory_produk", "kategory_produk.id_kategory = produk.id_kategory")
													   ->get()->result_array();
				$this->_data["produk_kategory"] = $this->dbuser->get("kategory_produk")->result_array();
				$this->_data["productSold"] = $this->dbuser->get_where("transaksi", ["tgl_transaksi" => date("Y-m-d")])->num_rows();
				$this->_data["earningToday"] = $this->dbuser->select("sum(jml_bayar) as total_bayar")
															->from("pembayaran")
															->where("tgl_pembayaran", date("Y-m-d"))
															->get()->row_array();
			}else {
				$this->_data["users"] = $this->db->select("*")
												 ->from("user")
												 ->join("role_user", "role_user.role_id = user.role_id")
												 ->get()->result_array();
			}								
		}else {
			redirect("Auth/login");
		}
	}

	public function index()
	{
		$this->_data["title"] = "DASHBOARD";
		$this->load->view('templates/header', $this->_data);
		$this->load->view('Dashboard/main', $this->_data);
		$this->load->view('templates/footer', $this->_data);
	}

	public function transaksi()
	{
		$transaksi = $this->dbuser->get_where("transaksi", ["tgl_transaksi" => date("Y-m-d")])->result_array();
		$this->_data["tLast"] = [];
		if (count($transaksi)) {
			if ($transaksi[count($transaksi) - 1]["kode_pembayaran"] == "") {
				$this->_data["noresi"] = $transaksi[count($transaksi) - 1]["no_resi"];
				$this->_data["tLast"] = $this->dbuser->select("*")
													 ->from("transaksi")
													 ->where("no_resi", $this->_data["noresi"])
													 ->join("produk", "produk.kd_produk = transaksi.kd_produk")
													 ->get()->result_array();
			}else {
				$this->_data["noresi"] = $transaksi[count($transaksi) - 1]["no_resi"];
				$this->_data["noresi"] = substr($this->_data["noresi"], -4);
				$this->_data["noresi"] = intval($this->_data["noresi"]) + 1;
				$this->_data["noresi"] = "T-".date("dmy").sprintf("%04s", strval($this->_data["noresi"]));
			}
		}else {
			$this->_data["noresi"] = "T-".date("dmy")."0001";
		}

		$this->_data["title"] = "Transaction";
		$this->load->view('templates/header', $this->_data);
		$this->load->view('Dashboard/transaksi', $this->_data);
		$this->load->view('templates/footer');
	}




// ======================================== CRUD USER =============================================== //

	public function insertUser()
    {
		$this->_data["title"] = "DASHBOARD | Insert User";
		if ($this->session->userdata("role_id") == 1) {
	
			if ($this->input->post("submit")) {
				$data = [
					"name_user" => $this->input->post("name_user"),
					"email" => $this->input->post("email"),
					"password" => password_hash($this->input->post("password"), PASSWORD_DEFAULT),
					"is_active" => true,
					"date_created" => date("Y-m-d"),
					"role_id" => 1
				];

				if ($this->Data_model->addUser($data)) {
					$this->session->set_userdata("crudsukses", "User Successfully to Added");
					redirect("Dashboard");
				}

			}else {
				$this->load->view("templates/header", $this->_data);
				$this->load->view("Dashboard/create_user");
				$this->load->view("templates/footer");
			}
		}else {
			redirect();
		}
    }

	public function updateUser($email)
    {
		$this->_data["title"] = "DASHBOARD | Insert User";
		if ($this->session->userdata("role_id") == 1) {
			$this->_data["dataUser"] = $this->db->select("*")
												 ->from("user")
												 ->join("role_user", "role_user.role_id = user.role_id")
												 ->get()->row_array();
			if ($this->input->post("submit")) {
				$data = [
					"name_user" => $this->input->post("name_user"),
					"email" => $this->input->post("email")
				];
				$id_user = $this->input->post('id_user');

				if ($this->Data_model->updateUser($data, $id_user)) {
					$this->session->set_userdata("crudsukses", "User Successfully to Updated");
					redirect("Dashboard");
				}
			}else {
				$this->load->view("templates/header", $this->_data);
				$this->load->view("Dashboard/update_user", $this->_data);
				$this->load->view("templates/footer");
			}
		}else {
			redirect();
		}
    }


// ======================================== CRUD PRODUK =============================================== //

	public function addProduct()
	{
		$data = [
			"kd_produk" => $this->input->post("kd_produk"),
			"name_produk" => $this->input->post("name_produk"),
			"hrg_produk" => $this->input->post("hrg_produk"),
			"hrg_jual" => $this->input->post("hrg_jual"),
			"volume" => $this->input->post("volume"),
			"id_kategory" => $this->input->post("id_kategory"),
			"stok_produk" => $this->input->post("stok")
		];

		if ($this->dbuser->insert("produk", $data)) {
			$this->session->set_userdata("crudsukses", "Produk Successfully to Added");
			redirect("Dashboard");
		}
	}

	public function updateProduk($kd_produk = null)
	{
		$data = $this->dbuser->get_where("produk", ["kd_produk" => $kd_produk])->row_array();

		if ($kd_produk) {

			if ($data) {

				if ($this->input->post("submit")) {

					$dataUpdate = [
						"kd_produk" => $this->input->post("kd_produk"),
						"name_produk" => $this->input->post("name_produk"),
						"hrg_produk" => $this->input->post("hrg_produk"),
						"hrg_jual" => $this->input->post("hrg_jual"),
						"volume" => $this->input->post("volume"),
						"id_kategory" => $this->input->post("id_kategory"),
						"stok_produk" => $this->input->post("stok"),
					];
					$this->dbuser->where("kd_produk", $dataUpdate["kd_produk"]);
					
					if ($this->dbuser->update("produk", $dataUpdate)) {
						$this->session->set_userdata("crudsukses", "Produk Successfully to Updated");
						redirect("Dashboard");
					}
	
				}else {
					$this->_data["title"] = "DASHBOARD | Update";
					$this->load->view('templates/header', $this->_data);
					$this->load->view('Dashboard/update_produk', $data);
					$this->load->view('templates/footer');
				}

			}else {
				echo "Kode Barang Tidak di temukan";
			}

		}else {
			redirect("Dashboard");
		}
	}

	public function deleteProduk($kd_produk = null)
	{
		if ($kd_produk) {
			if ($this->dbuser->delete("produk", ["kd_produk" => $kd_produk])) {
				$this->session->set_userdata("crudsukses", "Produk Successfullt to Deleted");
				redirect("Dashboard");
			}
		}else {
			redirect("Dashboard");
		}
	}

// ======================================== CRUD TRANSAKSI =============================================== //

	public function insertTransaksi()
	{
		$kd_product = $this->input->post("kd_product");
		$jml = $this->input->post("qty");
		$noresi = $this->input->post("noresi");
		$produk = $this->dbuser->get_where("produk", ["kd_produk" => $kd_product]);
		if ($produk->num_rows()) {
			if (!($produk->row_array()["stok_produk"] <= 0)) {
				$this->dbuser->update("produk", ["stok_produk"=>$produk->row_array()["stok_produk"]-$jml], "kd_produk = $kd_product");
			}	

			$dataTransaksi = [
				"kd_produk" => $kd_product,
				"jml_pembelian" => $jml,
				"tgl_transaksi" => date("Y-m-d"),
				"no_resi" => $noresi
			];
			
			if ($this->dbuser->insert("transaksi", $dataTransaksi)) {
				$result["data"] = $this->dbuser->select("*")->from("transaksi")
															->where("no_resi", $noresi)
															->join("produk", "produk.kd_produk = transaksi.kd_produk")
															->get()->result_array();

				return $this->load->view("transaksi/data", $result);
			}

		}else {
			echo json_encode(["error"=>false, "msg"=>"Kode Barang Tidak Valid atau Tidak Ditemukan"]);
		}
	}
	
	public function deleteItemTransaksi($noresi = null)
	{
		if ($noresi) {
			$this->dbuser->where("no_resi", $noresi);
			$this->dbuser->delete("transaksi");
		}else {
			$this->dbuser->where("id_transaksi", $this->input->post("id"));
			if ($this->dbuser->delete('transaksi')) {
				$result["data"] = $this->dbuser->select("*")->from("transaksi")
																->where("no_resi", $this->input->post("noresi"))
																->join("produk", "produk.kd_produk = transaksi.kd_produk")
																->get()->result_array();
				return $this->load->view("transaksi/data", $result);
			}
		}
	}

	public function totalBayar()
	{
		$noresi = $this->input->post("noresi");
		$data = $this->dbuser->select("hrg_jual, jml_pembelian")->from("transaksi")
										->where("no_resi", $noresi)
										->join("produk", "produk.kd_produk = transaksi.kd_produk")
										->get()->result_array();
		$totalBayar = 0;
		foreach ($data as $bayar) {
			$totalBayar += $bayar["hrg_jual"] * $bayar["jml_pembelian"];
		}
		echo json_encode(["totalBayar" => "Rp ".number_format($totalBayar,0,'','.')]);
	}

	public function prosesPayment()
	{
		$kode_pembayaran = "1234567890";
		$kode_pembayaran = str_shuffle($kode_pembayaran);
		$jml_bayar = $this->input->post("jml_bayar");
		// $jml_bayar = strstr_replace("Rp ", "", $jml_bayar);
		$noresi = $this->input->post("noresi");
		$pembayaran = [
			"kode_pembayaran" => $kode_pembayaran,
			"jml_bayar" => $jml_bayar,
			"tgl_pembayaran" => date("Y-m-d")
		];
		if ($this->dbuser->insert("pembayaran", $pembayaran)) {
			$this->dbuser->where("no_resi", $noresi);
			$this->dbuser->update("transaksi", ["kode_pembayaran"=>$kode_pembayaran]);
			$this->session->set_userdata("crudsukses", "Transaction Successfully");
			redirect("Dashboard/transaksi");
		}
	}

	
	public function riwayat_transaksi($day = null)
	{
		$this->_data["title"] = "DASHBOARD | RIWAYAT TRANSAKSI";
		if ($day) {
			$this->_data["product_sold"] = $this->dbuser->select("name_produk, hrg_jual, kategory, jml_pembelian, tgl_transaksi, no_resi")
														->order_by("no_resi", "ASC")
														->from("transaksi")
														->where("tgl_transaksi", date("Y-m-d"))
														->where("kode_pembayaran !=", NULL)
														->join("produk", "produk.kd_produk = transaksi.kd_produk")
														->join("kategory_produk", "kategory_produk.id_kategory = produk.id_kategory")
														->get()->result_array();
		}else {
			$this->_data["product_sold"] = $this->dbuser->select("name_produk, hrg_jual, kategory, jml_pembelian, tgl_transaksi, no_resi")
														->order_by("no_resi", "ASC")
														->from("transaksi")
														->where("kode_pembayaran !=", NULL)
														->join("produk", "produk.kd_produk = transaksi.kd_produk")
														->join("kategory_produk", "kategory_produk.id_kategory = produk.id_kategory")
														->get()->result_array();
		}

		$this->load->view("templates/header", $this->_data);
		$this->load->view("Dashboard/product_sold", $this->_data);
		$this->load->view("templates/footer");
	}

	public function laporan_harian()
	{
		echo "coming soon";
	}

	public function laporan_bulanan()
	{
		echo "coming soon";
	}


// ==================================================================================================== //

	function make_table_user()
    {
		$table_kategory = "CREATE TABLE IF NOT EXISTS kategory_produk (".
							"id_kategory varchar(10) PRIMARY KEY,".
							"kategory varchar(100)".
							")"; 

        $table_produk = "CREATE TABLE IF NOT EXISTS produk (".
							"kd_produk varchar(100) PRIMARY KEY,".
							"name_produk varchar(100),".
							"hrg_produk int(20),".
							"hrg_jual int(20),".
							"volume varchar(20),".
							"id_kategory varchar(10) NOT NULL,".
							"stok_produk int,".
							"FOREIGN KEY (id_kategory) REFERENCES kategory_produk(id_kategory)".
							")"; 

        $table_transaksi = "CREATE TABLE IF NOT EXISTS transaksi (".
							"id_transaksi int AUTO_INCREMENT PRIMARY KEY,".
							"kd_produk varchar(100),".
							"jml_pembelian int,".
							"no_resi varchar(100),".
							"tgl_transaksi date,".
							"kode_pembayaran varchar(100),".
							"FOREIGN KEY (kode_pembayaran) REFERENCES pembayaran(kode_pembayaran),".
							"FOREIGN KEY (kd_produk) REFERENCES produk(kd_produk)".
							")"; 

        $table_pembayaran = "CREATE TABLE IF NOT EXISTS pembayaran (".
							"kode_pembayaran varchar(100) NOT NULL PRIMARY KEY,".
							"tgl_pembayaran date,".
							"jml_bayar int(20)".
							")"; 

		$this->dbuser->query($table_kategory);
		$this->dbuser->query($table_produk);
		$this->dbuser->query($table_pembayaran);
		$this->dbuser->query($table_transaksi);
    }

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
