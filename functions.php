<?php
function getData($db, $table, $api)
{
    $query = "SELECT * from `$table`";
    $result = mysqli_query($db,$query);
    $row = array();

    if (mysqli_num_rows($result) > 0) {

        while ($item = mysqli_fetch_array($result)) {
            $row [] = $item;
        }
    }
    if ($api == 'true') echo json_encode($row);
    else return $row;
}

function getDataWithCondition($db, $table, $condition, $api)
{
    $query = "SELECT * from `$table` WHERE $condition";
    $result = mysqli_query($db,$query);
    $row = array();

    if (mysqli_num_rows($result) > 0) {

        while ($item = mysqli_fetch_array($result)) {
            $row [] = $item;
        }
    }
    if ($api == 'true') echo json_encode($row);
    else return $row;
}

function getSpecificDataWithCondition($db, $field, $table, $condition, $api)
{
    $query = "SELECT $field from `$table` WHERE $condition";
    $result = mysqli_query($db,$query);
    $row = array();

    if (mysqli_num_rows($result) > 0) {

        while ($item = mysqli_fetch_array($result)) {
            $row [] = $item;
        }
    }
    if ($api == 'true') echo json_encode($row);
    else return $row;
}

function getDataWithLeftJoinCondition($db, $table, $foreignTable, $foreignCondition, $condition, $api)
{
    // `receiver_id`= 2 && `sender_id` = 1 || `receiver_id`= 1 && `sender_id` = 2
    $query = "SELECT * from `$table` LEFT JOIN `$foreignTable` ON $foreignCondition WHERE $condition";
    $result = mysqli_query($db,$query);
    $row = array();

    if (mysqli_num_rows($result) > 0) {

        while ($item = mysqli_fetch_array($result)) {
            $row [] = $item;
        }
    }
    if ($api == 'true') echo json_encode($row);
    else return $row;
}
function getDataWithMultipleLeftJoinCondition($db, $table, $foreignTableOne, $foreignConditionOne, $foreignTableTwo, $foreignConditionTwo, $condition, $api)
{
    // `receiver_id`= 2 && `sender_id` = 1 || `receiver_id`= 1 && `sender_id` = 2
    $query = "SELECT * from `$table` LEFT JOIN `$foreignTableOne` ON $foreignConditionOne LEFT JOIN `$foreignTableTwo` ON $foreignConditionTwo WHERE $condition";
    $result = mysqli_query($db,$query);
    $row = array();

    if (mysqli_num_rows($result) > 0) {

        while ($item = mysqli_fetch_array($result)) {
            $row [] = $item;
        }
    }
    if ($api == 'true') echo json_encode($row);
    else return $row;
}

function insertFields($db, $table, $fields, $values)
{
    $query = "INSERT INTO `$table` ($fields)
    VALUES ($values)";

    if (mysqli_query($db, $query)) {
        return "New record created successfully";
    } else {
        return "Error: " . $query . "<br>" . mysqli_error($db);
    }
}
function insertFieldsGetId($db, $table, $fields, $values)
{
    $query = "INSERT INTO `$table` ($fields)
    VALUES ($values)";

    if (mysqli_query($db, $query)) {
        return mysqli_insert_id($db);
    } else {
        return "Error: " . $query . "<br>" . mysqli_error($db);
    }
}

function updateField($db, $table, $field_value, $condition, $api) {
    $query = "UPDATE `$table` SET $field_value WHERE $condition";

    if (mysqli_query($db, $query)) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }
}

function deleteRecord($db, $table, $condition, $api){
    $query="DELETE from `$table` WHERE $condition";
    $exec= mysqli_query($db,$query);
    if($exec){
      echo "Data was deleted successfully";
    }else{
        $msg= "Error: " . $query . "<br>" . mysqli_error($db);
      echo $msg;
    }
}