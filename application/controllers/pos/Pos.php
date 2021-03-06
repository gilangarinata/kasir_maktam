<?php

class Pos extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('text');
        $this->load->model('PosModel','model');
        $this->load->library('session');
    }

    function index(){

        $outlet = $this->session->userdata('outlet');

        $data['susu'] = $this->model->getSusuList();
        $data['stock'] = $this->model->getStock();
        $data['produklain'] = $this->model->getProdukLainList();
        $data['kategoriproduklain'] = $this->model->getKategoriProdukLainList();
        $data['jumlah_produk'] = $this->model->getJumlahProduk($outlet);

        $this->load->view("pos/templates/header",$data);
        $this->load->view("pos/dashboard",$data);
        $this->load->view("pos/templates/footer");
    }

    function penjualan(){

        $outlet = $this->session->userdata('outlet');

        $data['produk'] = $this->model->getPenjualanList($outlet);

        $data['susu'] = $this->model->getSusuList();
        $data['produklain'] = $this->model->getProdukLainList();
        $data['kategoriproduklain'] = $this->model->getKategoriProdukLainList();
        $data['jumlah_produk'] = $this->model->getJumlahProduk($outlet);

        $this->load->view("pos/templates/header",$data);
        $this->load->view("pos/penjualan",$data);
        $this->load->view("pos/templates/footer");
    }

    function hapusPenjualan($tanggal,$shift){
        $outlet = $this->session->userdata('outlet');
        $this->model->hapusPenjualan($outlet,$tanggal,$shift);
        $this->model->hapusPembayaran($outlet,$tanggal,$shift);
        redirect('pos/pos/penjualan');
    }

    function detailPenjualan($tanggal,$shift){
        $outlet = $this->session->userdata('outlet');

        $data['modal'] = $this->model->getModalList($outlet,$tanggal,$shift);
        $data['cart'] = $this->model->getCartList();
        $data['produk'] = $this->model->getDetailPenjualan($tanggal,$shift,$outlet);

        $data['susu'] = $this->model->getSusuList();
        $data['produklain'] = $this->model->getProdukLainList();
        $data['kategoriproduklain'] = $this->model->getKategoriProdukLainList();
        $data['jumlah_produk'] = $this->model->getJumlahProduk($outlet);

        if (isset($_POST['submit'])) {
            $this->model->setModalPengeluaran($outlet,$tanggal,$shift);
            redirect('pos/pos/detailpenjualan/'.$tanggal.'/'.$shift);
        }

        $this->load->view("pos/templates/header",$data);
        $this->load->view("pos/detailpenjualan",$data);
        $this->load->view("pos/templates/footer");
    }

    function saldo(){

        $outlet = $this->session->userdata('outlet');       

        $data['produk'] = $this->model->getPenjualanList($outlet);
        $data['saldo'] = $this->model->getModalList($outlet);
        $data['cart'] = $this->model->getCartList();


        $data['susu'] = $this->model->getSusuList();
        $data['produklain'] = $this->model->getProdukLainList();
        $data['kategoriproduklain'] = $this->model->getKategoriProdukLainList();
        $data['jumlah_produk'] = $this->model->getJumlahProduk($outlet);

        if (isset($_POST['submit'])) {
            $data['produk'] = $this->model->getPenjualanListFilter($outlet);
            $data['cart'] = $this->model->getCartList();
        }

        $this->load->view("pos/templates/header",$data);
        $this->load->view("pos/saldo",$data);
        $this->load->view("pos/templates/footer");
    }

    function addproduksusu($id,$nama,$harga,$kategori,$es,$i){
        $nama = $nama." ".$es." <br>(".$kategori.")";
        $outlet = $this->session->userdata('outlet');
        $this->model->addproduksusu($id,$nama,$harga,$outlet);
        redirect("pos/pos?c=".$i);
    }

    function addproduklain($id,$nama,$harga,$kategori,$i){
        $nama = $nama." <br>(".$kategori.")";
        $outlet = $this->session->userdata('outlet');
        $this->model->addProdukLain($id,$nama,$harga,$outlet);
        redirect('pos/pos?c='.$i);
    }




}