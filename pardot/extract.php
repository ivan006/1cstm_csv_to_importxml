<?php
// $entity_folder = "1 Prospect";
$entity_folder = "2 Visitor Activity";

// $entity_page = "1";
$entity_page = "5";

$extract_data_path = "data_and_settings/$entity_folder/1_extract_data/$entity_page.json";
$extract_data = file_get_contents($extract_data_path);
$extract_data = json_decode($extract_data, true);
$extract_settings_path = "data_and_settings/$entity_folder/1_extract_settings.json";
$extract_settings = file_get_contents($extract_settings_path);
$extract_settings = json_decode($extract_settings, true);
// header('Content-Type: application/json');
// echo json_encode($extract_data);
// exit;


$extracted_data["data"] = array();
$extracted_data["structure"] = array();
$error = array();
foreach ($extract_data["result"] as $key => $value) {

  if ($key !== "total_results") {
    foreach ($value as $key_2 => $value_2) {
      $extracted_data["data"][$key_2] = array();
      // $extracted_data[] = $value_2;
      $temp_array = array();
      $temp_array_2 = array();
      foreach ($value_2 as $key_3 => $value_3) {
        // if (gettype($value_3) == "array") {
        //   $extracted_data[$key_2][$key_3] = $value_3;
        // } elseif (gettype($value_3) == "null") {
        //
        // } else {
        //   $extracted_data[$key_2][$key_3] = gettype($value_3);
        // }
        $temp_var_3 = $key_3;
        if (gettype($value_3) == "array") {
          if (isset($extract_settings[$key_3])) {
            $temp_var = $extract_settings[$key_3];
            if (isset($value_3[$temp_var])) {
              $temp_var_3 = $key_3."_".$temp_var;

              $temp_array[$temp_var_3] = gettype($value_3[$temp_var]);


              $temp_var_2 = $value_3[$temp_var];
            } else {
              foreach ($value_3 as $key_4 => $value_4) {
                if (isset($value_4[$temp_var])) {
                  $temp_var_3 = $key_3."_".$temp_var;

                  $temp_array[$temp_var_3] = gettype($value_4[$temp_var]);

                  $temp_var_2 = $value_4[$temp_var];
                } else {
                  $error[$key_3." - faulty setting"] = "";
                }
              }

            }
          } else {
            // $temp_array[$key_3] = $value_3;
            // $temp_array[$key_3] = gettype($value_3);

            $error[$key_3." - no setting"] = "";
            // $temp_var_2 = $value_3;
          }
        } elseif (gettype($value_3) == "NULL") {

        } else {
          $temp_array[$key_3] = gettype($value_3);

          $temp_var_2 = $value_3;
        }
        // if (gettype($temp_var_2) == "string") {
        //   if (strpos($temp_var_2, "\"") !== false) {
        //     $extracted_data["data"][$key_2][$key_3] = str_replace("\"","\"\"",$temp_var_2);
        //   } else {
        //     $extracted_data["data"][$key_2][$key_3] = $temp_var_2;
        //   }
        //
        // } else {
        // }
        $temp_array_2[$temp_var_3] = $temp_var_2;
      }
      // $extracted_data["data"][$key_2] = ksort($temp_array_2);
      // ksort($temp_array_2);
      // $temp_array_3["id"] = $temp_array_2["id"];
      // unset($temp_array_2["id"]);
      // $temp_array_3 = array_merge($temp_array_3, $temp_array_2);

      $extracted_data["data"][$key_2] = $temp_array_2;
      $extracted_data["structure"] = array_merge($temp_array, $extracted_data["structure"]);
    }
  }
}

// header('Content-Type: application/json');
// // echo json_encode(array($error, $extracted_data["structure"]), JSON_PRETTY_PRINT);
// echo json_encode($extracted_data["structure"], JSON_PRETTY_PRINT);
// exit;


?>

<h1>1 Extract - <?php echo $entity_folder ?>, page <?php echo $entity_page ?></h1>
<details open>
  <summary>errors</summary>
  <textarea name="name" rows="8" cols="80"><?php echo json_encode($error, JSON_PRETTY_PRINT); ?></textarea>
</details>
<details open>
  <summary>structure</summary>
  <textarea name="name" rows="8" cols="80"><?php echo json_encode($extracted_data["structure"], JSON_PRETTY_PRINT); ?></textarea>
</details>
<details open>
  <summary>data</summary>
  <textarea name="name" rows="8" cols="80"><?php echo json_encode($extracted_data["data"], JSON_PRETTY_PRINT); ?></textarea>
</details>
