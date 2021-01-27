<?php

$file="content/step_1.html";
$tsv= file_get_contents($file);
$tsv= str_replace("<br />", "_linebreak_", $tsv);
$tsv= str_replace("<td>&nbsp;</td>", "<td></td>", $tsv);

$tsv= rtrim($tsv, "\n\r");
$array_0 = html_to_obj($tsv);
// echo json_encode(, JSON_PRETTY_PRINT);
$array_1 = $array_0["children"][0]["children"][0]["children"][1]["children"];
foreach ($array_1 as $key => $value) {
	$array_2[$key] = array();
	foreach ($value["children"] as $key_2 => $value_2) {
		$array_2[$key][$key_2] = "";
		if (isset($value_2["html"])) {
			$array_2[$key][$key_2] = $value_2["html"];
		}
	}
}

$array_3 = array();
foreach ($array_2 as $key => $value) {
	if ($key !== 0) {
		foreach ($value as $key_2 => $value_2) {
			$array_3[$key][$array_2[0][$key_2]] = $value_2;
			// $array_3[$key][$key_2] = $array[0];
		}
	}
}


// header('Content-Type: application/json');
// echo json_encode($array_3, JSON_PRETTY_PRINT);
// exit;


// header('Content-Type: application/json');
// echo json_encode($array_3);
// exit;

$fields = array(
	array(
		"export_name" => "title",
		"type" => "simple_string",
		"import_name" => "Heading",
	),
	array(
		"export_name" => "content:encoded",
		"type" => "simple_string",
		"import_name" => "",
	),
	array(
		"export_name" => "wp:status",
		"type" => "simple_string",
		"import_name" => "",
	),
	array(
		"export_name" => "wp:post_type",
		"type" => "simple_string",
		"import_name" => "",
	),
	array(
		"export_name" => "services",
		"type" => "simple_multilookup",
		"import_name" => array(
			"Custom Solutions",
			"Digital Transformation",
			"Strategy and Advisory",
			"Data Solutions",
			"UX",
			"Coaching & Training"
		),
	),
	array(
		"export_name" => "industries",
		"type" => "simple_multilookup",
		"import_name" => array(
			"Financial Services",
			"Banking",
			"Insurance",
			"Retail and Consumer Services",
			"Logistics",
			"Travel",
			"Energy",
			"Agriculture",
			"Mining and Manufacturing",
			"Industrials, Agriculture & Energy (Old)",
			"Technology",
			"Media",
			"Telecommunications",
			"Technology, Media & Telecommunications (Old)",
			"Health",
			"Education",
			"Health & Education (Old)"
		),
	),
	array(
		"export_name" => "dyncontel_elementor_templates",
		"type" => "semiadvanced_string",
		"import_name" => "",
	),
	// array(
	// 	"export_name" => "full_image",
	// 	"type" => "advanced_lookup",
	// 	"import_name" => "Card_logo_2",
	// ),
	array(
		"export_name" => "company_logo",
		"type" => "advanced_lookup",
		"import_name" => "Logo",
	),
	array(
		"export_name" => "_thumbnail_id",
		"type" => "semiadvanced_lookup",
		"import_name" => "Screenshots",
	),
	array(
		"export_name" => "description_part_1",
		"type" => "advanced_string",
		"import_name" => "Content_part_1",
	),
	array(
		"export_name" => "video",
		"type" => "advanced_string",
		"import_name" => "Video_link",
	),
	array(
		"export_name" => "description_part_2",
		"type" => "advanced_string",
		"import_name" => "Content_part_2",
	),
	array(
		"export_name" => "banner_color",
		"type" => "advanced_string",
		"import_name" => "Banner_strip_colour",
	),
	array(
		"export_name" => "quote_color",
		"type" => "advanced_string",
		"import_name" => "Content_accent_colour",
	),
	array(
		"export_name" => "tools",
		"type" => "advanced_multilookup",
		"import_name" => "Sanitised list",
	),
	array(
		"export_name" => "company_logo_for_card",
		"type" => "advanced_lookup",
		"import_name" => "Card_logo_2",
	),
);

$multi_value_fields = array();
foreach ($fields as $key => $value) {
	if ($value["type"] == "simple_multilookup" OR $value["type"] == "semiadvanced_lookup" OR $value["type"] == "advanced_lookup" OR $value["type"] == "advanced_multilookup") {
		$multi_value_fields[$value["export_name"]] = array();
	}
}


