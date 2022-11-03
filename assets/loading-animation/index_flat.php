<style>


    html, body, #wrapper {
        height:100%;
        width: 100%;
        margin: 0;
        padding: 0;
        border: 0;
    }
    #wrapper td {
        vertical-align: middle;
        text-align: center;
    }

    #slidecaption {
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
<?php session_start(); print "<link rel=\"stylesheet\" href=\"../layout/css/themes/".$_SESSION['cfg']['temaPlataforma']."\">" ?>
<html>
<body>
<table id="wrapper">
    <tr>
        <td><img id="slidecaption" src="../layout/img/icon180.png" alt="Aguarde.." /></td>
    </tr>
</table>
</body>
</html>