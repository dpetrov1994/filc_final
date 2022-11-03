<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>_nomePagina_ - _nomeModuloTitle_ - _nomePlataforma_</title>

    <meta name="description" content="_metaDescricao_">
    <meta name="author" content="_metaAutor_">
    <meta name="keywords" content="_metaKeywords_">
    <meta name="robots" content="_metaRobots_">

    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="_layoutDirectory_/img/favicon.png">
    <link rel="apple-touch-icon" href="_layoutDirectory_/img/icon57.png" sizes="57x57">
    <link rel="apple-touch-icon" href="_layoutDirectory_/img/icon72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="_layoutDirectory_/img/icon76.png" sizes="76x76">
    <link rel="apple-touch-icon" href="_layoutDirectory_/img/icon114.png" sizes="114x114">
    <link rel="apple-touch-icon" href="_layoutDirectory_/img/icon120.png" sizes="120x120">
    <link rel="apple-touch-icon" href="_layoutDirectory_/img/icon144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="_layoutDirectory_/img/icon152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="_layoutDirectory_/img/icon180.png" sizes="180x180">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Bootstrap is included in its original form, unaltered -->
    <link rel="stylesheet" href="_layoutDirectory_/css/bootstrap.min.css">

    <!-- Related styles of various icon packs and plugins -->
    <link rel="stylesheet" href="_layoutDirectory_/css/plugins.css">
    <link rel="stylesheet" href="_layoutDirectory_/js/plugins/jvectormap/jquery-jvectormap-1.2.2.css">

    <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
    <link rel="stylesheet" href="_layoutDirectory_/css/main.css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">-->
    <link rel="stylesheet" href="_layoutDirectory_/css/pace.css">
    <link rel="stylesheet" href="_layoutDirectory_/css/inputfile.css">
    <link rel="stylesheet" href="_layoutDirectory_/css/clockpicker.css">
    <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

    <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
    <link rel="stylesheet"  href="_layoutDirectory_/css/themes/_temaPlataforma_">
    <!-- END Stylesheets -->

    <link rel="stylesheet" href="_layoutDirectory_/js/plugins/leaflet/leaflet.css">

    <link rel="stylesheet" type="text/css" href="../assets/jquery-comments/css/jquery-comments.css">

    <!-- Modernizr (browser feature detection library) -->
    <script src="_layoutDirectory_/js/vendor/modernizr-2.8.3.min.js"></script>

</head>
<body id="body">

<div id="nomeTabelaComentarios" style="display: none">_nomeTabela_</div>
<div id="idItemComentarios" style="display: none">_idItem_</div>
<!-- Page Wrapper -->
<!-- In the PHP version you can set the following options from inc/config file -->
<!--
    Available classes:

    'page-loading'      enables page preloader
