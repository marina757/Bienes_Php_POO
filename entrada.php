<?php
    require 'includes/funciones.php'; //sirve para funciones    
    incluirTemplate('header'); 
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Guia para la decoracion de tu hogar</h1>

        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada2.jpg" alt="imagen de la propiedad">
        </picture>

        <p class="informacion-meta">Escrito el: <span>28/11/2021</span>por: <span>Admin</span></p>

        <div class="resumen-propiedad">            
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, expedita provident sint ex quo
                adipisci ut perspiciatis cum dicta, consequuntur atque quisquam blanditiis rerum repellendus
                cupiditate suscipit odit aut corporis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, expedita provident sint ex quo
                adipisci ut perspiciatis cum dicta, consequuntur atque quisquam blanditiis rerum repellendus
                cupiditate suscipit odit aut corporis.
            </p>

            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, expedita provident sint ex quo
                adipisci ut perspiciatis cum dicta, consequuntur atque quisquam blanditiis rerum repellendus
                cupiditate suscipit odit aut corporis.
            </p>
        </div>
    </main>

<?php
    incluirTemplate('footer');   
?>    