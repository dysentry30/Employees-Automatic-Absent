<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    protected $user;
    protected $data_user;
    protected $time;
    protected $user_time;
    function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper("file");
        $this->load->helper("form");
        $this->load->library("pagination");
        $this->load->model("Karyawan_model", "", TRUE);

        $config["upload_path"]      = "./assets/profile-image/";
        $config["allowed_types"]    = "png|jpg|jpeg";
        $config["max_size"]         = 2000;

        $this->load->library("upload", $config);
        date_default_timezone_set("Asia/Jakarta");

        if (!empty($this->session->session_user)) {
            $this->user      = $this->Karyawan_model->get_user();
            $this->data_user = $this->Karyawan_model->get_list_karyawan();
            $this->time = $this->Karyawan_model->get_timeWorkAndHome();
            $this->user_time = $this->Karyawan_model->get_usersTimeWorkAndHome();

            // TODO Check if days is expired 
            $time_work = new DateTime($this->time["time_work"]);
            $time_home = new DateTime($this->time["time_home"]);
            $now = new DateTime("now");
            $formatted_time_toWork = $time_work->format("Y-m-d H:i:s");
            $formatted_time_home = $time_home->format("Y-m-d H:i:s");
            if ($now > $time_work) {
                if ($now->diff($time_work)->h > 22) {
                    $next_date_work = date("Y-m-d H:i:s", strtotime("+1 days", strtotime($formatted_time_toWork)));
                    $next_date_home = date("Y-m-d H:i:s", strtotime("+1 days", strtotime($formatted_time_home)));
                    if ($now->diff($time_work)->d > 0) {
                        $diff_beetwen_days_inDays = $now->diff($time_work)->d;
                        $next_date_work = date("Y-m-d H:i:s", strtotime("+" . ($diff_beetwen_days_inDays + 1) . "days", strtotime($formatted_time_toWork)));
                        $next_date_home = date("Y-m-d H:i:s", strtotime("+" . ($diff_beetwen_days_inDays + 1) . " days", strtotime($formatted_time_home)));
                    }
                    $data = [
                        "time_work" => $next_date_work,
                        "time_home" => $next_date_home
                    ];
                    $this->db->where("time_work", $formatted_time_toWork);
                    if ($this->db->update("time_work", $data)) {
                        $this->session->set_flashdata("sukses", "Updated work time and home time automatically");
                        $this->time = $this->Karyawan_model->get_timeWorkAndHome();
                        $this->user_time = $this->Karyawan_model->get_usersTimeWorkAndHome();
                    }
                }
            }
        } else {
            $this->session->unset_userdata("session_user");
        }
    }

    public function index()
    {
        if (!empty($this->session->session_user)) {

            $data = [
                "title" => "Dashboard",
                "user" => $this->user,
                "data_user" => $this->data_user,
                "time" => $this->time,
                "user_time" => $this->user_time
            ];

            $this->load->view("templates/header", $data);
            $this->load->view("templates/sidenav", $data);
            $this->load->view("home", $data);
            $this->load->view("templates/footer");
        } else {
            redirect("login", "refresh");
        }
    }


    public function login()
    {
        if (!empty($this->session->session_user)) {
            return redirect("/", "refresh");
        } else {
            $data = [
                "title" => "Login Page",
            ];
            $this->load->view("templates/header", $data);
            $this->load->view("login");
            $this->load->view("templates/footer");
        }
    }

    public function logout()
    {
        $data = [
            "is_online" => 0
        ];
        $this->db->where("nama", $this->session->session_user["nama"]);
        if ($this->db->update("list_karyawan", $data)) {
            $this->session->unset_userdata("session_user");
            redirect("login", "refresh");
        }
    }

    public function signup()
    {
        $data = [
            "title" => "Signup Page",
        ];

        if (!empty($this->input->post())) {
            $data = [
                "username"      => $this->input->post("username"),
                "nama"          => $this->input->post("name"),
                "born"          => $this->input->post("born"),
                "position"      => $this->input->post("position"),
                "password"      => $this->input->post("password"),
                "file_name"     => null
            ];
            if (!empty($_FILES["file"])) {
                if ($this->upload->do_upload("file")) {
                    $data = [
                        "username"      => $this->input->post("username"),
                        "nama"          => $this->input->post("name"),
                        "born"          => $this->input->post("born"),
                        "position"      => $this->input->post("position"),
                        "password"      => $this->input->post("password"),
                        "file_name"     => $this->upload->data("file_name")
                    ];
                } else {
                    var_dump($this->upload->display_errors());
                }
            }

            $this->_signup($data);
        }


        $this->load->view("templates/header", $data);
        $this->load->view("signup");
        $this->load->view("templates/footer");
    }

    public function edit_profile()
    {
        // $data_user = $this->Karyawan_model->get_list_karyawan();
        if (!empty($this->user)) {
            $data = [
                "title" => "Edit Profile",
                "user" => $this->user,
                "data_user" => $this->data_user
            ];

            $getPostData = $this->input->post();
            if (!empty($getPostData)) {
                $this->_edit_profile($getPostData);
            }

            $this->load->view("templates/header", $data);
            $this->load->view("edit", $data);
            $this->load->view("templates/footer");
        } else {
            return redirect("/login", "refresh");
        }
    }

    public function list_karyawan($num = null)
    {
        $config["base_url"] = "http://localhost/Absensi-Karyawan/list-karyawan";
        $config["total_rows"] = $this->Karyawan_model->count_all_list_karyawan(); // TODO getting all data numbers
        $config["per_page"] = 5; // TODO limiting data when getting from database per page 

        // TODO Styling pagination
        $config["full_tag_open"] = '<ul class="pagination center-align">';
        $config["full_tag_close"] = '</ul>';

        $config["first_link"] = "First";
        $config["first_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["first_tag_close"] = '</a></li>';

        $config["last_link"] = "Last";
        $config["last_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["last_tag_close"] = '</a></li>';

        $config["next_link"] = "&raquo";
        $config["next_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["next_tag_close"] = '</a></li>';

        $config["prev_link"] = "&laquo";
        $config["prev_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["prev_tag_close"] = '</a></li>';

        $config["cur_tag_open"] = '<li class="waves-effect active"><a href="#">';
        $config["cur_tag_close"] = '</a></li>';

        $config["num_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["num_tag_close"] = '</a></li>';


        $this->pagination->initialize($config); // TODO creating pagination for spliting out long content
        if (!empty($this->user)) {
            $config["offset"] = 0; // TODO initialize an offset value for limit in model
            if ($num != null) {
                $config["offset"] = $num; // TODO taking value on uri segment 2
            }
            $data = [
                "title" => "List Karyawan Admin Only",
                "user" => $this->user, // TODO pass the session value to front end
                "all_users" => $this->Karyawan_model->get_all_list_karyawan($config["per_page"], $config["offset"]), //TODO Get List with parameter 1 is start and 2 is end
                "no" => $num //TODO pass the value to front end
            ];

            $this->load->view("templates/header", $data);
            $this->load->view("list_karyawan", $data);
            $this->load->view("templates/footer");
        } else {
            return redirect("/login", "refresh");
        }
    }

    public function absen_karyawan()
    {
        if (!empty($this->user)) {
            $data = [
                "title" => "List Absen Karyawan",
                "user" => $this->user,
                "all_data" => [
                    "list_kehadiran" => $this->Karyawan_model->get_all_kehadiran(),
                    "list_keterlambatan" => $this->Karyawan_model->get_all_keterlambatan(),
                    "list_tidak_masuk" => $this->Karyawan_model->get_all_tidak_masuk()
                ]
            ];

            $this->load->view("templates/header", $data);
            $this->load->view("absensi_karyawan", $data);
            $this->load->view("templates/footer");
        } else {
            return redirect("/login", "refresh");
        }
    }

    public function search($num = null)
    {
        $config["base_url"] = "http://localhost/Absensi-Karyawan/list-karyawan/search";
        $config["total_rows"] = $this->Karyawan_model->count_all_list_karyawan(); // TODO getting all data numbers
        $config["per_page"] = 1; // TODO limiting data when getting from database per page 

        // TODO Styling pagination
        $config["full_tag_open"] = '<ul class="pagination center-align">';
        $config["full_tag_close"] = '</ul>';

        $config["first_link"] = "First";
        $config["first_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["first_tag_close"] = '</a></li>';

        $config["last_link"] = "Last";
        $config["last_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["last_tag_close"] = '</a></li>';

        $config["next_link"] = "&raquo";
        $config["next_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["next_tag_close"] = '</a></li>';

        $config["prev_link"] = "&laquo";
        $config["prev_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["prev_tag_close"] = '</a></li>';

        $config["cur_tag_open"] = '<li class="waves-effect active"><a href="#">';
        $config["cur_tag_close"] = '</a></li>';

        $config["num_tag_open"] = '<li class="waves-effect"><a href="#">';
        $config["num_tag_close"] = '</a></li>';


        $this->pagination->initialize($config); // TODO creating pagination for spliting out long content

        if (!empty($this->user)) {
            $nama = $this->input->post("nama");
            if (empty($nama)) {
                return show_error("Type your name keywords", EXIT_USER_INPUT, "Error when searching");
            }
            $this->db->limit($config["per_page"], $num);
            $this->db->like("nama", $nama);
            $result = $this->db->get("list_karyawan")->result_array();
            $data = [
                "title" => "Search Karyawan Admin Only",
                "list_karyawan" => $result,
                "user" => $this->user
            ];
            $this->load->view("templates/header", $data);
            $this->load->view("search_karyawan", $data);
            $this->load->view("templates/footer");
        } else {
            return redirect("/login", "refresh");
        }
    }

    public function setting_time()
    {
        if ($this->user["admin"] == 1) {
            $data = [
                "title" => "Setting Time",
                "user" => $this->user,
                "data_user" => $this->data_user
            ];

            if (!empty($this->input->post())) {
                $this->_set_time($this->input->post());
            }

            $this->load->view("templates/header", $data);
            $this->load->view("setting_time", $data);
            $this->load->view("templates/footer");
        } else {
            return show_error("Just admin can access it, Please turn back", EXIT_UNKNOWN_FILE, "Cannot Access this site");
        }
    }



    // ! End views 
    // TODO Start Function

    public function get_all_online()
    {
        print_r(json_encode($this->Karyawan_model->get_all_online()));
    }

    public function absen_now()
    {
        $now = new DateTime("now");
        $time_work = new DateTime($this->time["time_work"]);
        $formatted_now = $now->format("Y-m-d H:i:s");

        if (!empty($this->user_time)) {
            // TODO Check if users doing absen in the same day
            if ($this->user_time["home_at"] != null) {
                $data = [
                    "nama" => $this->user["nama"],
                    "username" => $this->user["username"],
                    "work_at" => $formatted_now,
                    "is_late" => 0
                ];
                if ($now > $time_work) {
                    $excuse = $this->input->post("excuse");
                    $data["is_late"] = 1;
                    if ($this->db->insert("kehadiran", $data)) {
                        $data = [
                            "username" => $this->user["username"],
                            "come_at" => $formatted_now,
                            "excuse" => $excuse
                        ];
                        if ($this->db->insert("keterlambatan", $data)) {
                            $this->session->set_flashdata("sukses", "Selamat anda sudah absen");
                            return redirect("/", "refresh");
                        } else {
                            $this->session->set_flashdata("gagal", "Anda gagal absen");
                            return redirect("/", "refresh");
                        }
                    } else {
                        $this->session->set_flashdata("gagal", "Anda gagal absen");
                        return redirect("/", "refresh");
                    }
                }
                if ($this->db->insert("kehadiran", $data)) {
                    $this->session->set_flashdata("sukses", "Selamat anda sudah absen");
                    return redirect("/", "refresh");
                } else {
                    $this->session->set_flashdata("gagal", "Anda gagal absen");
                    return redirect("/", "refresh");
                }
            } else {
                $this->session->set_flashdata("gagal", "Tidak bisa melakukan absen di waktu dan hari yang sama");
                return redirect("/", "refresh");
            }
        }

        $data = [
            "nama" => $this->user["nama"],
            "username" => $this->user["username"],
            "work_at" => $formatted_now,
        ];
        if ($this->db->insert("kehadiran", $data)) {
            $this->session->set_flashdata("sukses", "Selamat anda sudah absen");
            return redirect("/", "refresh");
        } else {
            $this->session->set_flashdata("gagal", "Anda gagal absen");
            return redirect("/", "refresh");
        }
    }

    public function home_now()
    {
        $time_now = new DateTime("now");
        // $time_now->setTimezone(new DateTimeZone("Asia/Jakarta"));
        $formatted_now = $time_now->format("Y-m-d H:i:s");

        $data = [
            "home_at" => $formatted_now,
            "updated_at" => $formatted_now
        ];

        $this->db->where("id", $this->user_time["id"]);
        if ($this->db->update("kehadiran", $data)) {
            $this->session->set_flashdata("sukses", "Selamat anda sudah diperbolehkan Pulang <b>Jangan Lupa Logout account anda</b>");
            return redirect("/", "refresh");
        } else {
            $this->session->set_flashdata("gagal", "Gagal dalam mengabsen pulang anda");
            return redirect("/", "refresh");
        }
    }

    private function _set_time($data)
    {
        // todo initialize variables
        $time_toWork = new DateTime();
        $time_toGoHome = new DateTime();
        $updated_at = new DateTime("now");
        $timezone = new DateTimeZone("Asia/Jakarta");
        // TODO Setting timezone
        $time_toWork->setTimezone($timezone);
        $time_toGoHome->setTimezone($timezone);
        $updated_at->setTimezone($timezone);
        // TODO Setting time 
        $time_toWork->setTime($data["hours-work"], 0, 0);
        $time_toGoHome->setTime($data["hours-home"], 0, 0);
        // TODO Formatting the time 
        $formatted_time_toWork = $time_toWork->format("Y-m-d H:i:s");
        $formatted_time_toGoHome = $time_toGoHome->format("Y-m-d H:i:s");
        $formatted_time_updatedAt = $updated_at->format("Y-m-d H:i:s");
        /*
            TODO: format the date to Y means 4 digits year, m means mounth in numbers, d means day in numbers
            TODO: H means 2 digits hour, i means 2 digits minute and s means 2 digits of second 
        */
        if (strtotime($formatted_time_toWork) == strtotime($formatted_time_toGoHome)) {
            echo "The times cannot be the same value as the other";
        } else if ($time_toWork->diff($time_toGoHome)->h < 8) {
            echo "The times must be have difference 8 hours from time to work to time to go home";
        } else {
            // var_dump($formatted_time_updatedAt);
            if ($this->db->count_all_results("time_work") == 0) {
                $data = [
                    "nama" => $this->user["nama"],
                    "username" => $this->user["username"],
                    "time_work" => $formatted_time_toWork,
                    "time_home" => $formatted_time_toGoHome,
                ];
                $this->db->insert("time_work", $data);
            } else {
                $data = [
                    "nama" => $this->user["nama"],
                    "username" => $this->user["username"],
                    "time_work" => $formatted_time_toWork,
                    "time_home" => $formatted_time_toGoHome,
                    "updated_at" => $formatted_time_updatedAt
                ];
                $this->db->where("username", $this->user["username"]);
                $this->db->update("time_work", $data);
            }
        }
        // TODO next: display list of "kehadiran", "terlambat" and "Tidak Masuk"
        // TODO next: Setting up time "terlambat" and "tidak masuk"
    }

    public function join()
    {
        $data = [
            "username" => $this->input->post("username"),
            "password" => $this->input->post("password")
        ];

        // TODO Checking user in database
        $verified = $this->Karyawan_model->verify_account($data);
        if (!empty($verified) && $verified != null) {
            $data = [
                "is_online" => 1
            ];
            $this->db->where("nama", $verified["nama"]);
            if ($this->db->update("list_karyawan", $data)) {
                $this->session->set_userdata("session_user", $verified);
                return redirect("/", "refresh");
            }
        } else {
            $this->session->set_flashdata("gagal", "Salah username atau password");
            return redirect("login", "refresh");
        }
    }

    private function _edit_profile($data)
    {

        $nama           = $data["nama"];
        $username       = $data["username"];
        $password       = empty($data["password"]) ? null : $data["password"];
        $position       = empty($data["position"]) ? null : $data["position"];
        $born_date      = date_format(date_create($data["tanggal-lahir"]), "Y-m-d");
        $admin          = $data["admin"];
        $profile_img    = $_FILES["foto"];


        $data_list_karyawan = [
            "nama"          => $nama,
            "pangkat"       => $position,
            "tanggal-lahir" => $this->data_user["tanggal-lahir"],
            "profile_img"   => $this->data_user["profile_img"]
        ];

        $data_user_account = [
            "nama"      => $nama,
            "username"  => $username,
            "password"  => $this->user["password"],
            "admin"     => $admin
        ];

        if ($password != null) {
            $data_user_account["password"] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!empty($born_date)) {
            $data_list_karyawan["tanggal-lahir"] = $born_date;
        }

        if ($position != null) {
            $data_list_karyawan["pangkat"] = $position;
        }

        if ($profile_img["name"] != "") {
            $data_list_karyawan["profile_img"] = $this->upload_image("foto");
            if ($this->data_user["profile_img"] != null) {
                if (unlink("./assets/profile-image/" . $this->data_user["profile_img"])) {
                    $this->session->set_flashdata("sukses", "Foto Berhasil Dihapus");
                } else {

                    $this->session->set_flashdata("gagal", "Foto Gagal Dihapus");
                }
            }
        } else {
            $profile_img = null;
        }

        $this->db->where("username", $username);
        if ($this->Karyawan_model->update("user_account", $data_user_account)) {
            $this->db->where("nama", $nama);
            if ($this->Karyawan_model->update("list_karyawan", $data_list_karyawan)) {
                $this->session->set_flashdata("sukses", "Data Berhasil Diperbarui");
                return redirect("/", "refresh");
            } else {
                $this->session->set_flashdata("gagal", "List karyawan Gagal Diperbarui");
                return redirect("/edit-profile", "refresh");
            }
        } else {
            $this->session->set_flashdata("gagal", "User account Gagal Diperbarui");
            return redirect("/edit-profile", "refresh");
        }
    }

    private function _signup($data)
    {
        // TODO Insert to table user_account
        $this->Karyawan_model->insert($data);
    }


    private function upload_image($nameField)
    {
        if ($this->upload->do_upload($nameField)) {
            return $this->upload->data("file_name");
        } else {
            return $this->upload->display_errors();
        }
    }
}
