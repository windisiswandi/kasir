<?php

class Data_model extends CI_Model {


    public function dbuser($data)
    {
        $config['hostname'] = 'localhost';
        $config['username'] = 'root';
        $config['password'] = 'Administrator1@phpmyadmin.windi';
        $config['database'] = $data["name_database"];
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = '';
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';

        return $this->load->database($config, TRUE);
    }

    public function tesLoginUser($data)
    {
        $user = $this->db->get_where("user", ["email" => $data["email"]])->result_array();
        if ($user) {
            if (password_verify($data["password"], $user[0]["password"])) {
                return ["status" => true];
            }else {
                return ["status" => false, "errorPassword" => "Password is wrong"];
            }
        }else {
            return ["status" => false, "errorUsername" => "Email not registered"];
        }
    }

    public function getUserBy($by, $value)
    {
        return $this->db->get_where("user", [$by => $value])->row_array();
    }

    public function addUser($data)
    {
        return $this->db->insert("user", $data);
    }

    public function updateUser($data, $id_user)
    {
        $this->db->where("id_user", $id_user);
        return $this->db->update("user", $data);
    }
}