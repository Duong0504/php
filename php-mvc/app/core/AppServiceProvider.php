<?php
class AppServiceProvider extends ServiceProvider {
    public function boot(){
        $dataUser =  $this->db->table('users')->where('id','=', 16)->first(); 
        $data = [];
        $data['user_info'] = $dataUser; 
        View::share($data);
    }
}