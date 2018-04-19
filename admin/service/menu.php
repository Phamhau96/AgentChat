<?php

define("MENU_SERVICE", "menu_service");

if (!isset($service_name)) {
    $service_name = "menu_service";
}

if (!defined("DB_UTILS")) {
    require './DBUtils.php';
}

if (!defined("PHP_UTILS")) {
    require './PHPUtils.php';
}

if ($service_name == "menu_service") {
    $mode = isset_request("mode");
    switch ($mode) {
        case 'get_data':
            $menu = get_menu();

            if (!$menu) {
                $response['status'] = false;
                break;
            }
            $menu_list = order_menu($menu);
            $response['data'] = $menu_list;
            $response['parent_menu'] = get_parent_menu($menu);
            $response['status'] = true;
            break;
        case 'add_data':
            $parent_id = isset_request("parent_id");
            $name = isset_request("name");
            $fa_icon = isset_request("fa_icon");
            $url = isset_request("url");
            $response['status'] = add_menu($parent_id, $name, $fa_icon, $url);
            break;
        case 'update_data':
            $id = isset_request("id");
            $parent_id = isset_request("parent_id");
            $name = isset_request("name");
            $fa_icon = isset_request("fa_icon");
            $url = isset_request("url");
            $response['status'] = update_menu($id, $parent_id, $name, $fa_icon, $url);
            break;
        case 'remove_data':
            $id = isset_request("id");
            $response['status'] = remove_menu($id);
            break;
        default:
            if ($service_name == "menu_service") {
                $response['status'] = false;
                $response['message'] = "Can't find case";
            }
    }

    echo json_encode($response);
}

function get_menu() {
    try {
        $conn = getConnection();
        $query = "SELECT 
                    child.id as 'menu_id',
                    child.parent_id,
                    child.name as 'menu_name', 
                    child.fa_icon,
                    child.url
                    FROM menu parent 
                    join menu child on child.parent_id = parent.id
                    where child.is_deleted = false and parent.is_deleted = false

                    union 

                    select 
                    id as 'menu_id',
                    parent_id,
                    name as 'menu_name',
                    fa_icon,
                    url
                    from menu
                   	where is_deleted = false
                    ORDER by parent_id";
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

function add_menu($parent_id, $name, $fa_icon, $url) {
    try {
        $conn = getConnection();
        $query = "INSERT INTO menu
                    (parent_id, fa_icon,
                    name, url)
                    VALUES
                    (:parent_id, :fa_icon,
                    :name, :url)";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":parent_id" => $parent_id,
            ":fa_icon" => $fa_icon,
            ":url" => $url,
            ":name" => $name
        ]);



        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function update_menu($id, $parent_id, $name, $fa_icon, $url) {
    try {
        $conn = getConnection();
        $query = "UPDATE menu SET
                        parent_id = :parent_id,
                        fa_icon = :fa_icon,
                        name = :name,
                        parent_id = :parent_id,
                        url = :url
                  WHERE
                        id = :id
                   ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":id" => $id,
            ":parent_id" => $parent_id,
            ":fa_icon" => $fa_icon,
            ":url" => $url,
            ":name" => $name
        ]);



        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function remove_menu($id) {
    try {
        $conn = getConnection();
        $query = "UPDATE menu SET
                        is_deleted = true
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":id" => $id
        ]);



        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function order_menu($menu) {
    $main_menu = [];
    foreach ($menu as $menu_item) {
        if ($menu_item['parent_id'] == -1) {
            $main_menu[$menu_item['menu_id']] = [
                "menu_id" => $menu_item['menu_id'],
                "parent_id" => $menu_item["parent_id"],
                "menu_name" => $menu_item['menu_name'],
                "fa_icon" => $menu_item['fa_icon'],
                "url" => $menu_item['url'],
                "selected" => false,
                "child_menu" => []
            ];
        } else {
            $parent_id = $menu_item['parent_id'];
            if (isset($main_menu[$parent_id])) {
                $main_menu[$parent_id]['child_menu'][] = $menu_item;
            }
        }
    }

    // Convert by arrray
    foreach ($main_menu as $main) {
        $menu_arr[] = $main;
    }
    return $menu_arr;
}

function get_parent_menu($menu) {
    $parent_menu = [];
    foreach ($menu as $menu_item) {
        if ($menu_item['parent_id'] == -1) {
            $parent_menu[] = $menu_item;
        }
    }
    
    return $parent_menu;
}

function get_menu_url_string($menu){
    $menu_string_list = [];
    foreach ($menu as $menu_item) {
        if ($menu_item['parent_id'] != -1) {
            $menu_string_list[] = ($menu_item['url']);
        } 
    }
    $menu_string_list[] = 'index.php';
    $menu_string_list[] = '404.php';
    $menu_string_list[] = 'profile.php';
    
    return join(', ', $menu_string_list);
}