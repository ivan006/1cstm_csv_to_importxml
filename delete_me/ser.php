<!DOCTYPE html>
<html>
<body>

<?php
$array = '[
[12,27,49],
[37,67,27,14,13,54,29,44],
[38,33,20,65],
[],
[41,70,59,16,61,53,27]
]';
// foreach ($array as $key => $value){
//   foreach ($value as $key_2 => $value_2){
//     $array[$key][$key_2] = $value_2;
//   }
// }
$array = json_decode($array);
foreach ($array as $key => $value) {
  echo serialize($value)."<br>";
}


?>

</body>
</html>
