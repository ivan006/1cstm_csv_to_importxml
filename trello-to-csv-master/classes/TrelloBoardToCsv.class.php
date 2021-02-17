<?php
/**
 * @file Provides the class that takes a trello json file and outputs a csv file.
 */

class TrelloBoardToCsv {
  public $filename = '';
  public $json = '';
  public $csv = '';
  public $list = '';

  /**
   * Constructor
   * Checks that the input file exists and kicks off the sequence.
   */
  function __construct($filename, $list = '') {
    if (file_exists($filename)) {
      $this->list = $list;
      $this->filename = $filename;
      $this->file_to_json();
      $this->json_to_csv();
      $this->save_csv();
    }
    else {
      throw new Exception('File does not exist.');
    }
  }

  /**
   * Read in the file and decodes the json.
   */
  function file_to_json() {
    $file = file_get_contents($this->filename);
    if ($file === FALSE) {
      throw new Exception('Could not read file.');
    }
    $decoded = json_decode($file);
    if ($decoded === NULL) {
      throw new Exception('Could not decode the JSON.');
    }
    $this->json = $decoded;
  }

  /**
   * Takes the decoded json and saves the interesting data.
   */
  function json_to_csv() {
    $output = '';
    $output .= '"' . $this->json->name . '"' . "\n";

    foreach ($this->json->lists as $i => $list) {
      $print_list = FALSE;

      /**
       * Test if we should display this list.
       * Only print open lists,
       * And if the list title argument is not empty, only print lists that contain
       * that string.
       */
      if ($list->closed == FALSE) {
        $print_list = TRUE;

        if ($this->list != '') {
          if (strpos($list->name, $this->list) === FALSE) {
            $print_list = FALSE;
          }
        }
      }

      if ($print_list) {
        $output .= "<h1>".$list->name."</h1>";
        $output .= "<table>";

        foreach ($this->json->cards as $j => $card) {
          if ($card->closed == FALSE && $card->idList == $list->id) {
            $output .= "<tr>";

            if ("name" == "name") {
              // $output .= "<td>";
              // $output .= $card->name;
              // $output .= "</td>";

              $haystack = "<td>".$card->name."</td>";

              $needle = "/<td>(.*?) (.*?)<\/td>/s";
              $matches = array();
              if (preg_match($needle,$haystack, $matches)) {

                // 5.31	 and 31 had problems
                $output .= "<td>";
                $output .= $matches[1]."_this_is_a_string";
                $output .= "</td>";
              } else {
                $output .= "<td>";
                $output .= "";
                $output .= "</td>";
              }

            }

            if ("Desc" == "Desc") {

              $haystack = "<td>".preg_replace( "/\r|\n/", "", $card->desc)."</td>";

              $needle = "/<td>\*\*someone\*\* created a new Feedback \(#(.*?)\) on \*\*(.*?)\*\*>(.*)\*\*Session details:\*\*\- Feedback ID: (.*?)<\/td>/s";
              $matches = array();
              if (preg_match($needle,$haystack, $matches)) {

                // preg_match('/<td>\*\*someone\*\* created a new Feedback \(#\) on \*\*(.*?)\*\*>(.*)\*\*Session details:\*\*\- Feedback ID: <\/td>/s',$haystack, $matches);
                // preg_match('/<td>\*\*someone\*\* created a new Feedback \(#\) on \*\*(.*?)\*\*>(.*)\*\*Session details:\*\*\- Feedback ID: <\/td>/s',$haystack, $matches);
                // preg_match('/<td>\*\*someone\*\* created a new Feedback (#(.*?)) on \*\*(.*?)\*\*>(.*?)\*\*Session details:\*\*- Feedback ID: (.*?)<\/td>/s',$haystack, $matches);
                // preg_match('/<div class="my-con">(.*?)<\/div>/s', $htmlContent, $match);



                $output .= "<td>";
                $output .= $matches[2];
                $output .= "</td>";

                $output .= "<td>";
                $output .= $matches[3];
                // $output .= $haystack;
                $output .= "</td>";
                // print_r($matches[1]);
              } else {
                $output .= "<td>";
                $output .= "";
                $output .= "</td>";
                
                $output .= $haystack;
                // print_r($matches[1]);
              }
            }

            $output .= "</tr>\n";
          }
        } // end card foreach

        $output .= "</table>";
      }
    } // end list foreach

    $this->csv = $output;
  }

  /**
   * Creates the CSV file
   */
  function save_csv() {
    $result = file_put_contents($this->filename . '.html', $this->csv);
    if ($result === FALSE) {
      throw new Exception('Could not write the file.');
    }
  }

}
