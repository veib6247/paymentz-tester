<?php include "../scripts/components.php";  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Processing</title>
  <!-- bulma -->
  <link rel="stylesheet" href="../css/bulmaswatch_yeti.min.css">
  <!-- tab icon -->
  <link rel="shortcut icon" href="./resources/diagram.svg">
  <!-- font: Roboto Mono -->
  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
</head>

<body>
  <section class="hero is-warning is-fullheight" style="font-family: 'Roboto Mono', monospace;">
    <div class="hero-body">
      <div class="container">
        <h1 class="title">
          Processing your request
        </h1>
        <h2 class="subtitle">
          Please wait...
        </h2>
      </div>
    </div>
  </section>
  <section class="section" style="display: none;">
    <div class="container">
      <!-- txt_endpoint => URL -->
      <form name="all_parameters" action="<?= $_POST['txt_endpoint'] ?>" method="post">

        <?php
        /**
         * get posted values and split parameters by line
         */
        $parameters_array = explode("\n", $_POST['txt_params']);
        foreach ($parameters_array as $line) {
          # get the value before the = sign, limit explode to only 2 indexes
          $data = explode("=", $line, 2);
          # echo as inputs
          echo input(
            $data[0],
            $data[0],
            $data[0],
            '',
            '',
            $data[1]
          );
        }
        ?>
      </form>
    </div>
  </section>

  <script>
    // submit the form once everything is loaded
    window.onload = function() {
      document.forms['all_parameters'].submit();
    }
  </script>
</body>

</html>