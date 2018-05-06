<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//define("CHAT_SERVICE", "chat_service");
//
//if (!isset($service_name)) {
//    $service_name = "chat_service";
//}
//$mode = isset_request("mode");
//
//switch ($mode) {
//    case 'UpLoad':
        //duong dan tam cho file
        $file_path = $_FILES['uploadfile']['tmp_name'];
        //ten file
        $file_name = $_FILES['uploadfile']['name'];
        //kieu file
        $file_type = $_FILES['uploadfile']['type'];
        //kich thuoc file
        $file_size = $_FILES['uploadfile']['size'];
        //thong bao loi trong qua trinh upload
        $file_error = $_FILES['uploadfile']['error'];
        //new duong dan moi
        $file_new = "admin/upload/".$file_name;
        
        move_uploaded_file($file_path, $file_new);
        
        print_r($file_path);
//        break;
//}