-->
<div id="page-wrapper" class="page-loading">
    <!-- Preloader -->
    <!-- Preloader functionality (initialized in _layoutDirectory_/js/app.js) - pageLoading() -->
    <!-- Used only if page preloader enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version)
    <div class="preloader hidden">
        <div class="inner">
            <div class="preloader-spinner themed-background hidden-lt-ie10"></div>
            <h3 class="text-primary visible-lt-ie10"><strong>Aguarde.. / Loading..</strong></h3>
        </div>
    </div>
    -->
    <!-- END Preloader -->

    <!-- Page Container -->
    <!-- In the PHP version you can set the following options from inc/config file -->
    <!--
        Available #page-container classes:

        'sidebar-light'                                 for a light main sidebar (You can add it along with any other class)

        'sidebar-visible-lg-mini'                       main sidebar condensed - Mini Navigation (> 991px)
        'sidebar-visible-lg-full'                       main sidebar full - Full Navigation (> 991px)

        'sidebar-alt-visible-lg'                        alternative sidebar visible by default (> 991px) (You can add it along with any other class)

        'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar
        'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar

        'fixed-width'                                   for a fixed width layout (can only be used with a static header/main sidebar layout)

        'enable-cookies'                                enables cookies for remembering active color theme when changed from the sidebar links (You can add it along with any other class)
    -->
    <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">
        <!-- Alternative Sidebar -->
        <div id="sidebar-alt" tabindex="-1" aria-hidden="true">
            <!-- Toggle Alternative Sidebar Button (visible only in static layout) -->
            <a href="javascript:void(0)" id="sidebar-alt-close" onclick="App.sidebar('toggle-sidebar-alt');"><i class="fa fa-times"></i></a>

            <!-- Wrapper for scrolling functionality -->
            <div id="sidebar-scroll-alt">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Sidebar Section -->
                    <div class="sidebar-section">
                        _contentSidebar_
                    </div>
                    <!-- END Sidebar Section -->
                </div>
                <!-- END Sidebar Content -->
            </div>
            <!-- END Wrapper for scrolling functionality -->
        </div>
        <!-- END Alternative Sidebar -->

        <!-- Main Sidebar -->
        <div id="sidebar">
            <!-- Sidebar Brand -->
            <div id="sidebar-brand" class="themed-background">
                <a href="/" class="sidebar-title">
                    <i class="fa fa-home"></i><span class="sidebar-nav-mini-hide">_nomePlataforma_</span>
                </a>
            </div>
            <!-- END Sidebar Brand -->

            <!-- Wrapper for scrolling functionality -->
            <div id="sidebar-scroll">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Sidebar Navigation -->
                    <ul class="sidebar-nav">
                        _menuPrincipal_
                    </ul>
                    <!-- END Sidebar Navigation -->

                    <!-- Color Themes -->
                    <!-- Preview a theme on a page functionality can be found in _layoutDirectory_/js/app.js - colorThemePreview() -->
                    <div class="sidebar-section sidebar-nav-mini-hide">
                        <div class="sidebar-separator push">
                            <i class="fa fa-ellipsis-h"></i>
                        </div>
                        <ul class="sidebar-themes clearfix">
                        </ul>
                    </div>
                    <!-- END Color Themes -->
                </div>
                <!-- END Sidebar Content -->
            </div>
            <!-- END Wrapper for scrolling functionality -->

            <!-- Sidebar Extra Info -->
            <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
                <!--
                <div class="push-bit">
                            <span class="pull-right">
                                <a href="_siteEmpresa_" target="_blank" class="text-muted"><i class="fa fa-home"></i></a>
                            </span>
                    <small>_nomeEmpresa_</small>
                </div>
                <div class="push-bit">
                            <span class="pull-right">
                                <a href="_siteEmpresa_" target="_blank" class="text-muted"><i class="fa fa-phone"></i></a>
                            </span>
                    <small>_contactoEmpresa_</small>
                </div>
                <div class="progress progress-striped progress-mini">
                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>
                -->
                <div class="text-center">
                    _footer_
                </div>
            </div>
            <!-- END Sidebar Extra Info -->
        </div>
        <!-- END Main Sidebar -->

        <!-- Main Container -->
        <div id="main-container">
            <!-- Header -->
            <!-- In the PHP version you can set the following options from inc/config file -->
            <!--
                Available header.navbar classes:

                'navbar-default'            for the default light header
                'navbar-inverse'            for an alternative dark header

                'navbar-fixed-top'          for a top fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in _layoutDirectory_/js/app.js - handleSidebar())
                    'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

                'navbar-fixed-bottom'       for a bottom fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in _layoutDirectory_/js/app.js - handleSidebar()))
                    'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
            -->
            <header id="headerPrincipal" class="navbar navbar-inverse navbar-fixed-top ">
                <!-- Left Header Navigation -->
                <ul class="nav navbar-nav-custom">
                    <!-- Main Sidebar Toggle Button -->
                    <li class="">
                        <a id="abrirMenuPrincipal" href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                            <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                            <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                        </a>
                    </li>
                    <li class="animation-fadeIn">
                        <a href="/"><i class="fa fa-home"></i></a>
                    </li>
                    <li class="animation-fadeIn" onclick="this.blur();">
                        <a href=""><i onclick="this.className='fa fa-refresh fa-spin'" class="fa fa-refresh"></i></a>
                    </li>
                    <!-- END Main Sidebar Toggle Button -->

                    <!-- Header Link -->
                    <!-- END Header Link -->
                </ul>
                <!-- END Left Header Navigation -->

                <!-- Right Header Navigation -->
                <ul class="nav navbar-nav-custom pull-right ">
                   <!-- <li class=" ">
                        <a href="#modal_search" id="btn_search_geral" data-toggle="modal" >
                            <i class="gi gi-search"></i>
                        </a>

                    </li>-->
                    <!-- START ADDONS -->
                    _addons_
                    <!-- ADDONS -->
                    <!-- Alternative Sidebar Toggle Button
                    <li class="">
                        <a id="abrirMenuDefinicoes" href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');this.blur();">
                            <i class="gi gi-settings"></i>
                        </a>
                    </li>
                    END Alternative Sidebar Toggle Button -->

                    <!-- User Dropdown -->
                    <li class="dropdown">
                        _userDropdown_
                    </li>
                    <!-- END User Dropdown -->
                </ul>
                <!-- END Right Header Navigation -->
            </header>
            <!-- END Header -->

            <!-- Page content -->



            <div id="page-content" class="">
                <div id="page-content-2">
                    <!-- Page Header -->
                    <div class="content-header">
                        <div class="row ">
                            <ul class="nav navbar-nav-custom">
                                _menuSecundario_
                            </ul>
                            _historicoPaginas_
                        </div>

                    </div>

                    _status_

                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="nav nav-justified text-center">
                                _menuSecundarioIndividual_
                            </ul>
                        </div>
                    </div>


                    <!-- END Page Header -->
                    <div id="reloading-animation" class="animation-slideDown">
                        <i class="fa fa-2x fa-asterisk fa-spin text-info"></i>
                    </div>
                    _content_
                </div>
            </div>
            <!-- END Page Content -->
        </div>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
