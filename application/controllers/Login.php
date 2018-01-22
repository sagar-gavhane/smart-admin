<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Login Controller - Handle Login Functionality
 */
class Login extends CI_Controller
{
    public $global_data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('login_model', 'user_model'));

        // initilize global data
        $this->global_data['page_name']  = 'login';
        $this->global_data['page_title'] = 'Login Page';
        $this->global_data['header']     = $this->load->view('template/header', $this->global_data, true);
        $this->global_data['navbar']     = $this->load->view('template/navbar', null, true);
        $this->global_data['footer']     = $this->load->view('template/footer', null, true);
    }

    /**
     * default page of login
     *
     * @return void
     */
    public function index()
    {
        $this->load->view('login/default_view', array_merge($this->global_data));
    }

    /**
     * login check - form processing
     *
     * @return void
     */
    public function check()
    {
        // input validation
        $this->form_validation->set_rules('email_address', 'email address', 'trim|required|valid_email|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[255]');

        // run validation
        if ($this->form_validation->run() == false) {
            $this->load->view('login/default_view', array_merge($this->global_data));
        } else {
            // clean inputs
            $email_address = strtolower(clean_input($this->input->post('email_address')));
            $password      = clean_input($this->input->post('password'));

            $login_check_result = $this->login_model->login_check($email_address, $password);

            if ($login_check_result === true) {
                // set session variables
                $user_data = $this->user_model->getUserByEmail($email_address);
                // check user data set or not
                if ($user_data) {
                    $session_data = array(
                        'user_id'            => $user_data[0]['user_id'],
                        'user_type'          => $user_data[0]['user_type'],
                        'user_email_address' => $user_data[0]['user_email_address'],
                        'logged_in'          => true,
                    );

                    $this->session->set_userdata($session_data);
                    redirect('video_manager');
                } else {
                    $session_data = array(
                        'feedback'     => 'login_failed',
                        'feedback_msg' => 'Entered email address and password are not matched.',
                    );
                    $this->session->set_userdata($session_data);
                    redirect('login');
                }
            } else {
                $session_data = array(
                    'feedback'     => 'login_failed',
                    'feedback_msg' => 'Entered email address and password are not matched.',
                );
                $this->session->set_userdata($session_data);
                redirect('login');
            }
        }
    }
}
