<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_hak_akses extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tbl_hak_akses_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('tbl_hak_akses/tbl_hak_akses_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_hak_akses_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_hak_akses_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'id_user_level' => $row->id_user_level,
		'id_menu' => $row->id_menu,
	    );
            $this->load->view('tbl_hak_akses/tbl_hak_akses_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tbl_hak_akses'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tbl_hak_akses/create_action'),
	    'id' => set_value('id'),
	    'id_user_level' => set_value('id_user_level'),
	    'id_menu' => set_value('id_menu'),
	);
        $this->load->view('tbl_hak_akses/tbl_hak_akses_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_user_level' => $this->input->post('id_user_level',TRUE),
		'id_menu' => $this->input->post('id_menu',TRUE),
	    );

            $this->Tbl_hak_akses_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tbl_hak_akses'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_hak_akses_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tbl_hak_akses/update_action'),
		'id' => set_value('id', $row->id),
		'id_user_level' => set_value('id_user_level', $row->id_user_level),
		'id_menu' => set_value('id_menu', $row->id_menu),
	    );
            $this->load->view('tbl_hak_akses/tbl_hak_akses_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tbl_hak_akses'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'id_user_level' => $this->input->post('id_user_level',TRUE),
		'id_menu' => $this->input->post('id_menu',TRUE),
	    );

            $this->Tbl_hak_akses_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tbl_hak_akses'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_hak_akses_model->get_by_id($id);

        if ($row) {
            $this->Tbl_hak_akses_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tbl_hak_akses'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tbl_hak_akses'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_user_level', 'id user level', 'trim|required');
	$this->form_validation->set_rules('id_menu', 'id menu', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_hak_akses.xls";
        $judul = "tbl_hak_akses";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Id User Level");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Menu");

	foreach ($this->Tbl_hak_akses_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_user_level);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_menu);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_hak_akses.doc");

        $data = array(
            'tbl_hak_akses_data' => $this->Tbl_hak_akses_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('tbl_hak_akses/tbl_hak_akses_doc',$data);
    }

}

/* End of file Tbl_hak_akses.php */
/* Location: ./application/controllers/Tbl_hak_akses.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-05-09 05:11:36 */
/* http://harviacode.com */