</div>
<!-- END Page Wrapper -->

<a href="#modal-compose" class="hidden" data-toggle="modal" id="confirmaModal"></a>
<div id="modal-compose" class="modal" role="dialog" aria-hidden="true" style="z-index: 9999999">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Tem a certeza?</strong></h3>
            </div>
            <div class="modal-footer">
                <div id="confirmaModal_botoes" class="form-group form-actions">
                    <div class="col-xs-6">
                        <button class="btn btn-effect-ripple btn-danger btn-block" type="button" data-dismiss="modal" aria-hidden="true">Não</button>
                    </div>
                    <div class="col-xs-6 pull-right">
                        <a href="" id="confirmaModalSim" class="btn btn-effect-ripple btn-primary  btn-block">Sim</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-para-faturar" class="modal" role="dialog" aria-hidden="true" style="z-index: 9999999">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h3 class="modal-title"><strong>Tem a certeza?</strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container-obs-faturar">
                    <label>Observações para faturação</label><br>
                    <textarea class="form-control" id="obs-faturar"></textarea>
                </div>
                <div class="loading-obs-faturar">
                    <h3 class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i><br>Aguarde..</h3>
                </div>

            </div>
            <div class="modal-footer">
                <div id="modal-para-faturar-botoes" class="form-group form-actions">
                    <div class="col-xs-6">
                        <button class="btn btn-effect-ripple btn-default btn-block" type="button" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    </div>
                    <div class="col-xs-6 pull-right">
                        <a href="javascript:void(0)" onclick="" id="confirma-para-faturar" class="btn btn-effect-ripple btn-primary  btn-block">Confirmar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-iframe" class="modal fade"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <iframe style="border: none;width: 100%;height: 600px" id="iframe_para_url"></iframe>
            </div>
        </div>
    </div>
</div>
<div id="modal_search" class="modal"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 searchbar-div" >
                        <div class="text-center" style="margin-right: 20px;margin-left: 20px">
                            <label>Pesquisar:</label>
                            <input type="text" id="searchbar2" class="searchbar"  placeholder="Escreva aqui..."><!--onchange="getClientes(this.value)" onkeyup="getClientes(this.value)"-->
                        </div>
                        <div class="client-info2" style="margin-top: 30px;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_novo_historico" class="modal fade"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Síntese Memória</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="_urlBack_?id=_idItem_" class="form-bordered form-horizontal">
                    <div class="row" style="margin: 20px">
                        <div class="col-lg-12">
                            <div class="form-group form-group-sm">
                                <input name="id_historico" id="id_historico" value="" type="hidden">
                                <input name="id_orcamento" value="_idItem_" type="hidden">
                                <input name="url_back" value="_urlBack_" type="hidden">
                                <label>Data:</label><br>
                                <input required style="width: 300px" type="text" value="_dataAgora_" name="data" id="data_comentario" class="input-datepicker form-control"><br>
                                <label>Comentário:</label><br>
                                <textarea required name="descricao" id="comentario" placeholder="Escreva aqui.." rows="7" class=" form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group form-group-sm">
                                <button type="submit" class="btn btn-success btn-block" ><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<div id="modal-datas" class="modal fade"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Datas para pagamento ao fornecedor</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="_urlBack_?id=_idItem_" class="form-bordered form-horizontal">
                    <div class="row" style="margin: 20px">
                        <div class="col-lg-12">
                            <div class="form-group form-group-sm">
                                <input name="id_despesa" id="modal-datas-id_despesa" value="" type="hidden">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group form-group-sm" id="modal-datas-content">

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group form-group-sm">
                                <button type="submit" name="atualizar_datas_despesa" class="btn btn-success btn-block" ><i class="fa fa-save"></i> Guardar</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- Background of PhotoSwipe.
         It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>
    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">
        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center" style="display: none"></div>
            </div>
        </div>
    </div>
