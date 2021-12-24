<?php

    require '../../includes/app.php'; 

    use App\Vendedor;

    estaAutenticado();

    $vendedor = new Vendedor;

    //ARREGLO CON MENSAJES DE ERRORES
    $errores = Vendedor::getErrores();
    // debuguear($errores);

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

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