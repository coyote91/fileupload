<?php
/**
* @Project Transcarga
* @copyright (c) 2016
* @author David Fernando Ramirez Gonzalez <david.f.r91@hotmail.com>
* @license GNU-GPL  http://www.gnu.org/licenses/ http://es.wikipedia.org/wiki/GNU_General_Public_License
* @since Version 2.0
*/

define('ALL_ROWS', 0);
define('FIRST_ROW_ONLY', 1);
define('ROWS_ONLY', 1);
define('FIELDS_ONLY', 3);
define('DATA_ONLY', 0);
define('DATA_AND_ROWS', 2);
define('FETCH_ASSOC', 'mysqli_fetch_assoc');
define('FETCH_ARRAY', 'mysqli_fetch_array');

$opciones = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
	$conexion = new PDO('mysql:host=localhost;dbname=transcarga', 'root','',$opciones );
  //$conexion = new PDO('mysql:host=localhost;dbname=id982014_transcarga', 'id982014_root','prueba',$opciones );
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);



  function database_query($sql, $return_type = DATA_ONLY, $first_row_only = ALL_ROWS, $fetch_func = PDO::FETCH_ASSOC, $debug=false)
  {
  global $conexion;
  /*
  define('ALL_ROWS', 0);
  define('FIRST_ROW_ONLY', 1);
  define('ROWS_ONLY', 1);
  define('FIELDS_ONLY', 3);
  */
  /* RETURN TYPE:
  define('DATA_ONLY', 0);
  define('DATA_AND_ROWS', 2);
    *
    *
  */

  $data_array = array();
  $num_rows = 0;
  $fields_len = 0;
  /*if($fetch_func == 'mysqli_fetch_assoc') $fetch_func = PDO::FETCH_ASSOC;
  else if($fetch_func == 'mysqli_fetch_array') $fetch_func = PDO::FETCH_BOTH;*/
  $sth = $conexion->query($sql);

  if($sth){
   if($return_type == 0 || $return_type == 2){
     while($row_array = $sth->fetch($fetch_func)){
       if(!$first_row_only){
         array_push($data_array, $row_array);
       }else{
         $data_array = $row_array;
         break;
       }
     }
   }

   $num_rows = $sth->rowCount();
   $fields_len = $sth->columnCount();
  }
  $sth = null;
  switch($return_type){
   case DATA_ONLY:
     return $data_array;
   case ROWS_ONLY:
     return $num_rows;
   case DATA_AND_ROWS:
     return array($data_array, $num_rows);
   case FIELDS_ONLY:
     return $fields_len;
  }


  }




?>
