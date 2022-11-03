<style>
    html, body, #wrapper {
        height:100%;
        width: 100%;
        margin: 0;
        padding: 0;
        border: 0;
        background: #202226;
    }
    #wrapper td {
        vertical-align: middle;
        text-align: center;
    }
    .coin {
        background: url("../layout/img/icon180.png") no-repeat, #e1e1e1;
        background-size: 100% 100%;
        border-radius: 100%;
        height: 150px;
        margin: 50px auto;
        position: relative;
        width: 150px;
        -webkit-animation-name: spinner;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-duration: 2s;
        animation-name: spinner;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        animation-duration: 2s;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -ms-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }
    .coin:after {
        background-color: #e1e1e1;
        background-image: -webkit-linear-gradient(hsla(0,0%,100%,.25), hsla(0,0%,0%,.25));
        bottom: 0;
        content: '';
        left: 70px;
        position: absolute;
        top: 0;
        width: 5px;
        z-index: -10;
        -webkit-transform: rotateY(-90deg);
        -webkit-transform-origin: 100% 50%;
    }
    .coin:before {
        background-color: #ffffff;
        background-image: -webkit-linear-gradient(hsla(0,0%,100%,.25), hsla(0,0%,0%,.25));
        border-radius: 100%;
        content: '';
        height: 150px;
        left: 0;
        position: absolute;
        top: 0;
        width: 150px;
        -webkit-transform: translateZ(-5px);
    }
    .coin:hover {
        -webkit-transform: rotateY(90deg);
    }

    /* WebKit and Opera browsers */ @-webkit-keyframes spinner {
                                        from
                                        {
                                            -webkit-transform: rotateY(0deg);
                                        }
                                        to {
                                            -webkit-transform: rotateY(-360deg);
                                        }
                                    } /* all other browsers */
    @keyframes spinner {
        from {
            -moz-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);
            transform: rotateY(0deg);
        }
        to
        {
            -moz-transform: rotateY(-360deg);
            -ms-transform: rotateY(-360deg);
            transform: rotateY(-360deg);

        }
    }

</style>
<?php @session_start(); print "<link rel=\"stylesheet\" href=\"../layout/css/themes/".$_SESSION['cfg']['temaPlataforma']."\">" ?>
<html>
<body>
<table id="wrapper">
    <tr>
        <td style="color:white"> A iniciar sessão em segurança. <br>Por favor aguarde...</td>
    </tr>
</table>
</body>
</html>