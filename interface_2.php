<?php
// $value_2["export_value"] = "wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww";
// if (strlen($value_2["export_value"]) > 50) {
// 	// exit;
// 	$value_2["export_value"] = substr($value_2["export_value"], 0, 50)."...";
// 	echo strlen($value_2["export_value"])."<br>";
// }
//
//
// exit;


$file="content/step_2.html";
$tsv= file_get_contents($file);
// $tsv= str_replace("<br />", "\n\r", $tsv);
$tsv= str_replace("<td>&nbsp;</td>", "<td></td>", $tsv);
$tsv= str_replace("<div>", "", $tsv);
$tsv= str_replace("</div>", "", $tsv);

// $tsv= rtrim($tsv, "\n\r");
$array_0 = html_to_obj($tsv);
// header('Content-Type: application/json');
// echo json_encode($array_0, JSON_PRETTY_PRINT);
// exit;

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
	if ($key !== 0 AND $key !== 1) {
		foreach ($value as $key_2 => $value_2) {
			// $array_3[$key][$array_2[0][$key_2]."; type:".$array_2[1][$key_2]] = $value_2;
			$array_3[$key][$array_2[0][$key_2]]["export_value"] = $value_2;
			$array_3[$key][$array_2[0][$key_2]]["type"] = $array_2[1][$key_2];
			// $array_3[$key][$key_2] = $array[0];
		}
	}
}


// header('Content-Type: application/json');
// echo json_encode($array_3, JSON_PRETTY_PRINT);
// exit;


// zzzzzzzzzzzzzz


// simple_string
// simple_multilookup -- just verfify lookup names
// 	- industries
// 	- services
// semiadvanced_string
// semiadvanced_lookup -- get lookup ids
// 	- thumbnail
// advanced_lookup -- get lookup ids
// 	- full image
// 	- company logo
// advanced_string
// advanced_multilookup -- get lookup ids
// 	- tools

$lookups = array();
foreach ($array_3[2] as $key => $value) {
	// if ($value["type"] == "semiadvanced_lookup" OR $value["type"] == "advanced_lookup") {
	if ( in_array($value["type"], array('semiadvanced_lookup','advanced_lookup', 'simple_multilookup'), true ) ) {
		// zzzzzzzzzzzzzz
		if ($value["type"] == "advanced_lookup") {
			$key = explode("; code:",$key);
			$key = $key[0];
		}

		// header('Content-Type: application/json');
		// echo json_encode($key, JSON_PRETTY_PRINT);
		// exit;
		$lookup_file="content/step_2_lookups/$key.html";
		$lookup_tsv= file_get_contents($lookup_file);
		// $tsv= str_replace("<br />", "\n\r", $tsv);
		$lookup_tsv= str_replace("<td>&nbsp;</td>", "<td></td>", $lookup_tsv);
		$lookup_tsv= str_replace("<div>", "", $lookup_tsv);
		$lookup_tsv= str_replace("</div>", "", $lookup_tsv);

		// $tsv= rtrim($tsv, "\n\r");
		$lookup_array_0 = html_to_obj($lookup_tsv);
		// header('Content-Type: application/json');
		// echo json_encode($lookup_array_0, JSON_PRETTY_PRINT);
		// exit;

		$lookup_array_1 = $lookup_array_0["children"][0]["children"][0]["children"][1]["children"];
		foreach ($lookup_array_1 as $key_1 => $value_1) {
			$lookup_array_2[$key_1] = array();
			foreach ($value_1["children"] as $key_2 => $value_2) {
				$array_2[$key_1][$key_2] = "";
				if (isset($value_2["html"])) {
					$lookup_array_2[$key_1][$key_2] = $value_2["html"];
				}
			}
		}

		$lookup_array_3 = array();
		foreach ($lookup_array_2 as $key_1 => $value_1) {
			// if ($key_1 !== 0 AND $key_1 !== 1) {
			if ($key_1 !== 0) {
				// $lookup_array_3[$value_2[0]]=$value_2[1];


				// header('Content-Type: application/json');
				// echo json_encode($value_1, JSON_PRETTY_PRINT);
				// exit;
				// if (isset($value_1[1])) {
				// 	$lookup_array_3[$value_1[1]] = trim(preg_replace('/\t+/', '', $value_1[0]));
				// 	// code...
				// } else {
				// 	header('Content-Type: application/json');
				// 	echo json_encode($value_1[0], JSON_PRETTY_PRINT);
				// 	exit;
				// }
				$temp_value = trim(preg_replace('/\t+/', '', $value_1[1]));
				// $temp_value = utf8_decode($temp_value);
				// $temp_value = str_replace("’", "zzzzzzzzz", $temp_value);
				if (!isset($value_1[0])) {
					$errors[] =  $value_1;
				}
				// $lookup_array_3[$temp_value] = htmlspecialchars_decode($value_1[0]);
				$lookup_array_3[$temp_value] = $value_1[0];
				// foreach ($value_1 as $key_2 => $value_2) {
				// 	// $array_3[$key_1][$array_2[0][$key_2]."; type:".$array_2[1][$key_2]] = $value_2;
				// 	// $lookup_array_3[$key_1][$lookup_array_2[0][$key_2]]["export_value"] = $value_2;
				// 	// $lookup_array_3[$key_1][$lookup_array_2[0][$key_2]]["type"] = $lookup_array_2[1][$key_2];
				//
				// 	$lookup_array_3[$key_1][$lookup_array_2[0][$key_2]] = trim(preg_replace('/\t+/', '', $value_2));
				// 	// $array_3[$key_1][$key_2] = $array[0];
				// }
			}
		}
		$lookup[$key] = $lookup_array_3;

	}
}
//
// header('Content-Type: application/json');
// echo json_encode($lookup, JSON_PRETTY_PRINT);
// exit;

