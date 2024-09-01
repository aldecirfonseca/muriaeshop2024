<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <title>Muriaé | Shop</title>

        <link rel="icon" href="assets/img/Fevicon.png" type="image/png">
        <link rel="stylesheet" href="assets/vendors/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="assets/vendors/themify-icons/themify-icons.css">
        <link rel="stylesheet" href="assets/vendors/nice-select/nice-select.css">
        <link rel="stylesheet" href="assets/vendors/owl-carousel/owl.theme.default.min.css">
        <link rel="stylesheet" href="assets/vendors/owl-carousel/owl.carousel.min.css">

        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/customizado.css">
    </head>

    <body>
        <header class="header_area">
            <div class="main_menu">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                    <a class="navbar-brand logo_h" href="index.php"><img src="assets/img/logo.png" alt=""></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
                                <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                                
                                <li class="nav-item submenu dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Departamentos</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a class="nav-link" href="#">Calçados</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Computadores</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Geladeira</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">TVs</a></li>
                                    </ul>
                                </li>                                  
                                
                                <li class="nav-item"><a class="nav-link" href="index.php?pagina=sobrenos">Sobre nós</a></li>
                                <li class="nav-item"><a class="nav-link" href="index.php?pagina=contato">Contato</a></li>

                                <?php
                                if (1 == 2) {
                                    ?>
                                    <li class="nav-item"><a class="nav-link" href="index.php?pagina=login">Entre ou cadastre-se</a></li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="nav-item submenu dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Aldecir Fonseca</a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item"><a class="nav-link" href="#">Meus pedidos</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#">Perfil</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#">Trocar Senha</a></li>
                                            <li class="nav-item"><a class="nav-link" href="Departamento">Departamento</a></li>
                                        </ul>
                                    </li>                            
                                    <?php
                                }
                                ?>
                            </ul>

                            <div class="shop_right_sidebar nav-item">

                                <form class="form-inline my-2 my-lg-0 search_nav">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Procurar" aria-label="Search">
                                    </div>
                                        <a href="#" class="btn" style="font-size: 24px;">
                                            <i class="ti-search"></i>
                                        </a>
                                </form>

                            </div>

                            <ul class="nav-shop">
                                <a href="index.php?pagina=carrinhoCompras">
                                    <li class="nav-item"><button><i class="ti-shopping-cart"></i><span class="nav-shop__circle">3</span></button> </li>
                                </a>
                            </ul>                    

                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main class="container">
            <section>
                <?php

                    $pagina = "home";

                    if (isset($_GET['pagina'])) {
                        $pagina = $_GET['pagina'];
                    }

                    require_once $pagina . ".php";

                ?>
            </section>
        </main>
        
        <footer class="footer">
            <div class="footer-area">
                <div class="container">
                    <div class="row section_gap">
                        <div class="col-lg-5 col-md-6 col-sm-6">
                            <div class="single-footer-widget tp_widgets">
                                <h4 class="footer_title large_title">Nossa missão</h4>
                                <p>
                                    Transmitir informações com credibilidade aos leitores, de forma transparente e sem sensacionalismo, sendo ético e verdadeiro com a informação da forma que ela é.
                                </p>
                                <h4 class="footer_title large_title">Nossa visão</h4>
                                <p>Trazer desenvolvimento econômico e social, promover o bem estar e conhecimento, ser referência no meio jornalístico. </p>
                            </div>
                        </div>
                        <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6">
                            <div class="single-footer-widget tp_widgets">
                                <h4 class="footer_title">Links rápidos</h4>
                                <ul class="list">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="index.php?pagina=sobrenos">Sobre nós</a></li>
                                    <li><a href="index.php?pagina=contato">Contato</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6">
                            <div class="single-footer-widget tp_widgets">
                                <h4 class="footer_title">Contato</h4>
                                <div class="ml-40">
                                    <p class="sm-head">
                                        <span class="fa fa-location-arrow"></span> Endereço:
                                    </p>
                                    <p>Praça Aninna Bisegna, 40 - Centro <br /> Muriaé-MG</p>

                                    <p class="sm-head">
                                        <span class="fa fa-phone"></span> Telefone:
                                    </p>
                                    <p>
                                        +55 (32) 3721-1026
                                    </p>

                                    <p class="sm-head">
                                        <span class="fa fa-envelope"></span> Email
                                    </p>
                                    <p>
                                        aldecir.fonseca@santamarcelina.edu.br <br> <a href="https://www.santamarcelina.edu.br/faculdade/muriae/" target="_blank" title="FASM">fasm.online</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="row d-flex">
                        <p class="col-lg-12 footer-text text-center">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Todos os direitos reservados | Aldecir Fonseca | <a href="https://www.santamarcelina.edu.br/faculdade/muriae/" target="_blank">FASM</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <script src="assets/vendors/jquery/jquery-3.2.1.min.js"></script>
        <script src="assets/vendors/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="assets/vendors/skrollr.min.js"></script>
        <script src="assets/vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="assets/vendors/jquery.ajaxchimp.min.js"></script>
        <script src="assets/vendors/mail-script.js"></script>
        <script src="assets/js/main.js"></script>
        
    </body>

</html>