</div>

<div class='modal' id='modal-session'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='model-content' style="border:1px solid #0e1b2c;min-height: 200px;background: white;">

            <div class="modal-header" style=" display: flex;justify-content: space-between;place-items: center;">
                <h4 style="font-weight: 500; margin: 0;padding: 0;">Voltar a iniciar Sessão</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><a style="opacity: 1;font-size: 30px !important;width: 44px;color: black;" href="/login/index.php">&times;</a></button>
            </div>

            <div class='modal-body' style='background:#fff;padding:20px'>

                <form id="form-para-validar" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="login-email" class="col-xs-12"> Email </label>
                        <div class="col-xs-12">
                            <input type="text" id="token" value="" name="token" class="hidden">
                            <input type="text" id="login-email" value="_email_" name="login-email" class="form-control" placeholder="Email...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login-password" class="col-xs-12">Palavra-passe</label>
                        <div class="col-xs-12">
                            <input type="password" id="login-password" name="login-password" class="form-control" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button name="entrar" id="btn_confirmar_session" class="btn btn-effect-ripple btn-sm btn-primary">Entrar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal-responder-email" class="modal " role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><strong>Responder</strong></h3>
            </div>
            <div class="modal-body" id="modal-responder-email-body"></div>
        </div>
    </div>
</div>



<div id="modal-mostrar-maquinas" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden" id="id_assistencia_cliente_modal" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-mostrar-maquinas')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
                <a class="pull-right text-light" id_assistencia_cliente="" href="javascript:void(0)" onclick="confirmaModalAjax()"> <i class="fa fa-trash"></i> </a>
            </div>
            <div class="modal-body" style="padding: 10px;">


                <!-- Preenchido com AJAX -->

            </div>
        </div>
    </div>
</div>


<div id="modal-adicionar-paragem" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-adicionar-paragem')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" style="margin-bottom: 20px">
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Iniciar um serviço</h2>
                            </div>

                            <label>Cliente</label>
                            <div>
                                <select id="id_cliente" name="id_cliente" onchange="verSeTemAssistenciasPorTerminar(this.value)" required class="select-select2" data-placeholder="Selecione.." style="width: 100%;">
                                    <option></option>
                                    _clientes_
                                </select>
                                <input class="hidden" id="id_assistencia_modal" readonly>

                                <div class="aviso-assistencias-por-terminar row">

                                </div>
                                <br>
                                <div class="info_adicional_paragem" style="display: none">
                                    <label>Hora de Início</label>
                                    <span style="display: flex; grid-gap: 20px"> <input id="data_inicio_add_paragem" name="data_inicio" class="form-control"  type="time">   <a class="btn btn-xs" style="background: #606060;color: white;align-self: center;" onclick="colocarTempoAtual('#data_inicio_add_paragem')"> Hora atual </a></span>

                                    <br>

                                    <label>Tipo</label><br>
                                    <label class="csscheckbox csscheckbox-primary"><input type="radio" checked class="tipo_paragem" name="externa" value="0"><span></span> <i class="fa fa-home"></i> Interna</label><br>
                                    <label class="csscheckbox csscheckbox-primary"><input type="radio" class="tipo_paragem" name="externa" value="1"><span></span> <i class="fa fa-truck"></i> Externa</label>

                                </div>

                                <br>
                                <a style="margin-top: 25px; cursor: pointer"  onclick="addParagemCliente()" class="btn btn-effect-ripple btn-success btn-block btn-submit">Iniciar Serviço</a>
                                <br>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>






