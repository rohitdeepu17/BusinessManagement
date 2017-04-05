<?php
class dateTranslator {

 public static function translate($date, $lang) {
      $divider = '';

      if (empty($date)){
           return null;   
      }
      if (strpos($date, '-') !== false) {
           $divider = '-';
      } else if (strpos($date, '/') !== false) {
           $divider = '/';
      }
      //spanish format DD/MM/YYYY hh:mm
      if (strcmp($lang, 'es') == 0) {

           $type = explode($divider, $date)[0];
           if (strlen($type) == 4) {
           	
                $date = self::reverseDate($date,$divider);
           } 
           if (strcmp($divider, '-') == 0) {
                $date = str_replace("-", "/", $date);
           }
      //english format YYYY-MM-DD hh:mm
      } else {

           $type = explode($divider, $date)[0];
           if (strlen($type) == 2) {

                $date = self::reverseDate($date,$divider);
           } 
           if (strcmp($divider, '/') == 0) {
                $date = str_replace("/", "-", $date);

           }   
      }
      return $date;
 }

 public static function reverseDate($date) {
      $date2 = explode(' ', $date);
      if (count($date2) == 2) {
           $date = implode("-", array_reverse(preg_split("/\D/", $date2[0]))) . ' ' . $date2[1];
      } else {
           $date = implode("-", array_reverse(preg_split("/\D/", $date)));
      }

      return $date;
 }
}

echo dateTranslator::translate("2017-04-02", "en");

// Create a new DateTime object
$date = DateTime::createFromFormat('Y-m-d', '2016-03-25');

// Output the date in a different format
echo $date->format('d-m-Y');

?>

