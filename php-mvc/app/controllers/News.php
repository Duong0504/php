<?php
class News extends Controller {
    private $data = [];
    public function index() {   
        $this->data['sub_content']['new_title'] = 'Tin túc 1';
        $this->data['sub_content']['new_content'] = 'Nội dung 1';
        $this->data['sub_content']['page_title'] = 'Tiêu đề tin tức';
        $this->data['sub_content']['new_author'] = 'Nhật Nguyên';
        $this->data['content'] = 'news/list';
        $this->render("layout/client_layout", $this->data);
    }
}