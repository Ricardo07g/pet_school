<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>@yield('title')</title>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/system/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/system/css/style.css">
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
<!--===============================================================================================-->

<!--===============================================================================================-->
    <script src="system/js/functions.js"></script>    
    <script src="system/js/bootstrap.bundle.min.js"></script>
    <script src="system/js/jquery.min.js"></script>
    
    <script src="system/js/bootstrap.min.js"></script>
    <script src="system/js/main.js"></script>
    <!-- <script src="system/js/alpine.js"></script> -->
    
    <script src="system/js/modal.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="system/js/inputmask.js"></script>
    <script src="system/js/popper.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
</head>

<!--===============================================================================================-->
    </head>
    <body>

    <div class="wrapper d-flex align-items-stretch">
		<nav id="sidebar">
		    <div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(/system/images/logo.jpg);"></a>
                <ul class="list-unstyled components mb-5">
                <li>
                    <a href="/inicio">Início</a>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Administração</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li>
                        <a href="/usuarios">Usuários do sistema</a>
                    </li>
                    <li>
                        <a href="/pessoas">Pessoas</a>
                    </li>
                    <li>
                        <a href="/funcionarios">Funcionários</a>
                    </li>
                    <li>
                        <a href="#">Configurações</a>
                    </li>
                    </ul>
                </li>
            <!--
                <li>
                    <a href="#">About</a>
                </li>

                <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="#">Page 1</a>
                    </li>
                    <li>
                        <a href="#">Page 2</a>
                    </li>
                    <li>
                        <a href="#">Page 3</a>
                    </li>
                </ul>
                </li>

                <li>
                    <a href="#">Portfolio</a>
                </li>
            -->

                 <li>
                    <a href="/logout">Logout</a>
                </li>

            </ul>

                <div class="footer">
                    <p>
                        <!--

                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
                        -->

                    @auth
                        {{auth()->user()->name}}
                    @endauth

                    </p>
                </div>

	      </div>
    	</nav>

    <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" 
                        aria-expanded="false" 
                        aria-label="Toggle navigation"
                >
                    <i class="fa fa-bars"></i>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                    @if(isset($routes))
                        @foreach ($routes as $key => $route)
                        <li class="<?php echo ($route != end($routes)) ? 'nav-item active' : 'nav-item deactive'; ?>">
                            <a 
                                class="<?php echo ($route != end($routes)) ? 'nav-link' : ' nav-link disabled'; ?>" 
                                href="<?php echo ($route != end($routes)) ? $route['route'] : '#'; ?>"
                            >
                                <?php echo$route['index']; ?>
                                @if($route != end($routes))
                                    <i class="bi bi-arrow-right-short" style="margin-left: 10px;"></i>
                                @endif
                            </a>
                        </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class ="subcontent">
            @include('flash-message')

            @yield('content')
        </div>

        <div id="spinner_loading" class="loading" style="display: none;">

        <div>
      </div>
	</div>

    <script>
        function spinner_loading(flag)
        {
            if(flag === true)
            {
                $('#spinner_loading').css('display','block');
            }else{
                $('#spinner_loading').css('display','none');
            }
        }
    </script>

    </body>
</html>