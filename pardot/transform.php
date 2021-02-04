<?php
$entity_folder = "1 Prospect";
// $entity_folder = "2 Visitor Activity";

$transform_data_path = "data_and_settings/".$entity_folder."/transform_data.json";
$transform_data = file_get_contents($transform_data_path);
$transform_data = json_decode($transform_data, true);
$transform_settings_path = "data_and_settings/".$entity_folder."/transform_settings.json";
$transform_settings = file_get_contents($transform_settings_path);
$transform_settings = json_decode($transform_settings, true);
// // header('Content-Type: application/json');
// // echo json_encode($transform_data);
// // exit;


$transformed_data["data"] = array();
$transformed_data["structure"] = array();
$error = array();
foreach ($transform_data as $key => $value) {
  foreach ($transform_settings as $key_2 => $value_2) {
    if (isset($value[$key_2])) {
      $transformed_data["data"][$key][$key_2] = $value[$key_2];
    } else {
      $transformed_data["data"][$key][$key_2] = null;
    }
  }
}

// header('Content-Type: application/json');
// // echo json_encode(array($error, $transformed_data["structure"]), JSON_PRETTY_PRINT);
// echo json_encode($transformed_data["structure"], JSON_PRETTY_PRINT);
// exit;


?>

<details open>
  <summary>errors</summary>
  <textarea name="name" rows="8" cols="80"><?php echo json_encode($error, JSON_PRETTY_PRINT); ?></textarea>
</details>
<details open>
  <summary>structure</summary>
  <textarea name="name" rows="8" cols="80"><?php echo json_encode($transformed_data["structure"], JSON_PRETTY_PRINT); ?></textarea>
</details>
<details open>
  <summary>data</summary>
  <textarea name="name" rows="8" cols="80"><?php echo json_encode($transformed_data["data"], JSON_PRETTY_PRINT); ?></textarea>
</details>
