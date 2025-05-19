<?php

//Hàm uploadFiles(1 file, nhiều file)
function uploadFiles($config, $fieldName, $file=[]){

    if(!empty($file)){
        $_FILES[$fieldName] = $file;
    }
    $errors = [];

    if(!empty($_FILES[$fieldName])){
    $fileName = $_FILES[$fieldName]['name'];

    $fileNameArr = explode('.', trim($fileName));

    $fileExt = end($fileNameArr);
    if(!empty($config[$fieldName])){
        $fileName = $config['fileName'];
    }

    //check file đã được chọn chưa
        if($_FILES[$fieldName]['error'] == 4){
            $errors['choose_file'] = 'vui lòng chọn file';
    } else {
//        //lấy tên file
//        $fileName = $_FILES['file_upload']['name'];
//        echo $fileName;
//
//        //rename file
//        $fileNameArr = explode('.', trim($fileName));
//
//        $fileExt = end($fileNameArr);
//
//        $fileBefore = shal(uniqid());
////        $fileBefore = str_replace('.'.$filrExt, '', $fileName);
////        $fileName = $fileBefore.'_'.uniqid();
//        $fileName = $fileBefore.'.'.$fileExt;
//
//        if(!empty($config['allowed']) && !in_array($fileExt, $config['allowed'])){
//            $errors['allow_text'] = 'Định dạng không được phép, chỉ chấp nhận: '.implode(', ', $config['allowed']);

        //check định dạng được cho phép

            if(!empty($config['allowed'])) {
            $allowArr = explode(',', $config['allowed']);
            $allowArr = array_filter($allowArr);
            foreach($allowArr as $key=>$allow) {
                $allowArr[$key] = trim($allow);
            }
            if (    !empty($config['allowed']) && !in_array($fileExt, $allowArr)) {
                $errors[] = 'allow_ext';
            }
        }
        //check size
            if(!empty($_FILES[$fieldName]['size'])){
                $size = $_FILES[$fieldName]['size'];
                if($size > $config['maxSize']){
                    $errors[] = 'maxSize';
                } else {
                    $errors[] =  'file_error';
                }
            }
        //check err để thực hiện upload
        if(empty($errors)){
            $upload = move_uploaded_file
            ($_FILES['file_upload']['tmp_name'], $config['uploads_dir'].'/'.$fileName);
            if($upload){
                return [
                    'status' => 'success',
                    'fileOr' => $_FILES[$fieldName]['name'],
                    'fieldName' => $fieldName,
                    'size' => $_FILES[$fieldName]['size'],
                    'path' => $config['uploads_dir'].'/'.$fileName,
                ];
            } else {
                return false;
            }
        } else {
            return false;
            }
        }
    if(!empty($errors)){
        $errors['status'] = 'error';
    }
        }
    return ['status' => 'error', 'errors' => $errors];
}
//function fileMulti($fileName){
//    $fileArr = [];
//    if(!empty($_FILES[$fileName])){
//        foreach($_FILES[$fileName]['name'] as $key=>$fileName){
//            $fileArr[] = [
//                'name' => $fileName,
//                'tmp_name' => $_FILES[$fileName]['tmp_name'][$key],
//                'error' => $_FILES[$fileName]['error'][$key],
//                'type' => $_FILES[$fileName]['type'][$key],
//                'size' => $_FILES[$fileName]['size'][$key],
//            ];
//        }
//    }
//    return $fileArr;
//}


