<?php 
    echo !empty($msg)?$msg:false;
    HtmlHelper::formOpen('post', _WEB_ROOT.'/home/add_user');
    HtmlHelper::input('<div>', '<br/>'.form_error('fullname').'</div>', 'text', 'fullname', old_form('fullname'), '', '', 'Họ tên....');
    HtmlHelper::input('<div>', '<br/>'.form_error('email').'</div>', 'text', 'email', old_form('fullname'), '', '', 'Email....');
    HtmlHelper::input('<div>', '<br/>'.form_error('password').'</div>', 'password', 'password', old_form('password'), '', '', 'Mật khẩu....');
    HtmlHelper::input('<div>', '<br/>'.form_error('comfirm_password').'</div>', 'password', 'comfirm_password', old_form('comfirm_password'), '', '', 'Nhập lại mật khẩu....');
    HtmlHelper::input('<div>', '<br/>'.form_error('age').'</div>', 'text', 'age', old_form('age'), '', '', 'Nhập lại mật khẩu....');
    HtmlHelper::button('submit', 'Thêm người dùng');
    HtmlHelper::formClose();