<div id="modal-iniciar-assistencia" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden" id="id_assistencia_modal" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-iniciar-assistencia')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Iniciar Serviço</h2>
                            </div>

                            <div>
                                <div class="col-lg-12 input-status">
                                    <label>Hora de Início</label>
                                    <span style="display: flex; grid-gap: 20px"> <input id="data_inicio" name="data_inicio" class="form-control"  type="time">   <a class="btn btn-xs" style="background: #606060;color: white;align-self: center;" onclick="colocarTempoAtual('#data_inicio')"> Hora atual </a></span>
                                </div>
                            </div>

                            <div class="aviso-assistencias-por-terminar">

                            </div>


                            <div class="text-center">
                                <a class="btn btn-info iniciar-assistencia-btn mb-20" href="javascript:void(0)" > Iniciar </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal-terminar-assistencia" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden" id="id_assistencia_modal" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-terminar-assistencia')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title text-center">
                                <h2>TERMINAR ASSISTÊNCIA</h2>
                            </div>


                           <div>

                               <div class="col-lg-12 input-status" style="margin-bottom: 20px">
                                   <label>Hora de Fim</label>
                                   <span style="display: flex; grid-gap: 20px"> <input id="data_fim" name="data_fim" class="form-control"  type="time">
                                       <a class="btn btn-xs" style="background: #606060;color: white;align-self: center;" onclick="colocarTempoAtual('#data_fim')"> Hora atual </a>
                                   </span>
                               </div>

                                <div class="col-lg-12 input-status">
                                    <div class="info_viatura_e_kms"></div>
                                </div>

                            </div>

                            <div class="text-center">
                                <a class="btn btn-info terminar-assistencia-btn mb-20" href="javascript:void(0)" > Terminar </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<div id="modal-inserir-kilometros" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden" id="id_assistencia_cliente_modal" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-inserir-kilometros')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title text-center">
                                <h2>Insira os quilômetros da Assistência </h2>
                            </div>


                            <div>

                                <div class="col-lg-12 input-status">
                                    <label>Insira os KM's</label>
                                    <input type="number" id="kilometros" name="kilometros" class="form-control kilometros">
                                </div>

                            </div>

                            <div class="text-center">
                                <a class="btn btn-info inserir-kilometros-btn mb-20" href="javascript:void(0)" > Terminar </a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="modal-seguro-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-seguro-viatura')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Seguro</h2>
                            </div>


                            <div>

                                <div class="col-lg-12 input-status">
                                    <label>Insira a nova data de validade do Seguro</label>
                                    <input id="data_seguro" name="data_seguro" required autocomplete="off" class="input-datepicker form-control">
                                </div>

                            </div>

                            <div class="text-center">
                                <a class="btn btn-info mb-20" onclick="atualizarDatasViatura('data_seguro', '#modal-seguro-viatura')" href="javascript:void(0)" > Atualizar </a>
                                <br>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal-inspecao-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-inspecao-viatura')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Inspeção</h2>
                            </div>


                            <div>

                                <div class="col-lg-12 input-status">
                                    <label>Insira a nova data de validade da Inspeção</label>
                                    <input id="data_inspecao" name="data_inspecao" required autocomplete="off" class="input-datepicker form-control">
                                </div>

                            </div>

                            <div class="text-center">
                                <a class="btn btn-info mb-20" onclick="atualizarDatasViatura('data_inspecao', '#modal-inspecao-viatura')" href="javascript:void(0)" > Atualizar </a>
                                <br>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal-lavagem-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-lavagem-viatura')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h2>Lavagem</h2>
                            </div>


                            <!--    <div>

                                    <div class="col-lg-12 input-status">
                                        <label>Insira a nova data de lavagem da Viatura</label>
                                        <input id="data_lavagem" name="data_lavagem" required autocomplete="off" class="input-datepicker form-control">
                                    </div>

                                </div>-->

                            <div class="text-center">
                                <a class="btn btn-info mb-20" onclick="atualizarDatasViatura('data_lavagem', '#modal-lavagem-viatura')" href="javascript:void(0)" > Prolongar </a>
                                <br>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal-km-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-body" style="padding: 10px;">
                <div class="text-center">

                    <h3><i class="fa fa-warning fa-3x"></i><br>Importante</h3>
                </div>
                <div class="block">
                    <div class="block-section" >

                        <div class="col-xs-12">



                                    <div class="col-lg-12 input-status">
                                        <label>Insrira os KM's atuais da viatura.</label><br>
                                        <i class="text-info">Kms registados antes: _kmAtuais_ km</i>
                                        <input id="kms_inicio" name="kms_inicio" min="_kmAtuais_" type="number" class="form-control">
                                    </div>



                            <div class="text-center">
                                <a class="btn btn-info mb-20" onclick="atualizarDatasViatura('kms_inicio', '#modal-km-viatura')" href="javascript:void(0)" > Atualizar </a>
                                <br>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal-kmrevisao-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-kmrevisao-viatura')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >

                        <div class="col-xs-12">
                            <div class="block-title">
                                <h2>Kilometros para Revisão</h2>
                            </div>
                            <div>
                                    <div class="col-lg-12 input-status">
                                        <label>Insrira os KM's da próxima revisão</label><br>
                                        <i class="text-info">Kms registados antes: _kmRevisao_ km</i>
                                        <input id="kms_revisao" name="kms_revisao" min="_kmRevisao_" type="number" class="form-control">
                                    </div>
                                </div>
                            <div class="text-center">
                                <a class="btn btn-info mb-20" onclick="atualizarDatasViatura('kms_revisao', '#modal-kmrevisao-viatura')" href="javascript:void(0)" > Atualizar </a>
                                <br>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="modal-kmpneus-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-kmpneus-viatura')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >

                        <div class="col-xs-12">
                            <div class="block-title">
                                <h2>Kilometros para troca de pneus</h2>
                            </div>
                            <div>
                                    <div class="col-lg-12 input-status">
                                        <label>Insrira os KM's da troca de pneus</label><br>
                                        <i class="text-info">Kms registados antes: _kmPneus_ km</i>
                                        <input id="kms_pneus" name="kms_pneus" min="_kmPneus_" type="number" class="form-control">
                                    </div>
                                </div>
                            <div class="text-center">
                                <a class="btn btn-info mb-20" onclick="atualizarDatasViatura('kms_pneus', '#modal-kmpneus-viatura')" href="javascript:void(0)" > Atualizar </a>
                                <br>
                                <br>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="modal-ver-viatura" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-ver-viatura')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">



            </div>
        </div>
    </div>
