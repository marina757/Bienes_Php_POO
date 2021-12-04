<?php

    require 'includes/config/database.php';
    $db = conectarDB();

    //AUTENTICAR EL USUARIO

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $email = mysqli_real_escape_string($db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
        // var_dump($email);
        $password = mysqli_real_escape_string($db, $_POST['password'] );

        if(!$email) {
            $errores[] = "El email es obligatorio o no es valido";
        }

        if(!$password) {
            $errores[] = "El password es obligatorio";
        }  
        
        if(empty($errores)) {
            
            //REVISAR SI USUARIO EXISTE
            $query = "SELECT * FROM usuarios WHERE email = '${email}' ";
            $resultado = mysqli_query($db, $query);
            

            if ($resultado->num_rows) {
                //Revisar si password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                // var_dump($usuario['password']);
                //VERIFICAR SI PASSWORD ES CORRECTO O NO

                $auth = password_verify($password, $usuario['password']); 
                
                if ($auth) {
                   //EL USUARIO ESTA AUTENTICADO
                   session_start();

                   //LLENAR EL ARREGLO DE LA SESION
                   $_SESSION['usuario'] = $usuario['email'];
                   $_SESSION['login'] = true;

                   header('Location: /admin');
  

                }else {
                    $errores[] = "El password es incorrecto";
                }
            }else {
                $errores[] = "El usuario no existe";
            }
        }
    }


    //INCLUYE EL HEADER
    require 'includes/funciones.php'; //sirve para funciones    
    incluirTemplate('header'); 
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesion</h1>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario" novalidate>
            <fieldset><!--fieldset se pone cuando se agrupan campos relacionados-->
                <legend>Email y Password</legend><!--legend explica lo que es el fieldset-->

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email">

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" id="password">
            </fieldset>

            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');  
?>    