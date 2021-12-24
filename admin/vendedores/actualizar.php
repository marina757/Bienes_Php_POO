<?php

    require '../../includes/app.php'; 
    use App\Vendedor;
    estaAutenticado();

    //Validar que sea un Id valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    //Obtener el arreglo del vendedor
    $vendedor = Vendedor::find($id);
    //debuguear($vendedor);

    //ARREGLO CON MENSAJES DE ERRORES
    $errores = Vendedor::getErrores();
    // debuguear($errores);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //asignar valores
        $args = $_POST['vendedor'];
      
        //sincronizar objeto en memoria
        $vendedor->sincronizar($args);

        //validacion
        $errores = $vendedor->validar();
        if (empty($errores)) {
            $vendedor->guardar();
        }
        
    }

    incluirTemplate('header'); 

    ?>

<main class="contenedor seccion">
        <h1>Actualizar Vendedor</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>            
        <?php endforeach; ?>

        <form class="formulario" method="POST">
           <?php include '../../includes/templates/formulario_vendedores.php'; ?> 

            <input type="submit" value="Guardar cambios" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');  
?>    