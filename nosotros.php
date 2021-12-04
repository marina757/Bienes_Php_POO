<?php
    require 'includes/funciones.php'; //sirve para funciones    
    incluirTemplate('header'); 
?>

    <main class="contenedor seccion"> <!--cntenido principal-->
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 años de experiencia
                </blockquote>

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
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Mas Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque eveniet minima vel rem quod aut
                   illum. Sed rerum amet eligendi harum odio. Unde dolorem error, nostrum quam minima nulla cum.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque eveniet minima vel rem quod aut
                   illum. Sed rerum amet eligendi harum odio. Unde dolorem error, nostrum quam minima nulla cum.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
                <h3>A tiempo</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque eveniet minima vel rem quod aut
                   illum. Sed rerum amet eligendi harum odio. Unde dolorem error, nostrum quam minima nulla cum.</p>
            </div>
        </div>
    </section>

<?php
    incluirTemplate('footer');   
?>    