<?php
class Home extends Controller {
    public $province, $request, $data=[], $__response;
    public function __construct()
    {
        $this->province = $this->model('HomeModel');
        $this->request = new Request();
    }
    public function index()
    {
        // echo "Trang chủ";
        // $data = $this->province->getList();
        // $data = $this->province->first();
        
        // $data = $this->province->getListProduct();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";

        $dataArr = [
            'email'=>'vananh@gmail.com',
            'fullname'=>'Van Anh',
            'phone'=>'0842013742',
            'password'=>password_hash('123456', PASSWORD_DEFAULT),
            'create_at'=>date("Y-m-d h:i:s"),
        ];

        // Session::data('users',[
        //     'email'=>'thanhnhat@gmail.com',
        //     'username'=>'thanhnhat'
        // ]);
        // Session::delete();
        // echo "<pre>";
        // print_r(Session::data('users'));
        // echo "</pre>";
        // Session::flash('msg','hihi');
        $msg = Session::flash('msg');
        echo $msg;
        
        // var_dump($this->db);
        // $data = $this->province->insertUsers($dataArr);
        // $data = $this->province->updateUsers($dataArr, 6);
        // $data = $this->province->deleteUsers(6);

        // echo ($data);
        // $detail = $this->province->getDetailProduct('1');
        // echo "<pre>";
        // print_r($detail);
        // echo "</pre>";

        // $detail = $this->province->getDetail(1);
        // echo "<pre>";
        // print_r($detail);
        // echo "</pre>";

        // $data = $this->province->find(2);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        
    }
    public function user(){
        // $this->data['error'] = Session::flash('error');
        $this->data['msg'] = Session::flash('msg');
        // $this->data['old'] = Session::flash('old');
        // echo "<pre>";
        // print_r(Session::data());
        // echo "</pre>";
        // $data = HtmlHelper::formOpen();

        $this->render('users/add', $this->data);
    }
    public function add_user(){
        $userID = 5;
        /** set rules */
        if($this->request->isPost()){
            $this->request->rules([
                'fullname'=>'required|min:5|max:30',
                'email'=>'required|email|min:8|unique:users:email:id='.$userID,
                'password'=>'required|min:8',
                'comfirm_password'=>'required|match:password',
                'age'=>'required|callback_check_age',
            ]);
            /**set message */
            $this->request->message([
                'fullname.required'=>'Bạn chưa nhập họ tên',
                'fullname.min'=>'Họ tên phải trên 5 kí tự',
                'fullname.max'=>'Họ tên dưới 30 kí tự',
                'email.required'=>'Bạn chưa nhập email',
                'email.email'=>'Email chưa đúng định dạng',
                'email.unique'=>'Tài khoản tồn tại',
                'email.min'=>'Email phải tối đa trên 8 kí tự',
                'password.required'=>'Bạn chưa nhập mật khẩu',
                'password.min'=>'Mật khẩu phải trên 8 kí tự',
                'comfirm_password.required'=>'Bạn chưa nhập lại mật khẩu',
                'comfirm_password.match'=>'Mật khẩu không khớp',
                'age.required'=>'Tuổi không được để trống',
                'age.callback_check_age'=>'Tuổi phải lớn hơn 20',
            ]);
    
            $validate =  $this->request->validate();
            if(!$validate){
                // Session::flash('error', $this->request->error());         
                // Session::flash('msg', 'Vui lòng kiểm tra lại');
                // $this->data['error'] = $this->request->error();
                // $this->data['msg']= 'Vui lòng kiểm tra lại';
                // Session::flash('old', $this->request->getFields());
                // $this->data['old'] = $this->request->getFields();
            }else{
                // Session::flash('old');
                Session::flash('msg', 'Thêm data thành công');
            }
            // $this->render('users/add', $this->data);
        }
        $this->__response = new Response;
        $this->__response->redirect('home/user');
    }
    public function check_age($age){
        if($age >= 20){
            return true;
        }
        return false;
    }
}