</div>


<div id="modal-ver-pesquisa" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-ver-pesquisa')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="col-lg-12 searchbar-div">

                    <!--  <select style="width:100%" class="selectjs form-control" id="" onchange="getClientes(this.value)" onkeyup="getClientes(this.value)">
                    <option></option>
                 </select>-->
                    <div class="text-center">
                        <input type="text" id="searchbar" class="searchbar"  placeholder="Pesquisa de clientes e máquinas"><!--onchange="getClientes(this.value)" onkeyup="getClientes(this.value)"-->
                    </div>
                    <div class="client-info" style="margin-top: 30px;">

                    </div>

                </div>


            </div>
        </div>
    </div>
</div>




<div id="modal-ver-botoes" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-ver-botoes')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h1><b>Adicionar</b></h1>
                            </div>

                            <div class="col-xs-12 text-center d-flex-c" style="padding-bottom: 20px">
                                <a class="btn btn-default mb-20" onclick="openModal('#modal-criar-assistencia')" href="javascript:void(0)" > Marcação </a>
                                <a class="btn btn-default mb-20" onclick="openModal('#modal-criar-maquina')" href="javascript:void(0)" > Máquina </a>
                              <!--  <a class="btn btn-success mb-20" onclick="openModal('#modal-historico-assistencias')" href="javascript:void(0)" > Ver historico de Assistências </a>
                                <a class="btn btn-info mb-20" onclick="" href="javascript:void(0)" > Despesa </a>-->
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="modal-criar-assistencia" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-criar-assistencia')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h1><b>Criar marcação</b></h1>
                            </div>

                            <div class="modal-body-content">

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal-detalhes-assistencia" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-detalhes-assistencia')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h1><b>Detalhes da Assistência</b></h1>
                            </div>

                            <div class="modal-body-content">

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal-criar-maquina" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-criar-maquina')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h1><b>Criar Máquina</b></h1>
                            </div>

                            <div class="modal-body-content">

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="modal-historico-assistencias" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-historico-assistencias')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h1><b>Histórico de Assistências</b></h1>
                            </div>



                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modal-ver-calendario" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">

            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"> <a href="javascript:void(0)" class="go-back-arrow text-light" onclick="closeModal('#modal-ver-calendario')"><i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>

            <div class="modal-body" style="padding: 10px;">

                <div class="block">
                    <div class="block-section" >
                        <div class="col-xs-12">

                            <div class="block-title">
                                <h1><b>Calendário</b></h1>
                            </div>


                            <!-- FullCalendar Block -->

                            <div id="calendar"></div>

                            <!-- END FullCalendar Block -->

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="modal-mostrar-historico-maquina" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden" id="id_assistencia_cliente_modal" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><a href="javascript:void(0)" class="go-back-arrow" onclick="closeModal('#modal-mostrar-historico-maquina')">  <i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">



            </div>
        </div>
    </div>
