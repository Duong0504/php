<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
//    echo '<pre>';
//    print_r($_FILES);
//    echo '</pre>';

    //Mảng lưu trữ các định dạng file cho phép
    $allowedArr = ['mp4', 'jpg','jpeg','png', 'gif', 'mov'];

    $maxFileSize = 742940;

//    $uploadDir = './upload/';
//    if (!is_dir($uploadDir)) {
//        mkdir($uploadDir, 0755, true);
//    }

        foreach($_FILES['file_upload']['name'] as $key=>$fileName){
            $fileOr = $fileName;

//            if (strpos($fileName, '.') === false) {
//                echo 'File '.$fileOr.' không có phần mở rộng <br/>';
//                continue;
//            }

//            echo $fileName.'-'.$_FILES['file_upload']['tmp_name'][$key].'<br>';
            //rename file
            $fileNameArr = explode('.', trim($fileName));

            $fileExt = end($fileNameArr);
            $fileBefore = sha1(uniqid());
            $fileName = $fileBefore.'.'.$fileExt;

            if(in_array($fileExt, $allowedArr)){
                if ($_FILES['file_upload']['size'][$key] <= $maxFileSize){
                    $upload = move_uploaded_file($_FILES['file_upload']['tmp_name'][$key], './upload/'.$fileName);

                    if($upload){
                        echo 'Upload file'.$fileOr.'success. 
                        <br>
                        <a href="./upload/'.$fileName.'" target="_blank">
                        <img src="./upload/'.$fileName.'" alt="'.$fileName.'" style="max-width:200px;max-height:200px;">
                        </a>';
                    } else {
                        echo  'Upload file'.$fileOr.'failed <br/>';
                    }
                } else {
                    echo 'File'.$fileOr.' vượt quá dung lượng cho phép <br/>';
                }
            }else {
                echo 'File'.$fileOr.' không đúng định dạng cho phép <br/>';
            }
        }
}
