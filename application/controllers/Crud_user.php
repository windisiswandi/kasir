<?php

class Crud_user extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model("Data_model");
        
    }
    public function index()
    {
        $messagePass = "
            <div style='margin: 0 auto; max-width: 450px; padding:0 10px;'>
                <div class='box-content' style='margin-top: 50px;max-width: 450px;border: 5px solid #2e59d9; padding:20px 50px;'>
                
                    <h2>Reset Your Password</h2>
                    <p>You have successfully created a <b>Lombok Printing</b> Account, Please click on the link below to Verify your email address and complete registration</p>
                    <br>
                    <a style='text-decoration: none; color: white; width: 100%; background:#2e59d9; border-radius: 5px; padding:10px 20px; text-align: center;' target='_blank' href='".base_url("Auth/activation?email=&token=")."'>Reset Password</a><br><br>
                    </div>
            </div>";
        echo $messagePass;
    }
    public function delete($id_user)
    {
        $USER = $this->db->get_where("user", ["id_user" => $id_user])->row_array();
        $name_database = $USER["name_database"];
        $this->db->query("DROP DATABASE $name_database");
        if ($this->db->delete("user", ["id_user" => $id_user])) {
            $this->session->set_userdata("crudsukses", "User successfully to deleted");
            redirect("Dashboard");
        }
    }

}