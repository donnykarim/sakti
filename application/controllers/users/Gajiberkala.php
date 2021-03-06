<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gajiberkala extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');			
		}
		elseif (!$this->ion_auth->in_group('usersopd')) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an Users OPD to view this page.');
		}
		//$this->load->library('grocery_CRUD');	
	}

	public function index()
	{
		return show_error('You must be not on this page.');
	}

	public function penjagaan()
    {
			$user = $this->ion_auth->user()->row();
        	$data['fname'] = $user->first_name;
        	$data['lname'] = $user->last_name;
        	$data['company'] = $user->company;
        	$data['user_kd_unor'] = $user->kd_unor.'%';

        	if (!$this->uri->segment(4,0)){
				$th = date("Y");
			} else {
				$th = $this->uri->segment(4,0);
			}
			//echo $this->session->userdata('kd_skpd');
			$this->load->model('users/Gajiberkala_model', '', TRUE);
			$get_penjagaan = $this->Gajiberkala_model->get_penjagaan_kgb($th,$data['user_kd_unor']);
			$data['get_penj'] = $get_penjagaan->result();

			$this->load->view('header_table',$data);
			$this->load->view('users/sidebar');
			$this->load->view('users/gajiberkala_penjagaan_content',$data);
			$this->load->view('footer_table');
			$this->load->view('users/gajiberkala_penjagaan_footer_script');

    }
    public function usulan()
    {
			//tampilkan halaman dashboard
			$user = $this->ion_auth->user()->row();
        	$data['fname'] = $user->first_name;
        	$data['lname'] = $user->last_name;
        	$data['company'] = $user->company;
        	$data['user_kd_unor'] = $user->kd_unor;

			$this->load->view('header',$data);
			$this->load->view('users/sidebar');
			$this->load->view('users/construction_content');
			$this->load->view('footer');            
    }
  	public function laporan()
    {
			//tampilkan halaman dashboard
			$user = $this->ion_auth->user()->row();
        	$data['fname'] = $user->first_name;
        	$data['lname'] = $user->last_name;
        	$data['company'] = $user->company;
        	$data['user_kd_unor'] = $user->kd_unor;

			$this->load->view('header',$data);
			$this->load->view('users/sidebar');
			$this->load->view('users/construction_content');
			$this->load->view('footer');            
    }

}