ob_start();
?>
<table>
	<tr>
		<?php
		foreach ($fields as $key => $value) {
			if ($value["type"] == "advanced_string" OR $value["type"] == "advanced_multilookup" OR $value["type"] == "advanced_lookup") {
				?>
				<td><?php echo $value["export_name"] ?>; code:</td>
				<?php
			}
			else {
				?>
				<td><?php echo $value["export_name"] ?></td>
				<?php
			}
		}
		?>
	</tr>
	<tr>
		<?php foreach ($fields as $key => $value) { ?>
			<td><?php echo $value["type"] ?></td>
		<?php } ?>
	</tr>
	<?php foreach ($array_3 as $key => $value) { ?>
		<tr>
			<?php foreach ($fields as $key_2 => $value_2) { ?>
				<td>
					<?php
					if ($value_2["type"] == "simple_multilookup") {

						$temp_array = array();
						foreach ($value_2["import_name"] as $key_3 => $value_3) {
							if ($value[$value_3] !== "") {
								// $temp_array[] = slugify($value_3);
								$temp_array[] = $value_3;
							}

						}
						echo json_encode($temp_array);
						if ($temp_array !== null) {
							// code...
							$multi_value_fields[$value_2["export_name"]] = array_merge($multi_value_fields[$value_2["export_name"]], array_flip($temp_array));
						}
					}
					elseif ($value_2["type"] == "advanced_multilookup") {
						if (isset($value[$value_2["import_name"]])) {
							if (strpos($value[$value_2["import_name"]], ',') !== false) {
								$separator = ",";
							}
							elseif (strpos($value[$value_2["import_name"]], '/') !== false) {
								$separator = "/";
							}
							elseif (strpos($value[$value_2["import_name"]], '_linebreak_') !== false) {
								$separator = "_linebreak_";
							}
							else {
								$separator = "";
							}

							if ($separator == "") {
								echo $value[$value_2["import_name"]];
								// $multi_value_fields[$value["export_name"]] = array_merge($multi_value_fields[$value["export_name"]], $value[$value_2["import_name"]]);
								// $multi_value_fields[$value_2["export_name"]] = array_merge($multi_value_fields[$value_2["export_name"]], $value[$value_2["import_name"]]);
								// $multi_value_fields[$value_2["export_name"]] = array_merge($multi_value_fields[$value_2["export_name"]], $value[$value_2["import_name"]]);

								$multi_value_fields[$value_2["export_name"]] = array_merge($multi_value_fields[$value_2["export_name"]], array($value[$value_2["import_name"]]=>1));
							}
							else {
								$temp_array = explode($separator, $value[$value_2["import_name"]]);
								$temp_array_2 = array();
								foreach ($temp_array as $key_3 => $value_3) {
									// $temp_var = trim($value_3, "\n\r");
									$temp_var = strip_tags($value_3);
									$temp_var = trim($temp_var);
									$temp_array_2[] = $temp_var;
								}
								echo json_encode($temp_array_2);
								// $multi_value_fields[$value_2["export_name"]] = array_merge($multi_value_fields[$value_2["export_name"]], $temp_array);
								$multi_value_fields[$value_2["export_name"]] = array_merge($multi_value_fields[$value_2["export_name"]], array_flip($temp_array_2));
							}



						}
					}
					else {
						if (isset($value[$value_2["import_name"]])) {
							echo $value[$value_2["import_name"]];
						}
					}

					?>

				</td>
			<?php } ?>
		</tr>
	<?php } ?>
</table>
<?php
$data["body"] = ob_get_contents();
ob_end_clean();
// $data["body"] = implode($data["body"]);



foreach ($multi_value_fields as $key => $value) {
	ob_start();
	?>
	<table>
		<?php foreach (array_keys($value) as $key_2 => $value_2) { ?>
			<tr>
				<td>
					<?php echo $value_2; ?>
				</td>
				<td>
					<?php echo $key_2 ?>
				</td>
			</tr>
		<?php } ?>
	</table>
	<?php
	$data["lookups"][$key] = ob_get_contents();
	ob_end_clean();
}

?>
<h1>Step 1</h1>
<div class="">

	<h2>whats happening</h2>
	<p>
		This step
		<br>-corrects column names
		<br>-helps normalise the data by dealing with
		<br>- -sets of checkboxed fields (e.g. instry 1? check, industry2? not check etc)
		<br>- - -here it groups the data into a json string
		<br>- - -it also checks which values are used and makes a lookup
		<br>- -fields that are trying to be json strings but have unstandard separators like ",", "\n\r" or "/" etc
		<br>- - -here it tries to standardise the separated strings into json strings
		<br>- - -it also checks which values are used and makes a lookup
	</p>
	<h2>what do i do</h2>

	<p>
		-this uses data from "content/step_1.html" when inserting data into this file do this  "copy ur data into google sheets and then copy it from google sheets into this to format it into html
		<a href="https://html-online.com/editor/">https://html-online.com/editor/</a>"
		<br>-please copy this into "content/step_2.html" but first "copy ur data into google sheets and then copy it from google sheets into this to format it into html
		<a href="https://html-online.com/editor/">https://html-online.com/editor/</a>"
	</p>
</div>
<h2>content</h2>
<h3>table</h3>
<details>
	<summary>Details</summary>
	<div class="" style="border:solid 1px grey;">

		<!-- <textarea name="name" rows="8" cols="80"><?php //echo $data["body"] ?></textarea> -->
		<?php echo $data["body"] ?>
	</div>
</details>

<h3>lookups</h3>
<?php
foreach ($data["lookups"] as $key => $value) {
	?>
	<details>
		<summary><?php echo $key ?>.html</summary>

		<div class="" style="border:solid 1px grey; width:100%;">
			<!-- <textarea name="name" rows="8" cols="80"><?php //echo $value; ?></textarea> -->
			<?php echo $value; ?>
		</div>
	</details>
	<?php
}
?>
<!--
<details>
	<summary>Details</summary>

	<?php //echo json_encode(array_flip($temp_array_2)$multi_value_fields, JSON_PRETTY_PRINT); ?>
</details> -->
<?php


function html_to_obj($html) {
	$dom = new DOMDocument();
	$dom->loadHTML($html);
	return element_to_obj($dom->documentElement);
}

function element_to_obj($element) {
	$obj = array( "tag" => $element->tagName );
	foreach ($element->attributes as $attribute) {
		$obj[$attribute->name] = $attribute->value;
	}
	foreach ($element->childNodes as $subElement) {
		if ($subElement->nodeType == XML_TEXT_NODE) {
			$obj["html"] = $subElement->wholeText;
		}
		else {
			$obj["children"][] = element_to_obj($subElement);
		}
	}
	return $obj;
}



?>
