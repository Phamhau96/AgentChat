<?php

define("PERMISSION_SERVICE", "permission_service");

if (!isset($service_name)) {
    $service_name = "permission_service";
}

if (!defined("MENU_SERVICE")) {
    require './menu.php';
}

if (!defined("DB_UTILS")) {
    require './DBUtils.php';
}

if (!defined("PHP_UTILS")) {
    require './PHPUtils.php';
}
if ($service_name == "permission_service") {
    $mode = isset_request("mode");
    switch ($mode) {
        case 'get_data':
            $permission = get_permission();
            $menu = get_menu();
            if (!$permission) {
                $response['status'] = false;
                break;
            }
            $menu = order_menu($menu);
            $permission = order_permission($permission, $menu);

            $response['data'] = $permission;
            $response['menu'] = $menu;
            $response['status'] = true;
            break;
        case 'add_data':
            $permission_name = isset_request("permission_name");
            $menu_id_list = isset_request("menu_id_list");
            $permission_insert_id = add_permission($permission_name);

            $response['status'] = add_permission_menu($permission_insert_id, $menu_id_list);
            break;
        case 'update_data':
            $id = isset_request("id");
            $permission_name = isset_request("permission_name");
            $menu_id_list = isset_request("menu_id_list");

            // Remove permission_menu old
            remove_permission_menu($id);

            // Update permission
            $response['status'] = update_permission($id, $permission_name);

            // Insert new record
            $response['status'] = add_permission_menu($id, $menu_id_list);
            break;
        case 'remove_data':
            $id = isset_request("id");
            $response['status'] = remove_permission($id);
            $response['status'] = remove_permission_menu($id);

            break;
        default:
            $response['status'] = false;
            $response['message'] = "Can't find case";
    }


    echo json_encode($response);
}

function get_permission_only() {
    try {
        $conn = getConnection();
        $query = "SELECT 
                 id, name              
                   FROM permission";
        $stmt = $conn->prepare($query);
        $stmt->execute();

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

function get_permission() {
    try {
        $conn = getConnection();
        $query = "SELECT 
                  permis.id as permission_id, 
                  menu.id as menu_id,
                  permis.name as permission_name                 
                   FROM permission permis
                   left join permission_menu permenu on permis.id = permenu.permission_id
                   left join menu on permenu.menu_id = menu.id";
        $stmt = $conn->prepare($query);
        $stmt->execute();

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

function order_permission($permission, $menu) {
    $permis_menu = [];
    foreach ($permission as $permis) {
        if (!isset($permis_menu[$permis['permission_id']])) {
            $permis_item['permission_id'] = $permis['permission_id'];
            $permis_item['permission_name'] = $permis['permission_name'];
            $permis_menu[$permis['permission_id']] = $permis_item;
            $permis_menu[$permis['permission_id']]['menu'] = [];
        }

        foreach ($menu as $menuitem) {
            if ($menuitem['menu_id'] == $permis['menu_id']) {
                $permis_menu[$permis['permission_id']]['menu'][] = $menuitem;
            }
        }
    }

    // convert to array
    $permission_menu = [];
    foreach ($permis_menu as $permis) {
        $permission_menu[] = $permis;
    }
    return $permission_menu;
}

function add_permission($permission_name) {
    try {
        $conn = getConnection();
        $query = "INSERT INTO permission
                    (name)
                    VALUES
                    (:name)";
        $stmt = $conn->prepare($query);
        $insert_status = $stmt->execute([
            ":name" => $permission_name
        ]);

        if ($insert_status) {
            return $conn->lastInsertId();
        } else {
            return 0;
        }



        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function add_permission_menu($permission_id, $menu_id_list) {
    try {
        $conn = getConnection();
        $query = "INSERT INTO permission_menu
                    (permission_id, menu_id)
                    VALUES
                    (:permission_id, :menu_id)";
        $stmt = $conn->prepare($query);
        foreach ($menu_id_list as $menu_id) {
            $insert_status = $stmt->execute([
                ":permission_id" => $permission_id,
                ":menu_id" => $menu_id
            ]);
        }

        closeConnection($conn);
        return $insert_status;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function update_permission($id, $name) {
    try {
        $conn = getConnection();
        $query = "UPDATE permission SET
                        name = :name
                  WHERE
                        id = :id
                   ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":id" => $id,
            ":name" => $name
        ]);



        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function remove_permission($permission_id) {
    try {
        $conn = getConnection();
        $query = "DELETE FROM permission
                    WHERE id = :permission_id";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":permission_id" => $permission_id
        ]);

        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function remove_permission_menu($permission_id) {
    try {
        $conn = getConnection();
        $query = "DELETE FROM permission_menu
                    WHERE permission_id = :permission_id";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":permission_id" => $permission_id
        ]);

        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function add_permission_user($user_id, $permission_id) {
    try {
        $conn = getConnection();
        $query = "INSERT INTO permission_user
                    (user_id, permission_id)
                    VALUES
                    (:user_id, :permission_id)";
        $stmt = $conn->prepare($query);
        $insert_status = $stmt->execute([
            ":permission_id" => $permission_id,
            ":user_id" => $user_id
        ]);

        closeConnection($conn);
        return $insert_status;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function remove_permission_user($user_id) {
    try {
        $conn = getConnection();
        $query = "DELETE FROM permission_user
                    WHERE user_id = :user_id";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":user_id" => $user_id
        ]);

        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}
