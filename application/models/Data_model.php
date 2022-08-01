<?php

class Data_model extends CI_Model {

    public function insertProduk($data)
    {
        return $this->db->insert("produk", $data);
    }

    public function updateProduk($data)
    {
        $this->db->where("kd_produk", $data["kd_produk"]);
        return $this->db->update("produk", $data);
    }

    public function returnTempPenjualan($id_item = null)
    {
        if ($id_item) {
            $getItem = $this->db->get_where("temp_penjualan", ['id_item' => $id_item])->row_array();
            $updateProduk = $this->db->get_where("produk", ["kd_produk" => $getItem['kd_produk']])->row_array();
            $updateProduk['stok_produk'] += $getItem['jml_beli'];
            $this->db->where(["kd_produk" => $updateProduk['kd_produk']]);
            return $this->db->update('produk', $updateProduk);
        }else {
            $getItemAll = $this->db->get('temp_penjualan')->result_array();
            
            foreach ($getItemAll as $item) {
                $updateProduk = $this->db->get_where("produk", ["kd_produk" => $item['kd_produk']])->row_array();
                $updateProduk['stok_produk'] += $item['jml_beli'];
                $this->db->where(["kd_produk" => $updateProduk['kd_produk']]);
                $this->db->update('produk', $updateProduk);
            }
        }
    }
}