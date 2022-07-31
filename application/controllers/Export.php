<?php

class Export extends CI_Controller {


    public function exportHarian()
    {
        $tanggal = $this->input->post("tanggal");
        if ($this->input->post("export") == "print") {
            
            $this->load->view("export/export_harian");
        }
    }
}