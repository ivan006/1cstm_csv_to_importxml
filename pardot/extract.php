<?php
$entity_folder = "2 Visitor Activity";

$extract_data = "data_and_settings/".$entity_folder."/extract_data.json";
$extract_data = file_get_contents($extract_data);
$extract_data = json_decode($extract_data, true);
// header('Content-Type: application/json');
// echo json_encode($extract_data);
// exit;

$extracted_data = array(
  "structure"=>array(),
  "data"=>array()
);
foreach ($extract_data["result"] as $key => $value) {
  if ($key !== "total_results") {
    foreach ($value as $key_2 => $value_2) {
      // $extracted_data[] = $value_2;
      foreach ($value_2 as $key_3 => $value_3) {
        // if (gettype($value_3) == "array") {
        //   $extracted_data[$key_2][$key_3] = $value_3;
        // } elseif (gettype($value_3) == "null") {
        //
        // } else {
        //   $extracted_data[$key_2][$key_3] = gettype($value_3);
        // }

        if (gettype($value_3) == "array") {
          $temp_array[$key_3] = $value_3;
        } elseif (gettype($value_3) == "NULL") {

        } else {
          $temp_array[$key_3] = gettype($value_3);
        }
      }
      $extracted_data["structure"] = array_merge($temp_array, $extracted_data["structure"]);
    }
  }
}

header('Content-Type: application/json');
echo json_encode($extracted_data);
exit;
?>