foreach ($array_3 as $key => $value) {
  ob_start();
  ?>

  <item>
		<?php
		foreach ($value as $key_2 => $value_2) {
			if ($value_2["type"] == "simple_string") {
				if ($key_2 == "title") {
					?>
					<title><?php echo $value_2["export_value"] ?></title>
					<?php
				}
				elseif ($key_2 == "wp:post_type") {
					?>
          <wp:post_type><![CDATA[projects]]></wp:post_type>
					<?php
				}
				elseif ($key_2 == "content:encoded") {
					?>
          <content:encoded><![CDATA[...]]></content:encoded>
					<?php
				}
				elseif ($key_2 == "wp:status") {
					?>
          <wp:status><![CDATA[publish]]></wp:status>
					<?php
				}
				else {
					?>
					<<?php echo $key_2 ?>><![CDATA[<?php echo $value_2["export_value"] ?>]]></<?php echo $key_2 ?>>
					<?php
				}
			}
			elseif ($value_2["type"] == "simple_multilookup") {



				foreach ($value_2["export_value"] as $key_3 => $value_3) {

					if ( !in_array($value_3, array('NA','Waiting on Jacques', 'needs editing', ''), true ) ) {
						if (strlen($value_3) > 50) {
							$value_3 = substr($value_3, 0, 50)."...";
						}


						if (isset($lookup[$key_2][$value_3])) {
							$value_3 = $lookup[$key_2][$value_3];
							// code...
						} else {
							echo "string"."lookup[$key_2][". $value_3."zzz";
							// exit;
						}
					} else {
						$value_3 = '';
					}

					$value_3 = json_decode($value_3);

					?>
					<category domain="<?php echo $key_2 ?>" nicename="<?php echo slugify($value_3) ?>"><![CDATA[<?php echo $value_3 ?>]]></category>
					<?php
				}
			}
			elseif ($value_2["type"] == "semiadvanced_string" OR $value_2["type"] == "semiadvanced_lookup") {


				if ($value_2["type"] == "semiadvanced_lookup") {

					if ( !in_array($value_2["export_value"], array('NA','Waiting on Jacques', 'needs editing', ''), true ) ) {
						if (strlen($value_2["export_value"]) > 50) {
							$value_2["export_value"] = substr($value_2["export_value"], 0, 50)."...";
						}


						if (isset($lookup[$key_2][$value_2["export_value"]])) {
							$value_2["export_value"] = $lookup[$key_2][$value_2["export_value"]];
							// code...
						} else {
							echo "string"."lookup[$key_2][". $value_2["export_value"]."zzz";
							// exit;
						}
					} else {
						$value_2["export_value"] = '';
					}

				}
				?>
				<wp:postmeta>
					<wp:meta_key><![CDATA[<?php echo $key_2 ?>]]></wp:meta_key>
					<wp:meta_value><![CDATA[<?php echo $value_2["export_value"]; ?>]]></wp:meta_value>
				</wp:postmeta>
				<?php
			}
			elseif ($value_2["type"] == "advanced_string" OR $value_2["type"] == "advanced_lookup") {
				$temp_value = explode("; code:",$key_2);



				if ($value_2["type"] == "advanced_lookup") {

					if ( !in_array($value_2["export_value"], array(''), true ) ) {
						// if (strlen($value_2["export_value"]) > 50) {
						// 	$value_2["export_value"] = substr($value_2["export_value"], 0, 50)."...";
						// }


						if (isset($lookup[$temp_value[0]][$value_2["export_value"]])) {
							$value_2["export_value"] = $lookup[$temp_value[0]][$value_2["export_value"]];
							// code...
						} else {
							// $errors[] = $temp_value[0]." -- ".$value_2["export_value"];
							// echo "Error (".$value_2["export_value"].")";
							// exit;
						}
					} else {
						$value_2["export_value"] = '';
					}

				}

				?>
				<wp:postmeta>
					<wp:meta_key><![CDATA[<?php echo $temp_value[0]; ?>]]></wp:meta_key>
					<wp:meta_value><![CDATA[<?php echo $value_2["export_value"] ?>]]></wp:meta_value>
				</wp:postmeta>
        <wp:postmeta>
          <wp:meta_key><![CDATA[_<?php echo $temp_value[0] ?>]]></wp:meta_key>
          <wp:meta_value><![CDATA[<?php echo $temp_value[1] ?>]]></wp:meta_value>
        </wp:postmeta>
				<?php
			}
			elseif ($value_2["type"] == "advanced_multilookup") {
				$temp_value = explode("; code:",$key_2);
				?>
				<wp:postmeta>
					<wp:meta_key><![CDATA[<?php echo $temp_value[0]; ?>]]></wp:meta_key>
					<wp:meta_value><![CDATA[<?php echo $value_2["export_value"] ?>]]></wp:meta_value>
				</wp:postmeta>
        <wp:postmeta>
          <wp:meta_key><![CDATA[_<?php echo $temp_value[0] ?>]]></wp:meta_key>
          <wp:meta_value><![CDATA[<?php echo $temp_value[1] ?>]]></wp:meta_value>
        </wp:postmeta>
				<?php
			}
			?>

			<?php
		}


    ?>

  </item>

  <?php
  $data["body"][] = ob_get_contents();
  ob_end_clean();
}
$data["body"] = implode($data["body"]);

