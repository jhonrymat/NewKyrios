<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kyrios center</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="css/style.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">


</head>

<body data-bs-spy="scroll" data-bs-target=".navbar">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/vendor/adminlte/dist/img/kyrios-logo.png" width="120" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#equipo">Equipo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contacto</a>
                    </li>
                </ul>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-primary ms-lg-3">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary ms-lg-3">Ingresar</a>
                    @endauth
                @endif
                {{-- <a href="#" class="btn btn-brand ms-lg-3">Download</a> --}}
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section id="hero" class="min-vh-100 d-flex align-items-center text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-left" class="text-uppercase text-white fw-semibold display-1">Kyrios Center
                    </h1>

                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-12">
                    <h4 class="text-uppercase text-white mt-3 mb-4" data-aos="fade-right">Consulta el estado de
                        reparación de tu equipo
                    </h4>
                    <div data-aos="fade-up" data-aos-delay="50">
                        <form id="buscarOrdenForm">
                            <div class="form-group row justify-content-center">
                                <div class="col-md-4 col-sm-8">
                                    <input type="text" name="codigo" id="codigoOrden" class="form-control"
                                        placeholder="Ingrese el código de la orden" required>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    {{-- modal --}}
    <div class="modal" id="ordenDetalleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de la Orden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Código:</strong> <span id="detalleCodigo"></span></p>
                    <p><strong>Cliente:</strong> <span id="detalleCliente"></span></p>
                    <p><strong>Estado:</strong> <span id="detalleEstado"></span></p>
                </div>
                <div class="modal-footer">
                    <button id="whatsappBtn" class="btn btn-success">
                        <i class="ri-whatsapp-fill"></i> Más información
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ABOUT -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="50">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Acerca de Nosotros</h1>
                        </h1>
                        <div class="line"></div>
                        <p>Especialistas en mantenimiento de equipos de computación y ventas de productos informáticos.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6" data-aos="fade-down" data-aos-delay="50">
                    <img src="images/about.jpg" alt="">
                </div>
                <div data-aos="fade-down" data-aos-delay="150" class="col-lg-5">
                    <h1>Kyrios Center</h1>
                    <p class="mt-3 mb-4">Ofrecemos servicios de reparación y mantenimiento de equipos, así como venta
                        de productos informáticos de última generación.</p>
                    <div class="d-flex pt-4 mb-3">
                        <div class="iconbox me-4">
                            <i class="ri-mail-send-fill"></i>
                        </div>
                        <div>
                            <h5>Experiencia</h5>
                            <p>Somos una empresa con más de 10 años de experiencia en el mercado</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="iconbox me-4">
                            <i class="ri-user-5-fill"></i>
                        </div>
                        <div>
                            <h5>Que hacemos?</h5>
                            <p>brindamos soluciones tecnológicas a empresas y usuarios finales</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="iconbox me-4">
                            <i class="ri-rocket-2-fill"></i>
                        </div>
                        <div>
                            <h5>Somos los mejores</h5>
                            <p>Contamos con los mejores profesionales en el area.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="section-padding border-top">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Nuestros Servicios</h1>
                        <div class="line"></div>
                        <p>Ofrecemos soluciones completas para el mantenimiento de computadores, venta de repuestos y
                            componentes, y equipos nuevos y de segunda, asegurando que tu tecnología esté siempre en
                            óptimas condiciones.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-tools-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Mantenimiento de Computadores</h5>
                        <p>Servicios de reparación y optimización de computadores de todas las marcas para garantizar su
                            funcionamiento eficiente.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-computer-line"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Venta de Computadores Nuevos</h5>
                        <p>Ofrecemos computadores nuevos de las principales marcas con garantía y soporte técnico
                            especializado.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-recycle-line"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Venta de Computadores de Segunda</h5>
                        <p>Gran variedad de equipos reacondicionados con garantía, ideal para quienes buscan rendimiento
                            a un menor costo.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-cpu-line"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Venta de Repuestos y Partes</h5>
                        <p>Componentes originales y genéricos para mejorar o reparar tu equipo, con asesoría
                            especializada.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="550">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-hard-drive-2-line"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Instalación de Componentes</h5>
                        <p>Servicio de instalación de partes y componentes para garantizar un rendimiento óptimo de tu
                            equipo.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="650">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-shield-check-line"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Soporte Técnico</h5>
                        <p>Asistencia técnica profesional para resolver cualquier problema o consulta relacionada con
                            tus equipos informáticos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- COUNTER -->
    <section id="counter" class="section-padding">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <h1 class="text-white display-4">1,500+</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">Computadoras Reparadas</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <h1 class="text-white display-4">800+</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">Clientes Satisfechos</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <h1 class="text-white display-4">1,000+</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">Repuestos Vendidos</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <h1 class="text-white display-4">50+</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">Miembros del Equipo</h6>
                </div>
            </div>
        </div>
    </section>


    <!-- PORTFOLIO -->
    <section id="portfolio" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Nuestros Proyectos</h1>
                        <div class="line"></div>
                        <p>Hemos trabajado en una amplia gama de proyectos que abarcan desde la reparación de
                            computadores hasta la instalación de sistemas avanzados.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="images/project-1.webp" alt="">
                        </div>
                        <a href="images/project-1.webp" data-fancybox="gallery" class="iconbox"><i
                                class="ri-search-2-line"></i></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="images/project-2.webp" alt="">
                        </div>
                        <a href="images/project-2.webp" data-fancybox="gallery" class="iconbox"><i
                                class="ri-search-2-line"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="images/project-3.webp" alt="">
                        </div>
                        <a href="images/project-3.webp" data-fancybox="gallery" class="iconbox"><i
                                class="ri-search-2-line"></i></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="images/project-4.webp" alt="">
                        </div>
                        <a href="images/project-4.webp" data-fancybox="gallery" class="iconbox"><i
                                class="ri-search-2-line"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="350">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="images/project-5.webp" alt="">
                        </div>
                        <a href="images/project-5.webp" data-fancybox="gallery" class="iconbox"><i
                                class="ri-search-2-line"></i></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="images/project-6.webp" alt="">
                        </div>
                        <a href="images/project-6.webp" data-fancybox="gallery" class="iconbox"><i
                                class="ri-search-2-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM -->
    <section id="equipo" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Nuestro Equipo</h1>
                        <div class="line"></div>
                        <p>Contamos con un equipo de expertos dedicados a brindar soluciones integrales para el
                            mantenimiento, reparación y venta de equipos y repuestos de tecnología.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="images/person-1.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Carlos Martínez</h4>
                            <p class="mb-0 text-white">Técnico en Reparación de Computadoras</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="images/person-2.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Ana López</h4>
                            <p class="mb-0 text-white">Especialista en Ventas de Partes y Repuestos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="350">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="images/person-3.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Luis Rodríguez</h4>
                            <p class="mb-0 text-white">Ingeniero de Instalación de Equipos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CONTACT -->
    <section class="section-padding bg-light" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 text-white fw-semibold">Contáctanos</h1>
                        <div class="line bg-white"></div>
                        <p class="text-white">Estamos aquí para ayudarte con todas tus necesidades de mantenimiento y
                            reparación de equipos informáticos. No dudes en contactarnos o visitarnos.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" data-aos="fade-down" data-aos-delay="250">
                <div class="col-lg-6">
                    <div class="map p-lg-5 p-4 bg-white theme-shadow">
                        <h4 class="mb-4">Información de Contacto</h4>
                        <ul class="list-unstyled" height="300">
                            <li><i class="ri-phone-line"></i> Teléfono: <br>+57 318 690 72 08</li>
                            <li><i class="ri-mail-line"></i> Email: <br>kyrioscenter@hotmail.com</li>
                            <li><i class="ri-map-pin-line"></i> Dirección: <br>Cra 31 37-66, Villavicencio 500001,
                                Meta, Colombia</li>
                            <li><i class="ri-time-line"></i> Horario de Atención: <br>Lunes a Sabados, 8:30 AM - 7:00
                                PM
                            </li>
                        </ul>
                        <div class="social-icons">
                            <a target="_blank" href="https://www.instagram.com/kyrios_center?igshid=YmMyMTA2M2Y%3D"><i
                                    class="ri-instagram-fill"></i></a>
                            <a target="_blank" href="https://www.facebook.com/kyrioscenter"><i
                                    class="ri-facebook-fill"></i></a>
                            <a target="_blank" href="kyrioscenter.online"><i class="ri-dribbble-fill"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="map p-lg-5 p-4 bg-white theme-shadow">
                        <h4 class="mb-4">Nuestra Ubicación</h4>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.3504239275394!2d-73.63896012552833!3d4.151315846176261!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3e2d005c369ce3%3A0xafe75656a112e4a3!2sKyrios%20center!5e0!3m2!1ses-419!2sco!4v1726162570486!5m2!1ses-419!2sco"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FOOTER -->
    <footer class="bg-dark">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3 col-sm-6">
                        <h2 style="color: white;font-size: 58px;">Kyrios Center</h2>
                        <div class="line"></div>
                        <div class="social-icons">
                            <a target="_blank" href="https://www.instagram.com/kyrios_center?igshid=YmMyMTA2M2Y%3D"><i
                                    class="ri-instagram-fill"></i></a>
                            <a target="_blank" href="https://www.facebook.com/kyrioscenter"><i
                                    class="ri-facebook-fill"></i></a>
                            <a target="_blank" href="kyrioscenter.online"><i class="ri-dribbble-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">SERVICIOS</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#">Mantenimiento de Computadores</a></li>
                            <li><a href="#">Instalación de Equipos</a></li>
                            <li><a href="#">Venta de Repuestos</a></li>
                            <li><a href="#">Software y Actualizaciones</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">SOBRE NOSOTROS</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#about">Nosotros</a></li>
                            <li><a href="#services">Servicios</a></li>
                            <li><a href="#contact">Contacto</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">CONTACTO</h5>
                        <div class="line"></div>
                        <ul>
                            <li>Villavicencio, Meta, Colombia</li>
                            <li>+57 318 690 72 08</li>
                            <li>kyrioscenter@hotmail.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row g-4 justify-content-between">
                    <div class="col-auto">
                        <p class="mb-0">© Copyright Kyrios Center. Todos los derechos reservados.</p>
                    </div>
                    <div class="col-auto">
                        <p class="mb-0">Desarrollado con 💜 por <a href="tel:573105320659">Guiar Go</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="js/main.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('buscarOrdenForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

                var codigoOrden = document.getElementById('codigoOrden')
                    .value; // Obtener el código ingresado

                // Realizar la solicitud Fetch
                fetch("{{ route('buscar.orden') }}?codigo=" + codigoOrden, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.orden) {
                            // Cargar los detalles en el modal
                            document.getElementById('detalleCodigo').textContent = data.orden.codigo;
                            document.getElementById('detalleCliente').textContent = data.orden
                                .nomcliente;
                            if (data.orden.estado == 'PENDIENTE' && data.orden.reparado == 'reparado') {
                                document.getElementById('detalleEstado').textContent =
                                    'SU EQUIPO YA HA SIDO REPARADO';
                                document.getElementById('detalleEstado').style.color =
                                    'green'; // Texto en verde si está reparado
                            } else {
                                document.getElementById('detalleEstado').textContent =
                                    'SU EQUIPO AUN ESTA EN ESTADO DE REPARACION';
                                document.getElementById('detalleEstado').style.color =
                                    'red'; // Texto en rojo si no está reparado
                            }
                            // Mostrar el modal
                            var modal = new bootstrap.Modal(document.getElementById(
                                'ordenDetalleModal'));
                            modal.show();
                        } else {
                            // Usar SweetAlert en lugar de alert
                            Swal.fire({
                                icon: 'error',
                                title: 'Orden no encontrada',
                                text: 'No se encontró la orden con el código ingresado.',
                                confirmButtonText: 'Ok'
                            });
                        }
                    })
                    .catch(() => {
                        // Usar SweetAlert en lugar de alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al buscar la orden. Inténtalo de nuevo más tarde.',
                            confirmButtonText: 'Ok'
                        });
                    });
            });
        });
    </script>

    <script>
        document.getElementById('whatsappBtn').addEventListener('click', function() {
            var codigo = document.getElementById('detalleCodigo').textContent;
            var cliente = document.getElementById('detalleCliente').textContent;
            var estado = document.getElementById('detalleEstado').textContent;

            var mensaje = `Hola, me gustaría más información sobre la orden con los siguientes detalles:
        \nCódigo: ${codigo}
        \nCliente: ${cliente}
        \nEstado: ${estado}`;

            var whatsappUrl =
                `https://api.whatsapp.com/send?phone=573105320659&text=${encodeURIComponent(mensaje)}`;

            window.open(whatsappUrl, '_blank');
        });
    </script>

</body>

</html>
