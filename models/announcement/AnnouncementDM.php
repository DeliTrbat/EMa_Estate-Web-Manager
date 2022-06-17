<?php
include_once DIR_MODELS . "Model.php";
include_once DIR_CORE . "exceptions/InternalException.php";

class AnnouncementDM
{

    public function __construct()
    {
    }

    public function get_announcement_by_id($id)
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT id,account_id,title,price,surface,address,transaction_type,description,type FROM announcements WHERE id= $id";

        $stid = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stid);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }
        $row = oci_fetch_assoc($stid);

        $row = array_change_key_case($row, CASE_LOWER);
        if ($row['type'] !== "land") {
            $row = array_merge($row, $this->get_building($row['id'], $row['type']));
        }
        $row['transactionType'] = $row['transaction_type'];
        unset($row['transaction_type']);
        $row['accountID'] = $row['account_id'];
        unset($row['account_id']);

        $row['imagesURLs'] = $this->get_announcement_images_urls($row['id']);

        oci_free_statement($stid);
        DatabaseConnection::close();
        return $row;
    }

    public function get_announcements($count, $index = 0)
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT id,title,price,surface,address,transaction_type,description,type FROM (SELECT rownum AS rn, a.* FROM announcements a) WHERE rn > $index AND rn <= $index+$count";

        $stid = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stid);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }

        $data = [];

        for ($i = 0; $i <= $count; $i++) {
            if (($row = oci_fetch_assoc($stid)) != false) {
                $row = array_change_key_case($row, CASE_LOWER);
                if ($row['type'] !== "land") {
                    $row = array_merge($row, $this->get_building($row['id'], $row['type']));
                }
                $row['transactionType'] = $row['transaction_type'];
                unset($row['transaction_type']);

                $row['imageURL'] = "api/items/image?announcement_id=" . $row['id'];
                $data[$i] = $row;
            } else {
                break;
            }
        }

        oci_free_statement($stid);
        DatabaseConnection::close();
        return $data;
    }

    public function get_building($id, $type)
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT * FROM buildings WHERE announcement_id = $id";;
        if ($type === "house") {
            $sql = "SELECT floor,bathrooms,basement,built_in,parking_lots FROM buildings WHERE announcement_id = $id";
        } elseif ($type === "office") {
            $sql = "SELECT floor,bathrooms,parking_lots,built_in FROM buildings WHERE announcement_id = $id";
        } elseif ($type === "apartment") {
            $sql = "SELECT ap_type,floor,bathrooms,parking_lots,built_in FROM buildings WHERE announcement_id = $id";
        }

        $stid = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stid);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }

        $row = oci_fetch_assoc($stid);
        $row = array_change_key_case($row, CASE_LOWER);
        if ($type === "house") {
            $row['floors'] = $row['floor'];
            unset($row['floor']);
        } elseif ($type === "apartment") {
            $row['apartmentType'] = $row['ap_type'];
            unset($row['ap_type']);
        }
        $row['builtIn'] = $row['built_in'];
        unset($row['built_in']);
        $row['parkingLots'] = $row['parking_lots'];
        unset($row['parking_lots']);

        oci_free_statement($stid);
        DatabaseConnection::close();
        return $row;
    }

    public function get_image($announcement_id)
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT name,type,image FROM images WHERE announcement_id = $announcement_id";

        $stid = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stid);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }

        $row = oci_fetch_assoc($stid);
        if ($row != false) {
            $row['IMAGE'] = $row['IMAGE']->load();
        }

        oci_free_statement($stid);
        DatabaseConnection::close();
        return $row;
    }

    public function get_image_by_id($id)
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT name,type,image FROM images WHERE id = $id";

        $stid = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stid);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }

        $row = oci_fetch_assoc($stid);
        if ($row != false) {
            $row['IMAGE'] = $row['IMAGE']->load();
        }

        oci_free_statement($stid);
        DatabaseConnection::close();
        return $row;
    }

    public function get_announcement_images_urls($announcement_id)
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT id FROM images WHERE announcement_id = $announcement_id";

        $stid = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stid);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }

        $imagesURLs = [];
        $index = 0;

        while (($row = oci_fetch_assoc($stid)) != false) {
            $imagesURLs[$index] = "api/items/image?id=" . $row['ID'];
            $index++;
        }

        oci_free_statement($stid);
        DatabaseConnection::close();
        return $imagesURLs;
    }

    public function get_announcements_count()
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT count(*) FROM announcements";

        $stid = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stid);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }

        if (($count = oci_fetch($stid)) != false) {
            $count = oci_result($stid, 1);
        }

        oci_free_statement($stid);
        DatabaseConnection::close();
        return $count;
    }

    public function find_id_by_account_id_and_title($account_id, $title): int
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT id FROM announcements WHERE account_id = $account_id AND title LIKE '$title'";

        $stid = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stid);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }

        if (($row = oci_fetch($stid)) != false) {
            $row = oci_result($stid, 1);
        }
        oci_free_statement($stid);
        DatabaseConnection::close();
        return $row;
    }

    public function add_image($announcement_id, $blob, $name, $type)
    {
        DatabaseConnection::get_connection();
        $sql = "INSERT INTO images (announcement_id, name, type, image) VALUES ($announcement_id, '$name','$type',EMPTY_BLOB()) RETURNING image INTO :image";
        $stmt = oci_parse(DatabaseConnection::$conn, $sql);
        $newlob = oci_new_descriptor(DatabaseConnection::$conn, OCI_D_LOB);
        oci_bind_by_name($stmt, ":image", $newlob, -1, OCI_B_BLOB);

        oci_execute($stmt, OCI_NO_AUTO_COMMIT);

        if ($newlob->save($blob)) {
            oci_commit(DatabaseConnection::$conn);
        } else {
            oci_rollback(DatabaseConnection::$conn);
        }

        $newlob->free();

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }
        oci_free_statement($stmt);
        DatabaseConnection::close();
    }

    /**
     * Checks if the title already exists in the database
     * 
     * @param $title
     * @return int|bool 1 if exists 0 if not | false in case of error
     */
    public function check_existence_title($title, $id): int|bool
    {
        DatabaseConnection::get_connection();
        $sql = "SELECT count(*) FROM announcements WHERE title='$title' AND account_id=$id";

        $stmt = oci_parse(DatabaseConnection::$conn, $sql);
        oci_execute($stmt);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }

        if (($row = oci_fetch($stmt)) != false) {
            $row = oci_result($stmt, 1);
        }
        oci_free_statement($stmt);
        DatabaseConnection::close();
        return $row;
    }

    public function create_announcement(array $data)
    {
        DatabaseConnection::get_connection();

        foreach ($data as $key => &$value) {
            $value["tag"] = ":$key" . "_bv";
        }

        $columns = [];
        $tags = [];

        foreach ($data as $key => &$value) {
            array_push($columns, $key);
            array_push($tags, $value["tag"]);
        }

        $sql = "INSERT INTO announcements (" . implode(",", $columns) . ") VALUES (" . implode(",", $tags) . ") RETURNING id INTO :id";
        $stmt = oci_parse(DatabaseConnection::$conn, $sql);

        foreach ($data as $key => &$value) {
            oci_bind_by_name($stmt, $value["tag"], $value["value"], -1, $value["type"]);
        }

        oci_bind_by_name($stmt, ":id", $id, -1, OCI_B_INT);

        oci_execute($stmt);

        $errors = oci_error(DatabaseConnection::$conn);

        if ($errors) {
            throw new InternalException($errors);
        }
        oci_free_statement($stmt);
        DatabaseConnection::close();

        return $id;
    }
}
