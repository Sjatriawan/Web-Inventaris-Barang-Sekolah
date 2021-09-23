<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Laporan Transaksi";
            $this->template->load('templates/dashboard', 'laporan/form', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barang_masuk') {
                $query = $this->admin->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->admin->getBarangKeluar(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            }

            

            $this->_cetak($query, $table, $tanggal);
        }
    }

    function buatRupiah($angka){
                    $hasil = "Rp. " . number_format($angka,2,',','.');
                        return $hasil;
    }

    function vcell($c_width,$c_height,$x_axis,$text){
        $w_w=$c_height/3;
        $w_w_1=$w_w+2;
        $w_w1=$w_w+$w_w+$w_w+3;
        $len=strlen($text);// check the length of the cell and splits the text into 7 character each and saves in a array 

        $lengthToSplit = 7;
        if($len>$lengthToSplit){
        $w_text=str_split($text,$lengthToSplit);
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w_1,$w_text[0],'','','');
        if(isset($w_text[1])) {
            $this->SetX($x_axis);
            $this->Cell($c_width,$w_w1,$w_text[1],'','','');
        }
        $this->SetX($x_axis);
        $this->Cell($c_width,$c_height,'','LTRB',0,'L',0);
        }
        else{
            $this->SetX($x_axis);
            $this->Cell($c_width,$c_height,$text,'LTRB',0,'L',0);
        }
    }


    private function _cetak($data, $table_, $tanggal)
    {
        $this->load->library('CustomPDF');
        $table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

        $pdf = new FPDF();
        $pdf->AddPage('L','Legal');
        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(320, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(320, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        if ($table_ == 'barang_masuk') :
            
            $pdf->Cell(7, 7, 'No.','LTR', 'C');
            $pdf->Cell(20, 7, 'Tgl Masuk','LTR', '','C');
            // $pdf->Cell(30, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(45, 7, 'Nama Barang','LTR', '','C');
            $pdf->Cell(25, 7, 'Jumlah Masuk','LTR','','C');
            $pdf->Cell(25, 7, 'Harga (Rp)','LTR','','C');
            $pdf->Cell(37, 7, 'Tim Pengadaan','LTR','','C');
            $pdf->Cell(40, 7, 'Tim Pemeriksa','LTR','','C');
            $pdf->Cell(42, 7, 'Berita Acara','LTR','','C');
            $pdf->Cell(43, 7, 'Berita Acara','LTR','','C');
            $pdf->Cell(55, 7, 'Sumber Dana',1, 0, 'C');
            $pdf->Ln();
            $pdf->Cell(7, 7, '','LR', 'C');
            $pdf->Cell(20, 7, '','LR', 'C');
            $pdf->Cell(45, 7, '','LR', 'C');
            $pdf->Cell(25, 7, '','LR', 'C');
            $pdf->Cell(25, 7, '','LR', 'C');
            $pdf->Cell(37, 7, '','LR', 'C');
            $pdf->Cell(40, 7, '','LR', 'C');
            $pdf->Cell(42, 7, 'Pemeriksaan Barang','LR','','C');
            $pdf->Cell(43, 7, 'Serah Terima', 'LR','', 'C');
            $pdf->Cell(20, 7, 'BOS',1, 0, 'C');
            $pdf->Cell(15, 7, 'BPP',1, 0, 'C');
            $pdf->Cell(20, 7, 'Lainnya',1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
            $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(7, 7, $no++ . '.',1,0,'C');
                $pdf->Cell(20, 7, $d['tanggal_masuk'], 1,0,'C');
                $pdf->Cell(45, 7, $d['nama_barang'], 1,0,'C');
                $pdf->Cell(25, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1,0,'C');
                $pdf->Cell(25, 7, $d['total_harga'], 1, 0, 'C');
                $pdf->Cell(37, 7, $d['nama_supplier'], 1,0, 'C');
                $pdf->Cell(40, 7, $d['nama_pemeriksa'], 1,0, 'C');
                $pdf->Cell(42, 7, $d['ba_pemeriksaan'], 1,0,'C');
                $pdf->Cell(43,7,  $d['serah_terima'], 1,0 ,'C');
                $pdf->SetFont('ZapfDingbats','', 10);
                $pdf->Cell(20, 7, utf8_decode($d['boss']),1, 0, 'C');
                $pdf->Cell(15, 7, utf8_decode($d['bpp']),1, 0, 'C');
                $pdf->Cell(20, 7, utf8_decode($d['lainnya']),1, 0, 'C');
                $pdf->Ln();

            } else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Tgl Keluar', 1, 0, 'C');
            $pdf->Cell(40, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(50, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Jumlah Keluar', 1, 0, 'C');
            $pdf->Cell(40, 7, 'Sisa Stok Barang', 1, 0, 'C');
            $pdf->Cell(60, 7, 'Pemakai', 1, 0, 'C');
            $pdf->Cell(60, 7, 'Keterangan Penggunaan', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(30, 7, $d['tanggal_keluar'], 1, 0, 'C');
                $pdf->Cell(40, 7, $d['id_barang_keluar'], 1, 0, 'C');
                $pdf->Cell(50, 7, $d['nama_barang'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['jumlah_keluar'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Cell(40, 7, $d['stok'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Cell(60, 7, $d['pemakai'], 1, 0, 'C');
                $pdf->Cell(60, 7, $d['ket'], 1, 0, 'C');
                $pdf->Ln();
            }
        endif;



        $myarray = array(0);  
            foreach($myarray as $value){
                $pdf->AddPage('L','Legal');
                    $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(320, 5, '', 0, 1, 'C');

        //PENGADAAN BARANG
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(320, 7, 'Tim Pengadaan Barang & Jasa', 0, 1, 'C');


        //Spasi
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(260, 20, '', 0, 1, 'C');

        //TTD 1
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(135, 7, 'Lalu Badri, S. pd.', 0, 0, 'L');
        $pdf->Cell(120, 7, 'Drs. Hafizin', 0, 0, 'L');
        $pdf->Cell(35, 7, 'Mutjahidin, S.pd.', 0, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(135, 5, 'NIP. 197312011998021001 ', 0, 0, 'L');
        $pdf->Cell(120, 5, 'NIP. 196812311994121064', 0, 0, 'L');
        $pdf->Cell(35, 5, 'NIP. 197410242009011004', 0, 0, 'L');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(320, 5, '', 0, 1, 'C');

        //PENGADAAN BARANG
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(320, 20, '', 0, 1, 'C');


        //PENGADAAN BARANG
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(320, 7, 'Tim Pemeriksaan Barang', 0, 1, 'C');


        //Spasi
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(260, 20, '', 0, 1, 'C');

        //TTD 1
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(135, 7, 'Suhardi, B. SE, M.M.', 0, 0, 'L');
        $pdf->Cell(120, 7, 'Junaedi, S.pd.', 0, 0, 'L');
        $pdf->Cell(35, 7, 'Pahrudin, A. Md., S.pd', 0, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(135, 5, 'NIP. 197312011998021001 ', 0, 0, 'L');
        $pdf->Cell(120, 5, 'NIP. 196812311994121064', 0, 0, 'L');
        $pdf->Cell(35, 5, 'NIP. 197410242009011004', 0, 0, 'L');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(260, 5, '', 0, 1, 'C');

        //PENGADAAN BARANG
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(320, 20, '', 0, 1, 'C');

        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(320, 5, 'Mengetahui:', 0, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(320, 5, 'Kepala SMAN 1 Pringggabaya', 0, 0, 'C');

        //Spasi
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(320, 25, '', 0, 1, 'C');

        //kepsek
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(320, 5, 'Hasanudin, S.pd.', 0, 1, 'C');
        $pdf->Cell(320, 5, 'NIP. 197012311998021031', 0, 1, 'C');
        }

        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }


        

}
