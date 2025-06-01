<?php
class AuthMiddleware extends Middleware {
    public function handle()
    {
        
        // $data = $this->db->table('users')->get();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        $HomeModel = Load::model('HomeModel');
        $data = $HomeModel->all();
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if(Session::data('user_login')==null){
            // cos the truy van database
            $response = new Response();
            // $response->redirect('trang-chu');
        }
    }
}