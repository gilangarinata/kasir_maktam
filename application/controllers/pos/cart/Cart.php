<?php

class Cart extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('text');
        $this->load->model('CartModel','model');
        $this->load->model('PosModel');
        $this->load->library('session');
       // $this->load->library('pdf');
    }

    function index(){
        $outlet = $this->session->userdata('outlet');
        $data['cart'] = $this->model->getCartList($outlet);
        $data['jumlah_produk'] = $this->PosModel->getJumlahProduk($outlet);
        $data['namas'] = $this->session->userdata('nama');
        $data['shifts'] = $this->session->userdata('shift');

        $this->load->view("pos/templates/header_cart",$data);
        $this->load->view("pos/cart",$data);
        $this->load->view("pos/templates/footer");

        // if(isset($_POST['submit'])){
        //     $this->session->set_userdata('nama',$this->input->post("nama"));
        //     $this->session->set_userdata('shift',$this->input->post("shift"));
        //     $this->session->set_userdata('modal',$this->input->post("modal"));
        //     $this->session->set_userdata('pengeluaran',$this->input->post("pengeluaran"));
        //     $this->session->set_userdata('pajak',$this->input->post("pajak"));
            

        //     $this->model->updateStock($this->model->getCartList($outlet));
        //     $this->model->addPembayaran($outlet);
        //     $this->model->addKeterangan($outlet);
        //     $this->model->addRekapHarian($outlet);

        //     redirect('pos/cart/cart/laporan_pdf/'.$outlet);
        // }
    }

    public function addcart(){
            $outlet = $this->session->userdata('outlet');
            $this->session->set_userdata('nama',$this->input->post("nama"));
            $this->session->set_userdata('shift',$this->input->post("shift"));
            $this->session->set_userdata('modal',$this->input->post("modal"));
            $this->session->set_userdata('pengeluaran',$this->input->post("pengeluaran"));
            $this->session->set_userdata('pajak',$this->input->post("pajak"));
            

            $this->model->updateStock($this->model->getCartList($outlet));
            $this->model->addPembayaran($outlet);
            $this->model->addKeterangan($outlet);
            $this->model->addRekapHarian($outlet);

            redirect('pos/cart/cart/laporan_pdf/'.$outlet);
    }


    function delete($id){
        $this->model->delete($id);
        redirect('pos/cart/cart');
    }

    public function laporan_pdf($outlet){
        $data['data'] = $this->model->pdfGetProduk($outlet);   
        $data['details'] = $this->model->pdfGetDetails($outlet);   
        $data['alamat'] = $this->model->pdfGetAlamat($outlet);   

    
        $this->load->library('pdf');
    
        $this->pdf->setPaper('A5', 'potrait');
        $this->pdf->filename = "laporan.pdf";
        $this->pdf->load_view('laporan_pdf', $data);   
        
    }






}