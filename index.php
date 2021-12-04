<?php
    require 'includes/funciones.php'; //sirve para funciones    
    incluirTemplate('header', $inicio = true); 
?>

    <main class="contenedor seccion">
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
    </main>

    <section class="seccion contenedor">
        <h2>Casas y mini apartamentos en Venta</h2>

        <?php
            $limite = 3;
            include 'includes/templates/anuncios.php';
        ?>

        <div class="alinear-derecha">
            <a href="anuncios.php" class="boton-verde">Ver Todas</a>
        </div>
    </section>

    <section class="imagen-contacto">
        <h2>Encuentra la casa que deseas.</h2>
        <p>LLena el formulario de contacto y un asesor se pondra en contacto contigo</p>
        <a href="contacto.php" class="boton-amarillo">Contactanos</a>
    </section>

    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset=" build/img/blog1.webp" type="image/webp">
                        <source srcset=" build/img/blog1.jpg" type="image/jpeg"> 
                        <img loading="lazy" src="build/img/blog1.jpg" alt="Texto entrada blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada.php">
                        <h4>Terraza en el techo de tu casa</h4>
                        <p class="informacion-meta">Escrito el: <span>27/11/2021</span> por: <span>Admin</span></p>

                        <p>
                            Consejos para construir una terraza en el techo de tu casa 
                            y ahorrando dinero
                        </p>
                    </a>
                </div>
            </article>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset=" build/img/blog2.webp" type="image/webp">
                        <source srcset=" build/img/blog2.jpg" type="image/jpeg"> 
                        <img loading="lazy" src="build/img/blog2.jpg" alt="Texto entrada blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada.php">
                        <h4>Guia para la decoracion de tu casa</h4>
                        <p class="informacion-meta">Escrito el: <span>27/11/2021</span> por: <span>Admin</span></p>

                        <p>
                           Aprende a combinar muebles y a aprovechar el espacio de tu
                           casa con unos simples consejos
                        </p>
                    </a>
                </div>
            </article>
        </section>

        <section class="testimoniales">
            <h3>Testimoniales</h3>

            <div class="testimonial">
                    <blockquote>
                        El personal fue muy amable y la casa que me ofrecieron es 
                        la que siempre habia querido.
                    </blockquote>
                    <p>- Marisol Hernandez</p>
            </div>

        </section>
    </div>
    
<?php
    incluirTemplate('footer');   
?>