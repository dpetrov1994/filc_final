<!DOCTYPE html>
<html lang="pt" >

<head>
  <meta charset="UTF-8">
  <title></title>
      <style>
          body {
              background-color: #FDC800;
              overflow: hidden;
              text-align: center;
          }

          body,
          html {
              height: 100%;
              width: 100%;
              margin: 0;
              padding: 0;
          }

          #animationWindow {
              width: 100%;
              height: 100%;
          }
      </style>
    <?php @session_start(); print "<link rel=\"stylesheet\" href=\"../layout/css/themes/".$_SESSION['cfg']['temaPlataforma']."\">" ?>
</head>

<body>

  <body>

  <div id="animationWindow">
  </div>
	</body>
  
  

    <script>
        var animData = {
            wrapper: document.querySelector('#animationWindow'),
            animType: 'svg',
            loop: true,
            prerender: true,
            autoplay: true,
            path: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/LEGO_loader.json'
        };
        var anim = bodymovin.loadAnimation(animData);
        anim.setSpeed(3.4);



    </script>




</body>

</html>
