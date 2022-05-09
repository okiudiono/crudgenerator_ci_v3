<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Tbl_setting_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('tbl_setting/tbl_setting_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tbl_setting_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tbl_setting_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_setting' => $row->id_setting,
		'nama_setting' => $row->nama_setting,
		'value' => $row->value,
	    );
            $this->load->view('tbl_setting/tbl_setting_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tbl_setting'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tbl_setting/create_action'),
	    'id_setting' => set_value('id_setting'),
	    'nama_setting' => set_value('nama_setting'),
	    'value' => set_value('value'),
	);
        $this->load->view('tbl_setting/tbl_setting_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_setting' => $this->input->post('nama_setting',TRUE),
		'value' => $this->input->post('value',TRUE),
	    );

            $this->Tbl_setting_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('tbl_setting'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Tbl_setting_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tbl_setting/update_action'),
		'id_setting' => set_value('id_setting', $row->id_setting),
		'nama_setting' => set_value('nama_setting', $row->nama_setting),
		'value' => set_value('value', $row->value),
	    );
            $this->load->view('tbl_setting/tbl_setting_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tbl_setting'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_setting', TRUE));
        } else {
            $data = array(
		'nama_setting' => $this->input->post('nama_setting',TRUE),
		'value' => $this->input->post('value',TRUE),
	    );

            $this->Tbl_setting_model->update($this->input->post('id_setting', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tbl_setting'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tbl_setting_model->get_by_id($id);

        if ($row) {
            $this->Tbl_setting_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tbl_setting'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tbl_setting'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_setting', 'nama setting', 'trim|required');
	$this->form_validation->set_rules('value', 'value', 'trim|required');

	$this->form_validation->set_rules('id_setting', 'id_setting', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tbl_setting.xls";
        $judul = "tbl_setting";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Setting");
	xlsWriteLabel($tablehead, $kolomhead++, "Value");

	foreach ($this->Tbl_setting_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_setting);
	    xlsWriteLabel($tablebody, $kolombody++, $data->value);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=tbl_setting.doc");

        $data = array(
            'tbl_setting_data' => $this->Tbl_setting_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('tbl_setting/tbl_setting_doc',$data);
    }

}

/* End of file Tbl_setting.php */
/* Location: ./application/controllers/Tbl_setting.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-05-09 05:11:37 */
/* http://harviacode.com */