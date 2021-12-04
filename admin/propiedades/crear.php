<?php

    require '../../includes/funciones.php'; //sirve para funciones 
    $auth = estaAutenticado();

    if(!$auth) {
        header('Location: /');
    }
    //BASE DE DATOS
    require '../../includes/config/database.php';
    $db = conectarDB();
    
    //CONSULTAR PARA OBTENER LOS VENDEDORES
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);
    
    
    // var_dump($db);

    // echo "<pre>";
    // var_dump($_SERVER); //Contiene info del servidor
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    //ARREGLO CON MENSAJES DE ERRORES
    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc ='';
    $estacionamiento = '';
    $vendedorId = '';
    $creado = date('Y/m/d');

    //EJECUTA CODIGO DESPUES DE QUE USUARIO ENVIA FORMULARIO
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //  echo "<pre>";
        //  var_dump($_POST); //nos trae inf cuando mandamos peticion post en form
        //  echo "</pre>";

        //  echo "<pre>";
        //  var_dump($_FILES); //permite ver contenido de archivos
        //  echo "</pre>";

        //  exit;

        $titulo = mysqli_real_escape_string( $db, $_POST['titulo']);
        $precio = mysqli_real_escape_string( $db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string( $db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento']);
        $vendedorId = mysqli_real_escape_string( $db, $_POST['vendedor']);
        $creado = date('Y/m/d');

        //ASIGNAR FILES HACIA UNA VARIABLE
        $imagen = $_FILES['imagen'];
        

        if (!$titulo) {
            $errores[] = "Debes poner un titulo";
        }

        if (!$precio) {
            $errores[] = "El precio es obligatorio";
        }

        if ( strlen( $descripcion ) < 50 ) {
            $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }

        if (!$habitaciones) {
            $errores[] = "El numero de habitaciones es obligatorio";
        }

        if (!$wc) {
            $errores[] = "El numero de wc es obligatorio";
        }

        if (!$estacionamiento) {
            $errores[] = "El numero de lugares de estableciemiento es obligatorio";
        }

        if (!$vendedorId) {
            $errores[] = "Elige un vendedor";
        }

        if (!$imagen['name'] || $imagen['error']) {
            $errores[] = "la imagen es obligatoria";
        }

        //VALIDAR POR TAMANO 1mb MAXIMO
        $medida = 1000 * 1000; //lo convierte de bytes a kb

        if ($imagen['size'] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";
        
        // exit;

        //REVISAR QUE ARRAY DE ERRORES ESTE VACIO
        if (empty($errores)) {
            //SUBIDA DE ARCHIVOS

            //CREAR CARPETA
            $carpetaImagenes = '../../imagenes/';

            if (!is_dir($carpetaImagenes)) { //is_dir nos retorna si carpeta existe o no existe   
                mkdir($carpetaImagenes);
            }

            //GENERAR UN NOMBRE UNICO
            $nombreImagen = md5( uniqid( rand(), true ) ). ".jpg";


            //SUBIR IMAGEN
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            // exit;
            
            //INSERTAR EN BASE DE DATOS
            $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion,
            habitaciones, wc, estacionamiento, creado, vendedorId ) VALUES ( '$titulo',
            '$precio', '$nombreImagen','$descripcion','$habitaciones','$wc','$estacionamiento', '$creado',
            '$vendedorId' ) ";

            // echo $query;

            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                //REDIRECCIONAR AL USUARIO

                header('Location: /admin?resultado=1'); //header sirve pare redireccionar a un usuario,
                                            // para enviar datos por enmedio del encabezado 
                                            //de un stio web, de la peticion
            }    
        }
    }

       
    incluirTemplate('header'); 
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>            
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="descripcion">Descripcion:</label> 
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Banos:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor">
                    <option value="">-- Seleccione --</option>
                    <?php while ($vendedor = mysqli_fetch_assoc($resultado) ):  ?>
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?>  value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php endwhile; ?>
                    
                    
                    <!-- EJEMPLO PARA POCOS VENDEDORES
                    <option value="1">Marina</option>
                    <option value="2">Karen</option>
                     -->
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">

        </form>
    </main>

<?php
    incluirTemplate('footer');  
?>    