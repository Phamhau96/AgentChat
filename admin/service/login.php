<?php

//
//define("LOGIN_SERVICE", "login_service");
//
//if (!isset($service_name)) {
//    $service_name = "login_service";
//}
//if (!defined("DB_UTILS")) {
//    require './DBUtils.php';
//}
//
//if (!defined("PHP_UTILS")) {
//    require './PHPUtils.php';
//}
//
//if (!defined("MENU_SERVICE")) {
//    require './menu.php';
//}
//
//session_start();
//$mode = isset_request("mode");
//switch ($mode) {
//    case 'login':
//        $username = isset_request("username");
//        $pwd = isset_request("password");
//        $user = login($username, $pwd);
//        if (!$user) {
//            $response['status'] = false;
//            $respoonse['message'] = 'Sai tài khoản hoặc mật khẩu';
//            break;
//        }
//        if ($user['is_active'] == 0) {
//            $response['status'] = false;
//            $response['message'] = 'Tài khoản đang bị khóa. Vui lòng liên hệ quản trị viên để được mở khóa';
//            break;
//        }
//
//        $response['status'] = true;
//        $user_id = $user['id'];
//        $menu = getmenu_by_userid($user_id);
//
//        if (!$menu) {
//            $response['status'] = false;
//            break;
//        }
//        $can_access_url = get_menu_url_string($menu);
//        $menu = order_menu($menu);
//
//
//        $_SESSION['menu'] = $menu;
//        $_SESSION['staff_id'] = $user_id;
//        $_SESSION['staff_name'] = $user['name'];
//        $_SESSION['staff_profile_image'] = $user['profile_picture'];
//        $_SESSION['staff_slogan'] = $user['profile_short_description'];
//        $_SESSION['staff_username'] = $user['username'];
//        $_SESSION['is_logined'] = true;
//        $_SESSION['can_access_url'] = $can_access_url;
//        $cookie_name = "id";
//        setcookie($cookie_name, $user_id, time() + (86400 * 30), "/");
//        break;
//    case 're_get_menu':
//        $user_id = $_SESSION['staff_id'];
//        $menu = getmenu_by_userid($user_id);
//
//        if (!$menu) {
//            $response['status'] = false;
//            break;
//        }
//        $can_access_url = get_menu_url_string($menu);
//        $menu = order_menu($menu);
//
//
//        $_SESSION['menu'] = $menu;
//        $_SESSION['can_access_url'] = $can_access_url;
//        $response['status'] = true;
//        break;
//    case 'logout':
//        $response['status'] = true;
//        session_destroy();
//        break;
//    default:
//        if ($service_name == "login_service") {
//            $response['status'] = false;
//            $response['message'] = "Can't find case";
//        }
//}
//if ($service_name == "login_service") {
//    echo json_encode($response);
//}
//
//// Kiểm tra xem có phải file chính (file được gọi service)
//function login($username, $pwd) {
//    try {
//        $conn = getConnection();
//        $query = "SELECT *
//                from user
//                where
//                    username = :username
//                    and password = :pwd and is_deleted = false";
//        $stmt = $conn->prepare($query);
//        $stmt->execute(
//                [
//                    ":username" => $username,
//                    ":pwd" => $pwd
//                ]
//        );
//
//        $data = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        closeConnection($conn);
//        return $data;
//    } catch (Exception $exc) {
//        echo $exc->getTraceAsString();
//        return false;
//    }
//}
//
//function getmenu_by_userid($user_id) {
//    try {
//        $conn = getConnection();
////        $query = "SELECT  
////            menu.id as menu_id,
////            menu.parent_id as parent_id,
////            menu.name as menu_name,
////            menu.fa_icon,
////            menu.url
////            FROM menu
////                join permission_menu permenu on menu.id = permenu.menu_id or menu.parent_id = permenu.menu_id
////                join permission permis on permis.id = permenu.permission_id
////                join permission_user perusr on perusr.permission_id = permis.id
////
////                WHERE perusr.user_id = :user_id and menu.is_deleted = false
////                ORDER by menu.parent_id, menu.id";
//        $query = "SELECT  
//            menu.id as menu_id,
//            menu.parent_id as parent_id,
//            menu.name as menu_name,
//            menu.fa_icon,
//            menu.url
//            FROM menu
//                ORDER by menu.parent_id, menu.id";
//        $stmt = $conn->prepare($query);
//        $stmt->execute(
//                [
//                    ":user_id" => $user_id
//                ]
//        );
//
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $data[] = $row;
//        }
//
//        if (!isset($data)) {
//            $data = [];
//        }
//
//        closeConnection($conn);
//        return $data;
//    } catch (Exception $exc) {
//        echo $exc->getTraceAsString();
//        return false;
//    }
//}


