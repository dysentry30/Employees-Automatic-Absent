<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{

    public function get_user($id = null)
    {
        if (empty($id) || $id == null) {
            $data = $this->session->session_user;
            $this->db->where("username", $data["username"]);
            return $this->db->get("user_account")->row_array();
        } else {
            $this->db->where("id", $id);
            return $this->db->get("user_account")->row_array();
        }
    }

    public function get_usersTimeWorkAndHome()
    {
        $this->db->where("username", $this->session->session_user["username"]);
        $this->db->order_by("id", "desc");
        return $this->db->get("kehadiran")->row_array();
    }

    public function get_timeWorkAndHome()
    {
        return $this->db->get("time_work")->row_array();
    }

    public function get_list_karyawan()
    {
        $data = $this->session->session_user;
        $this->db->where("nama", $data["nama"]);
        return $this->db->get("list_karyawan")->row_array();
    }

    public function get_all_list_karyawan()
    {

        return $this->db->get("list_karyawan")->result_array();
    }

    public function get_all_kehadiran()
    {
        return $this->db->get("kehadiran")->result_array();
    }

    public function count_all_list_kehadiran()
    {
        return $this->db->get("kehadiran")->num_rows();
    }

    public function get_all_tidak_masuk()
    {
        return $this->db->get("tidak_masuk")->result_array();
    }

    public function count_all_list_tidak_masuk()
    {
        return $this->db->get("tidak_masuk")->num_rows();
    }

    public function get_all_keterlambatan()
    {
        return $this->db->get("keterlambatan")->result_array();
    }

    public function count_all_list_keterlambatan()
    {
        return $this->db->get("keterlambatan")->num_rows();
    }

    public function verify_account($account)
    {
        // $getUser = $this->db->get("user_account")->result_array();
        $getUser = $this->db->get_where("user_account", array("username" => $account["username"]))->row_array();
        if (password_verify($account["password"], $getUser["password"])) {
            return $getUser;
        }
        // var_dump($getUser);
        return null;
    }

    public function count_all_list_karyawan()
    {
        return $this->db->get("list_karyawan")->num_rows();
    }

    public function update($tableName, $data)
    {
        if ($this->db->update($tableName, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function insert($data)
    {
        $date = date_create($data["born"]);
        $list_karyawan = [
            "nama" => $data["nama"],
            "tanggal-lahir" => date_format($date, "Y-m-d"),
            "profile_img" => $data["file_name"]
        ];

        $this->db->insert("list_karyawan", $list_karyawan);
        if ($this->db->affected_rows() > 0) {
            $user_account = [
                "nama"     => $data["nama"],
                "username" => $data["username"],
                "password" => password_hash($data["password"], PASSWORD_DEFAULT),
                "admin"    => 0,
            ];
            $this->db->insert("user_account", $user_account);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata("sukses", "Data Berhasil Ditambah");
                redirect("login", "refresh");
            } else {
                $this->session->set_flashdata("gagal", "Data Gagal Ditambahkan, Coba lagi!!");
                redirect("signup", "refresh");
            }
        } else {
            $this->session->set_flashdata("gagal", "Data Gagal Ditambahkan, Coba lagi!!");
            redirect("signup", "refresh");
        }
    }
}
