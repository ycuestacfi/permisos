<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../controller/solicitudController.php';
$solocitudcontroller = new SolicitudController();
if (!isset($_SESSION['correo']) || !isset($_SESSION['rol'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /solicitud_de_permisos_laborales/app/views/login.php ");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo de Estructura HTML5</title>
    <!-- iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="/solicitud_de_permisos_laborales/app/assets/css/style.css">
</head>
<body>
<!-- <header>
        <h1>Título de la Página</h1>
        <nav>
            <ul>
                <li><a href="#home" style="color: white;">Inicio</a></li>
                <li><a href="#about" style="color: white;">Acerca de</a></li>
                <li><a href="#services" style="color: white;">Servicios</a></li>
                <li><a href="#contact" style="color: white;">Contacto</a></li>
            </ul>
        </nav>
    </header> -->
    
    <main>
    <section id="navigation">
    <nav>
        <figure style="margin:0; padding:0; width:150px;">
            <a href="dashboard.php"><img src="/solicitud_de_permisos_laborales/app/assets/img/logocfipblanco.png" style="width: 100%;" alt=""></a>
        </figure>
        <div id="btn_menu">
            <div></div>
            <div></div>
            <div></div>
        </div>
     
        <ul id="menu">
            <li><a href="dashboard.php">Inicio</a></li>
            <li><a href="solicitudes.php">Mis solicitudes</a></li>
            <li><a href="solicitud_de_permisos.php">Nueva solicitud</a></li>
            <li><a href="rechazadas.php">Rechazadas</a></li>
           
        </ul>
        <ul id="contenedor_btn_salir">
        <li><a   href="/solicitud_de_permisos_laborales/cierre_de_sesion.php" id="btn_salir">Cerrar sesión </a></li>
        </ul>
    </nav>
    
</section>
        <section id="fondo-form" >
            <a id="Bienvenidos" >
                <?php echo 'Bienvenido '. $_SESSION['nombres']  ." ". $_SESSION['apellidos'] ; ?>
            </a> 
            <form action="" method="POST" id="formulario-solicitud" >     
                <h1 id="title_form">Formulario De Solicitud</h1>

                <input class="input_solicitud" 
                    placeholder="Ejemplo: Juan Pérez" 
                    value="<?php echo $_SESSION['nombres'] ,' ', $_SESSION['apellidos']; ?>" 
                    type="text" name="nombre" id="nombre" 
                    title="Rellene el campo con su Nombre y Apellido"  
                    pattern="[A-Za-z\s]{2,}" minlength="2" required>

                <input class="input_solicitud" 
                    type="email" id="correo" 
                    value="<?php echo $_SESSION['correo']; ?>" 
                    name="email" 
                    placeholder="Introduce tu correo electrónico" 
                    title="Introduce un correo electrónico válido" 
                    required readonly> 

                <input class="input_solicitud" 
                type="hidden" id="cedula" 
                value="<?php echo $_SESSION['cedula']; ?>" 
                name="cedula" 
                required>    

                <input type="text" name="departamento" id="departamento" 
                    value="<?php echo $_SESSION['id_departamento']; ?>" 
                    required readonly hidden />

                <input class="input_solicitud" 
                    placeholder="Selecciona la fecha de solicitud" 
                    type="date" id="fecha_de_solicitud" 
                    name="fecha_de_solicitud" 
                    title="Selecciona la fecha en que estás realizando la solicitud" 
                    required >

                <input class="input_solicitud" 
                    placeholder="Selecciona la fecha del permiso" 
                    type="date" id="fecha_de_permiso" 
                    name="fecha_de_permiso" 
                    title="Selecciona la fecha del permiso solicitado" 
                    required>

                <input class="input_solicitud" 
                    placeholder="Ejemplo: 09:00" 
                    type="time" id="hora_de_salida" 
                    name="hora_de_salida" 
                    title="Indica la hora de salida" 
                    required>

                <input class="input_solicitud" 
                    placeholder="Ejemplo: 17:00" 
                    type="time" id="hora_de_llegada" 
                    name="hora_de_llegada" 
                    title="Indica la hora de llegada" 
                    required>

                <textarea class="input_solicitud" 
                        placeholder="Agrega observaciones adicionales aquí" 
                        name="observaciones" id="observaciones" 
                        title="Escribe cualquier observación relevante" 
                        required></textarea>

                <label for="evidencias" id="label_file"> 
                    <i class="lni lni-file-plus-circle"></i>
                    ¿Deseas cargar una evidencia? 
                </label>
                <input type="file" hidden name="evidencias" class="input_solicitud" 
                    id="evidencias" 
                    title="Solo se permiten archivos PDF o imágenes (JPEG, PNG, GIF).">

                <div id="contenedor-permiso" class="contenedor-permiso">
                    <div id="selected-option" class="selected-option">Seleccione un tipo de permiso</div>
                    <ul id="select-options" class="select-options">
                        <li data-value="personal">Personal</li>
                        <li data-value="cita medica">Cita Médica</li>
                        <li data-value="calamidad domestica">Calamidad Doméstica</li>
                        <li data-value="estudio">Estudio</li>
                        <li data-value="laboral">Laboral</li>
                    </ul>
                    <input type="hidden" name="tipo_permiso" id="tipo_permiso" />
                </div>
                <button type="submit" id="btn-enviar-permiso">Enviar solicitud</button>

                 <div id="permiso-laboral" class="permiso-laboral">
                    <input class="input_solicitud" 
                        type="text" name="motivo_del_desplamiento" 
                        required id="motivo_del_desplazamiento" 
                        placeholder="¿Cuál es el motivo de tu salida?" 
                        title="Indica el motivo de tu salida">

                    <input class="input_solicitud" 
                        type="text" name="departamento_de_desplazamiento" 
                        required id="Departamento_de_desplazamiento" 
                        placeholder="¿Cuál es tu departamento de destino?" 
                        title="Indica tu departamento de destino">


                        <!-- // lista de departamentos 
                        Amazonas
                        Antioquía
                        Arauca
                        Atlántico
                        Bolívar
                        Boyacá
                        Caldas
                        Caquetá
                        Casanare
                        Cauca
                        Cesar
                        Chocó
                        Córdoba
                        Cundinamarca
                        Guainía
                        Guaviare
                        Huila
                        La Guajira
                        Magdalena
                        Meta
                        Nariño
                        Norte de Santander
                        Putumayo
                        Quindío
                        Risaralda
                        San Andrés y Providencia
                        Santander
                        Sucre
                        Tolima
                        Valle del Cauca
                        Vaupés
                        Vichada
                        Bogotá D.C.
                        usar https://api-colombia.com/swagger/index.html para consumir api de departamentos y municipios
 -->

                    <input type="text" class="input_solicitud" 
                        placeholder="¿A qué municipio te diriges?" 
                        id="municipio_del_desplazamiento" 
                        required name="municipio_del_desplazamiento" 
                        title="Indica el municipio al que te diriges">

                    <input type="text" class="input_solicitud" 
                        placeholder="¿Cuál es tu lugar de desplazamiento?" 
                        required id="lugar_desplazamiento" 
                        name="lugar_desplazamiento" 
                        title="Indica el lugar al que te desplazas"> 

                    <!-- Select de Medio de Transporte -->
                 <div id="medio-transporte-contenedor" class="contenedor-permiso">
                    <div id="medio-transporte-seleccion" class="selected-option">Seleccione un medio de transporte</div>
                    <ul id="medio-transporte-opciones" class="select-options">
                        <li data-value="MOTOCICLETA">Motocicleta</li>
                        <li data-value="AUTOMOVIL">Automóvil</li>
                        <li data-value="TRANSPORTE PUBLICO">Transporte Público</li>
                        <li data-value="AVION">Avión</li>
                    </ul>
                    <input type="hidden"  name="medio_de_transporte" id="medio_de_transporte" /> 
                 </div>

                Campo de Placa de Vehículo
                <input 
                    type="text" 
                    class="input_solicitud" 
                    placeholder="Ingrese la placa de su vehículo (si aplica)" 
                    id="placa_vehiculo" 
                    name="placa_vehiculo" 
                    title="Indica la placa de tu vehículo (si aplica)" 
                    style="display: none;" />


                    <input type="text" class="input_solicitud" 
                        placeholder="Ingrese la placa de su vehículo" 
                        id="placa_vehicular" name="placa_vehicular" 
                        title="Indica la placa de tu vehículo">

                    <button type="submit" id="btn-enviar-permiso-laboral">Enviar solicitud</button>
                </div> 
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $resultado = $solicitudController->procesarFormulario();
                    if ($resultado) {
                        echo '<div class="alert alert-success">Solicitud enviada correctamente</div>';
                    } else {
                        echo '<div class="alert alert-error">Error al procesar la solicitud</div>';
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    echo '<div class="alert alert-error">Error inesperado</div>';
                }
            }
            ?>


            <div id="fondo-formulario">
            
            </div>
            <!-- <figure id="contenedor-logo">
                <img src="/app/assets/img/logoOficial.png" alt="">
            </figure> -->
        </section>
         
    </main>

    <footer >
        <p>&copy; 2024 Copyright: Aviso de privacidad, Términos y condiciones. Todos los derechos reservados.</p>
    </footer>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/main.js"></script>
    <script src="/solicitud_de_permisos_laborales/app/assets/js/menu.js"></script>
    <!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdown = document.getElementById('contenedor-permiso');
        const selectedOption = document.getElementById('selected-option');
        const dropdownOptions = document.getElementById('select-options');
        const hiddenInput = document.getElementById('tipo-permiso');
        const envio_solicitud = document.getElementById('btn-enviar-permiso');
        const permiso_laboral = document.getElementById('permiso-laboral');
        const medioTransporte = document.getElementById('medio_de_transporte');
        const placaVehicular = document.getElementById('placa_vehicular');
        const medioTransporteSeleccion = document.getElementById('medio-transporte-seleccion');
        const medioTransporteOpciones = document.getElementById('medio-transporte-opciones');
        const medioTransporteInput = document.getElementById('medio-de-transporte');
        const placaVehiculoInput = document.getElementById('placa-vehiculo');

        // Toggle dropdown visibility
        selectedOption.addEventListener('click', () => {
            dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
        });

        // Handle option selection
        dropdownOptions.addEventListener('click', (event) => {
            if (event.target.tagName === 'LI') {
                const value = event.target.dataset.value;
                const text = event.target.textContent;

                // Set the selected value
                selectedOption.textContent = text;
                hiddenInput.value = value;

                // Hide the dropdown
                dropdownOptions.style.display = 'none';
                if (hiddenInput.value ==="laboral"){
                    envio_solicitud.style.display="none";
                    permiso_laboral.style.display="flex";
                    dropdown.style.zIndex="3";
                    dropdown.style.bottom="40px";
                    placaVehicular.style.display = "none";
    
    // Mostrar/ocultar las opciones del dropdown
    medioTransporteSeleccion.addEventListener('click', () => {
        medioTransporteOpciones.style.display = 
            medioTransporteOpciones.style.display === 'block' ? 'none' : 'block';
    });

    // Seleccionar una opción del dropdown
    medioTransporteOpciones.addEventListener('click', (event) => {
        const selectedValue = event.target.getAttribute('data-value');
        if (selectedValue) {
            medioTransporteSeleccion.textContent = event.target.textContent;
            medioTransporteInput.value = selectedValue;
            medioTransporteOpciones.style.display = 'none';

            // Mostrar campo de placa solo si el transporte requiere
            if (selectedValue === 'MOTOCICLETA' || selectedValue === 'AUTOMOVIL') {
                placaVehiculoInput.style.display = 'block';
            } else {
                placaVehiculoInput.style.display = 'none';
            }
        }
    });
                    
                }else{
                    envio_solicitud.style.display="block";
                    permiso_laboral.style.display="none"
                    dropdown.style.bottom="0";
                }
            }
        });

        // Close dropdown if clicking outside
        document.addEventListener('click', (event) => {
            if (!dropdown.contains(event.target)) {
                dropdownOptions.style.display = 'none';
            }
        });
    });
</script> -->

</body>
</html>
