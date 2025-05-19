<?php
require_once 'functions.php';

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    $config = [
//        'upload_dir' => './uploads/',
//        //'maxSize' => 41205,
//        'allowed' => 'mp4', 'jpg','jpeg','png', 'gif', 'mov',
//        'filename' => 'duong.jpeg',
//    ];
//    $data = uploadFiles($config, 'file_upload');
////    fileMulti('file_upload');
////    $data = [];
////    if(!empty($files)){
////        foreach($files as $file){
////            $config = [
////                    'upload_dir' => './uploads/',
////                'allowed' => 'mp4', 'jpg','jpeg','png', 'gif', 'mov',
////        //'filename' => 'duong.jpeg'
////            ];
////            $data = uploadFiles($config,'file_upload' ,$file);
////            $data[] = $data;
////        }
////    }
//    echo '<pre>';
//    echo $data;
//    echo '</pre>';
//}
//?>
<form method="post" action="upload_multi.php" enctype="multipart/form-data">
    <input type="file" name="file_upload[]" multiple/>
    <button type="submit">Upload</button>
</form>
