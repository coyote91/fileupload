<?php
include './conexion.php';
/***********************/
/*
$_FILES['imagen']['name']; //este es el nombre del archivo que acabas de subir
$_FILES['imagen']['type']; //este es el tipo de archivo que acabas de subir
$_FILES['imagen']['tmp_name'];//este es donde esta almacenado el archivo que acabas de subir.
$_FILES['imagen']['size']; //este es el tamaño en bytes que tiene el archivo que acabas de subir.
$_FILES['imagen']['error']; //este almacena el codigo de error que resultaría en la subida.
//imagen es el nombre del input tipo file del formulario.*/

//comprobamos si ha ocurrido un error.
if ($_FILES["imagen"]["error"] > 0){
  echo "ha ocurrido un error";
} else {
  //ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
  //y que el tamano del archivo no exceda los 100kb
  $permitidos = array("image/jpg", "image/jpeg", "image/png");
  $limite_kb = 4000;

  if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024)
  {
    //esta es la ruta donde copiaremos la imagen
    //recuerden que deben crear un directorio con este mismo nombre
    //en el mismo lugar donde se encuentra el archivo subir.php
      $prefijo = substr(md5(uniqid(rand())),0,6);

      $nombreimagen = $_FILES['imagen']['name'];
      $rutatemporal = $_FILES ['imagen']['tmp_name'];
      $rutaenservidor = 'imagenes';

    $rutadestino = $rutaenservidor. "/" .$prefijo."_".$nombreimagen;
    //comprovamos si este archivo existe para no volverlo a copiar.
    //pero si quieren pueden obviar esto si no es necesario.
    //o pueden darle otro nombre para que no sobreescriba el actual.
    if (!file_exists($rutadestino))
    {
      //aqui movemos el archivo desde la ruta temporal a nuestra ruta
      //usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
      //almacenara true o false
            $resultado = @move_uploaded_file($rutatemporal, $rutadestino);

            $numeroenvio = 38383;
            $id_usuario = 2 ;

            $sqls = "INSERT INTO fotografiasdecargas( fotocarga,
                                                      numero_envio,
                                                      id_usuario
                                                    )

                                                    VALUES('".$rutadestino."',
                                                            '".$numeroenvio."',
                                                            '".$id_usuario."'
                                                           )


                                                                    ";

             $query = $conexion->query($sqls);

                   if($query)
                   {
                       echo 'Insercion con exito <br />';
                   }

                   else
                   {
                        echo 'No se pudo insertar <br />';
                   }

       if ($resultado)
	     {
            echo "el archivo ha sido movido exitosamente";

        }
	       else {
                  echo "ocurrio un error al mover el archivo.";
              }
    }
    else {
              echo $nombreimagen . ", este archivo existe";
          }
  } else {
    echo "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
  }
}


?>
