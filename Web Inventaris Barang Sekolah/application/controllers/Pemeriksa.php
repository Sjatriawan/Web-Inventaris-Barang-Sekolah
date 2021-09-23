<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemeriksa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Pemeriksa";
        $data['pemeriksa'] = $this->admin->get('pemeriksa');
        $this->template->load('templates/dashboard', 'pemeriksa/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_pemeriksa', 'Nama Pemeriksa', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Pemeriksa";
            $this->template->load('templates/dashboard', 'pemeriksa/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $save = $this->admin->insert('pemeriksa', $input);
            if ($save) {
                set_pesan('data berhasil disimpan.');
                redirect('pemeriksa');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('pemeriksa/add');
            }
        }
    }


    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Pemeriksa";
            $data['pemeriksa'] = $this->admin->get('pemeriksa', ['id_pemeriksa' => $id]);
            $this->template->load('templates/dashboard', 'pemeriksa/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('pemeriksa', 'id_pemeriksa', $id, $input);

            if ($update) {
                set_pesan('data berhasil diedit.');
                redirect('pemeriksa');
            } else {
                set_pesan('data gagal diedit.');
                redirect('pemeriksa/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('pemeriksa', 'id_pemeriksa', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('pemeriksa');
    }
}