define("LOGIN_SERVICE", "login_service");

if (!isset($service_name)) {
    $service_name = "login_service";
}
if (!defined("DB_UTILS")) {
    require './DBUtils.php';
}

if (!defined("PHP_UTILS")) {
    require './PHPUtils.php';
}

if (!defined("MENU_SERVICE")) {
    require './menu.php';
}

session_start();
$mode = isset_request("mode");
switch ($mode) {
    case 'login':
        $username = isset_request("username");
        $pwd = isset_request("password");
        $user = login($username, $pwd);
        if (!$user) {
            $response['status'] = false;
            $respoonse['message'] = 'Sai tài khoản hoặc mật khẩu';
            break;
        }
        if ($user['is_active'] == 0) {
            $response['status'] = false;
            $response['message'] = 'Tài khoản đang bị khóa. Vui lòng liên hệ quản trị viên để được mở khóa';
            break;
        }

        $response['status'] = true;
        $user_id = $user['id'];
        $menu = getmenu_by_userid($user_id);

        if (!$menu) {
            $response['status'] = false;
            break;
        }
        $can_access_url = get_menu_url_string($menu);
        $menu = order_menu($menu);


        $_SESSION['menu'] = $menu;
        $_SESSION['staff_id'] = $user_id;
        $_SESSION['staff_name'] = $user['name'];
        $_SESSION['staff_profile_image'] = $user['profile_picture'];
        $_SESSION['staff_slogan'] = $user['profile_short_description'];
        $_SESSION['staff_username'] = $user['username'];
        $_SESSION['is_logined'] = true;
        $_SESSION['can_access_url'] = $can_access_url;
        $cookie_name = "id";
        setcookie($cookie_name, $user_id, time() + (86400 * 30), "/");
        break;
    case 're_get_menu':
        $user_id = $_SESSION['staff_id'];
        $menu = getmenu_by_userid($user_id);

        if (!$menu) {
            $response['status'] = false;
            break;
        }
        $can_access_url = get_menu_url_string($menu);
        $menu = order_menu($menu);


        $_SESSION['menu'] = $menu;
        $_SESSION['can_access_url'] = $can_access_url;
        $response['status'] = true;
        break;
    case 'logout':
        $response['status'] = true;
        session_destroy();
        break;
    default:
        if ($service_name == "login_service") {
            $response['status'] = false;
            $response['message'] = "Can't find case";
        }
}
if ($service_name == "login_service") {
    echo json_encode($response);
}

// Kiểm tra xem có phải file chính (file được gọi service)
function login($username, $pwd) {
    try {
        $conn = getConnection();
        $query = "SELECT *
                from user
                where
                    username = :username
                    and password = :pwd and is_deleted = false";
        $stmt = $conn->prepare($query);
        $stmt->execute(
                [
                    ":username" => $username,
                    ":pwd" => $pwd
                ]
        );

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        closeConnection($conn);
        return $data;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function getmenu_by_userid($user_id) {
    try {
        $conn = getConnection();
        $query = "SELECT  
            menu.id as menu_id,
            menu.parent_id as parent_id,
            menu.name as menu_name,
            menu.fa_icon,
            menu.url
            FROM menu
                join permission_menu permenu on menu.id = permenu.menu_id or menu.parent_id = permenu.menu_id
                join permission permis on permis.id = permenu.permission_id
                join permission_user perusr on perusr.permission_id = permis.id

                WHERE perusr.user_id = :user_id and menu.is_deleted = false
                ORDER by menu.parent_id, menu.id";
        $stmt = $conn->prepare($query);
        $stmt->execute(
                [
                    ":user_id" => $user_id
                ]
        );

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        if (!isset($data)) {
            $data = [];
        }

        closeConnection($conn);
        return $data;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}
