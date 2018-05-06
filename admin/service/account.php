<?php

define("ACCOUNT_SERVICE", "account_service");

session_start();
if (!isset($service_name)) {
    $service_name = "account_service";
}

if (!defined("PERMISSION_SERVICE")) {
    require './permission.php';
}

if (!defined("DB_UTILS")) {
    require './DBUtils.php';
}

if (!defined("PHP_UTILS")) {
    require './PHPUtils.php';
}
if ($service_name == "account_service") {
    $mode = isset_request("mode");
    switch ($mode) {
        case 'get_data':
            $account = get_account();
            $permission = get_permission_only();
            if (!$account) {
                $response['status'] = false;
                break;
            }

            $response['data'] = $account;
            $response['permission'] = $permission;
            $response['status'] = true;
            break;
        case 'add_data':
            $username = isset_request("username");
            $name = isset_request("name");
            $permission_id = isset_request("permission_id");
            $is_active = isset_request("is_active");
            $account_id = add_account($username, $name, $is_active);
            if (!$account_id) {
                $response['status'] = false;
                $response['message'] = "Không thể thêm mới tài khoản";
                break;
            }

            // Add permission_user
            $response['status'] = add_permission_user($account_id, $permission_id);
            break;
        case 'update_data':
            $user_id = isset_request("user_id");
            $username = isset_request("username");
            $name = isset_request("name");
            $permission_id = isset_request("permission_id");
            $is_active = isset_request("is_active");

            // Remove permission_user old
            remove_permission_user($user_id);

            // Update user
            $response['status'] = update_account($user_id, $username, $name, $is_active);

            // Insert permission_user record
            $response['status'] = add_permission_user($user_id, $permission_id);
            break;
        case 'remove_data':
            $id = isset_request("user_id");
            $response['status'] = remove_account($id);
            $response['status'] = remove_permission_user($id);

            break;
        case 'get_profile':
            $username = isset_request("username");
            $response['data'] = get_profile_detail($username);
            break;
        case 'update_profile':

            break;
        default:
            $response['status'] = false;
            $response['message'] = "Can't find case";
    }


    echo json_encode($response);
}

function get_account() {
    try {
        $conn = getConnection();
        $query = "SELECT 
                    user.id as user_id,
                    user.username,
                    user.name,
                    permission.id as permission_id,
                    permission.name as permission_name,
                    user.is_active
                      FROM user 
                       LEFT JOIN permission_user peruser on user.id = peruser.user_id
                       LEFT JOIN permission on permission.id = peruser.permission_id";
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

function add_account($username, $name, $is_active) {
    $is_active = ($is_active == '1') ? true : false;
    try {
        $conn = getConnection();
        $query = "INSERT INTO user
                    (username, name, is_active)
                    VALUES
                    (:username, :name, :is_active)";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":username" => $username,         
            ":name" => $name,
            ":is_active" => $is_active
        ]);

        if ($result) {
            return $conn->lastInsertId();
        } else {
            return -1;
        }
        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function update_account($id, $username, $name, $is_active) {
    try {
        $conn = getConnection();
        $query = "UPDATE user SET
                        username = :username,
                        name = :name,
                        is_active = :is_active
                  WHERE
                        id = :id
                   ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":id" => $id,
            ":username" => $username,
            ":name" => $name,
            ":is_active" => $is_active
        ]);

        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        return false;
    }
}

function remove_account($id) {
    try {
        $conn = getConnection();
        $conn->beginTransaction();
        $query = "DELETE FROM user 
                  WHERE
                        id = :id
                   ";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([
            ":id" => $id,
        ]);

        $conn->commit();

        closeConnection($conn);
        return $result;
    } catch (Exception $exc) {
        $conn->rollBack();
        echo $exc->getTraceAsString();
        return false;
    }
}

function get_profile_detail($username) {
    try {
        $conn = getConnection();
        $query = "SELECT 
                 name,
                 username,
                 profile_short_description
                   FROM user 
                   WHERE username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ":username" => $username
        ]);

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
