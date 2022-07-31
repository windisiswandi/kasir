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
}