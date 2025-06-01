<?php
/**
 * Kế thừa từ class Module
 */
class HomeModel extends Model{
    protected $_table = 'users';
    public function __construct()
    {
        parent::__construct();
    }
    public function tableFill()
    {
        return "users";
    }
    public function fieldFill()
    {
        return '*';   
    }
    public function primaryKey() {
        return 'id';
    }
    public function getList(){
        $data = $this->db->getRow("SELECT * FROM {$this->_table}");
        return $data;
    }
    public function getDetail($key) {
        $data = ['Item1','Item2'];
        return $data[$key];
    }
    public function getListProduct() {
        $data =  $this->db->table('users')->where("id", "=", "2")->where('fullname','=','Minh Hiếu')->select("*")->orderBy('id ASC, fullname DESC')->limit(1)->get();
        return $data;
    }
    public function getDetailProduct($id) {
        $detail = $this->db->table('users')->where('id','=', $id)->first();
        return $detail;
    }
    public function insertUsers($data){
        // $data = $this->db->table('users')->insert($data);
        $this->db->table('users')->insert($data);
        return $this->db->lastId();
    }
    public function updateUsers($data, $id) {
        $dataUpdate = $this->db->table('users')->where('id', '=', $id)->update($data);
        return $dataUpdate;
    }

    public function deleteUsers($id){
        $dataDelete = $this->db->table('users')->where('id', '=', $id)->delete();
        return $dataDelete;
    }
}