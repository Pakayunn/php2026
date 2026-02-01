<?php
class HomeController extends Controller
{
public function index()
{
    $productModel = $this->model('Product');
    $data = $productModel->all(); 
    

    $this->view("home/index", [
        'products' => $data   
    ]);
}
}