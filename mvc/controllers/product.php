<?php
class product extends controller {
    public $product;
    public function __construct()
    {
        $this->product = $this->model('productModel');
    }
    public function default()
    {
        $this->view("client", [
            'title' => 'Sản phẩm',
            'page' => 'product',
            'table' => $this->product->danhSachSP()
        ]);
        
    }

    public function detail($id){ #shop/product/detail
        $this->view("client", [
            'title' => 'Chi tiết sản phẩm',
            'page' => 'productdetail',
            'sanpham' => $this->product->chitietSP($id)
        ]);
    }

    
}