if (!empty($errors)) {
	// code...
	header('Content-Type: application/json');
	echo json_encode($errors, JSON_PRETTY_PRINT);
	exit;
}

ob_start();
?>
<?xml version="1.0" encoding="UTF-8" ?>
<!-- This is a WordPress eXtended RSS file generated by WordPress as an export of your site. -->
<!-- It contains information about your site's posts, pages, comments, categories, and other content. -->
<!-- You may use this file to transfer that content from one site to another. -->
<!-- This file is not intended to serve as a complete backup of your site. -->

<!-- To import this information into a WordPress site follow these steps: -->
<!-- 1. Log in to that site as an administrator. -->
<!-- 2. Go to Tools: Import in the WordPress admin panel. -->
<!-- 3. Install the "WordPress" importer from the list. -->
<!-- 4. Activate & Run Importer. -->
<!-- 5. Upload this file using the form provided on that page. -->
<!-- 6. You will first be asked to map the authors in this export file to users -->
<!--    on the site. For each author, you may choose to map to an -->
<!--    existing user on the site or to create a new user. -->
<!-- 7. WordPress will then import each of the posts, pages, comments, categories, etc. -->
<!--    contained in this file into your site. -->

<!-- generator="WordPress/5.5.3" created="2020-12-21 11:31" -->
<rss version="2.0"
xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
xmlns:content="http://purl.org/rss/1.0/modules/content/"
xmlns:wfw="http://wellformedweb.org/CommentAPI/"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:wp="http://wordpress.org/export/1.2/"
>

<channel>
	<title>Entelect</title>
	<link>http://enttest.cstm.co.za</link>
	<description>Everything is possible</description>
	<pubDate>Mon, 21 Dec 2020 11:31:39 +0000</pubDate>
	<language>en-US</language>
	<wp:wxr_version>1.2</wp:wxr_version>
	<wp:base_site_url>http://enttest.cstm.co.za</wp:base_site_url>
	<wp:base_blog_url>http://enttest.cstm.co.za</wp:base_blog_url>

	<wp:author><wp:author_id>1</wp:author_id><wp:author_login><![CDATA[khabm]]></wp:author_login><wp:author_email><![CDATA[info@onecustom.co.za]]></wp:author_email><wp:author_display_name><![CDATA[khabm]]></wp:author_display_name><wp:author_first_name><![CDATA[]]></wp:author_first_name><wp:author_last_name><![CDATA[]]></wp:author_last_name></wp:author>
	<wp:author><wp:author_id>4</wp:author_id><wp:author_login><![CDATA[ivan]]></wp:author_login><wp:author_email><![CDATA[ivan@onecustom.co.za]]></wp:author_email><wp:author_display_name><![CDATA[Ivan Copeland]]></wp:author_display_name><wp:author_first_name><![CDATA[Ivan]]></wp:author_first_name><wp:author_last_name><![CDATA[Copeland]]></wp:author_last_name></wp:author>


	<generator>https://wordpress.org/?v=5.5.3</generator>

<?php
$data["header"] = ob_get_contents();
ob_end_clean();


ob_start();
?>

</channel>
</rss>

<?php
$data["footer"] = ob_get_contents();
ob_end_clean();



$data["body"]= str_replace("_linebreak_", "<br />", $data["body"]);


?>
<?php// header("Content-type: text/xml"); ?>
<h1>Step 2</h1>
<div class="">

	<h2>whats happening</h2>
	<p>
		This step
		<br>-replaces lookup field names with ids
		<br>-turns the table data into xml data that wordpress can import
	</p>
	<h2>what do i do</h2>
	<p>
		-this uses data from "content/step_2.html"
		<br>-please copy this into "content/step_3.html" for safe keeping but more important import into wordpress
	</p>
</div>
<textarea name="name" rows="8" cols="80">
	<?php echo $data["header"] . $data["body"] . $data["footer"]; ?>

</textarea>
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


function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

?>
<?php