</div>


<div id="modal-mostrar-detalhes-maquina-historico" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <input class="hidden" id="id_assistencia_cliente_maquina_historico_modal" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><a href="javascript:void(0)" class="go-back-arrow" onclick="closeModal('#modal-mostrar-detalhes-maquina-historico')">  <i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <!-- Preenchido com AJAX -->

            </div>
        </div>
    </div>
</div>




<div id="modal-editar-marcacao" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><a href="javascript:void(0)" class="go-back-arrow" onclick="closeModal('#modal-editar-marcacao')">  <i class="fa fa-angle-left"></i> Voltar </a></h3>
                <a class="pull-right text-light" href="javascript:void(0)" id="apagar-marcacao"> <i class="fa fa-trash"></i> </a>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <!-- Preenchido com AJAX -->

            </div>
        </div>
    </div>
</div>




<div id="modal-mostrar-detalhes-cliente" class="modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog animate-bottom">
        <div class="modal-content">
            <input class="hidden" id="id_cliente" readonly>
            <div class="modal-header">
                <button type="button" class="close hidden" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><a href="javascript:void(0)" class="go-back-arrow" onclick="closeModal('#modal-mostrar-detalhes-cliente')">  <i class="fa fa-angle-left"></i> Voltar </a></h3>
            </div>
            <div class="modal-body" style="padding: 10px;">

                <!-- Preenchido com AJAX -->

            </div>
        </div>
    </div>
</div>






<!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
<script src="_layoutDirectory_/js/vendor/jquery-2.1.4.min.js"></script>

<link rel="stylesheet" href="../assets/PhotoSwipe/photoswipe.css">
<link rel="stylesheet" href="../assets/PhotoSwipe/default-skin/default-skin.css">
<script src="../assets/PhotoSwipe/photoswipe.js"></script>
<script src="../assets/PhotoSwipe/photoswipe-ui-default.js"></script>
<link rel="stylesheet" href="../assets/PhotoSwipe-rotate/docs/libs/createPhotoSwipe/0.4.1/createPhotoSwipe.css">
<script src="../assets/PhotoSwipe-rotate/docs/libs/createPhotoSwipe/0.4.1/createPhotoSwipe.js"></script>

<script src="_layoutDirectory_/js/vendor/bootstrap.min.js"></script>
<script src="_layoutDirectory_/js/plugins.js"></script>

<!--
<script src="_layoutDirectory_/js/plugins/chartjs/Chart.min.js" type="text/javascript"></script>
-->

<!-- clipboard.min.js

-->

<!-- jvectormap
<script src="_layoutDirectory_/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="_layoutDirectory_/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<script src="_layoutDirectory_/js/full-calendar-pt.js"></script>
-->
<script src="_layoutDirectory_/js/plugins/clipboard.min.js" type="text/javascript"></script>
<script src="_layoutDirectory_/js/pace.min.js"></script>
<script src="_layoutDirectory_/js/app.js"></script>
<script src="_layoutDirectory_/js/cropbox.js"></script>
<script src="_layoutDirectory_/js/clockpicker.js"></script>
<script src="_layoutDirectory_/js/plugins/fileinput.js"></script>
<script src="_layoutDirectory_/js/plugins/jquery.touchSwipe.min.js"></script>

<script src="_layoutDirectory_/js/plugins/leaflet/leaflet.js" crossorigin=""></script>
<script src='_layoutDirectory_/js/plugins/leaflet/leaflet-image.js'></script>

<script type="text/javascript" src="../assets/jquery.textcomplete.js"></script>
<script type="text/javascript" src="../assets/jquery-comments/js/jquery-comments.js"></script>
<script type="text/javascript" src="../assets/layout/js/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="../assets/layout/js/plugins/ckeditor/ckeditor.js"></script>

<script>var tempoLock=999999999999999999999999999;</script>
<script src="_layoutDirectory_/js/geral.js"></script>

_scriptBackgroudUpdate_
_pageScript_
</body>
</html>
