<?php
    require 'includes/funciones.php'; //sirve para funciones    
    incluirTemplate('header'); 
?>

    <main class="contenedor seccion">
        <h2>Casas y mini apartamentos en Venta</h2>

    <?php        
        $limite = 10;
        include 'includes/templates/anuncios.php';
    ?>
    </main>

<?php
    incluirTemplate('footer');   
?>   