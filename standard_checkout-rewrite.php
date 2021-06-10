<?php include "./scripts/components.php";  ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PRTPG - Standard Checkout Tester</title>
  <!-- bulma -->
  <link rel="stylesheet" href="./css/bulma.min.css">
  <!-- font: Roboto Mono -->
  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
  <!-- vue -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> -->
  <!-- production version, optimized for size and speed -->
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <!-- axios -->
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <!-- tab icon -->
  <link rel="shortcut icon" href="./resources/diagram.svg">
  <!-- ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule="" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.js"></script>

</head>

<body>
  <!-- hero -->
  <section class="hero is-light" style="font-family: 'Roboto Mono', monospace; background-position: center top;">
    <div class="hero-body">
      <div class="container">
        <p class="title">
          PRTPG Gateway Tester
          <span class="icon">
            <ion-icon name="construct"></ion-icon>
          </span>
        </p>
      </div>
    </div>
    <div class="hero-foot">
      <nav class="tabs is-boxed">
        <div class="container">
          <ul>
            <li class="is-active">
              <a href="standard_checkout-rewrite.php">
                <span class="icon">
                  <ion-icon name="card"></ion-icon>
                </span>
                Standard Checkout
              </a>
            </li>
            <li>
              <a href="rest_request.php">
                <span class="icon">
                  <ion-icon name="git-network"></ion-icon>
                </span>
                REST API Integration
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </section>

  <!-- main -->
  <section id="main" class="section">
    <div class="container">
      <div class="notification">
        <form action="./scripts/parameter_receiver.php" method="post">
          <?=
            input(
              'txt_endpoint',
              'txt_endpoint',
              'API Endpoint',
              '',
              'Determine which endpoint to send the transaction',
              '',
              '',
              'v-model="request.endpoint" '
            )
          ?>

          <?=
            input(
              'txt_checksum',
              'txt_checksum',
              'Checksum Data',
              '<memberId>|<toType>|<amount>|<merchantTransactionId>|<merchantRedirectUrl>|<secureKey>',
              'Generated Hash: <span class="tag is-dark">{{checksum.hash}}</span>',
              '',
              '',
              'v-model="checksum.data" @blur="generate_hash" @change="generate_hash" required'
            )
          ?>

          <?php // replace with <?= to echo the button
          // button(
          //   'btn_add_to_params',
          //   'btn_add_to_params',
          //   'Add to parameters',
          //   'is-small is-primary',
          //   '@click="add_to_params" '
          // )
          ?>

          <div class="field">
            <div class="control">
              <label for="" class="label is-small" style="font-family: 'Roboto Mono', monospace;">Parameters</label>
              <textarea class="textarea is-small" name="txt_params" id="txt_params" cols="30" rows="25" placeholder=""
                rows="28" spellcheck="false" style="font-family: 'Roboto Mono', monospace;"
                v-model="parameter_to_string"></textarea>
            </div>
          </div>
          <!-- submit to script to generate the form -->
          <div class="field control">
            <button type="submit" class="button is-small is-dark" style="font-family: 'Roboto Mono', monospace;">
              <span class="icon">
                <ion-icon name="send"></ion-icon>
              </span>
              <span>Submit Request</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- footer -->
  <footer class="footer">
    <div class="container">
      <div class="columns">
        <div class="column">
          <h1 class="title">
            References
          </h1>
          <ul>
            <li>
              <a href="https://docs.prtpg.com/integration/standard-checkout.php" target="_blank">
                <span class="icon">
                  <ion-icon name="chevron-forward"></ion-icon>
                </span>
                Standard Checkout
              </a>
            </li>
            <li>
              <a href="https://docs.prtpg.com/integration/overview.php" target="_blank">
                <span class="icon">
                  <ion-icon name="chevron-forward"></ion-icon>
                </span>
                REST API Overview
              </a>
            </li>
            <li>
              <a href="https://docs.prtpg.com/integration/rest-api-specifications.php" target="_blank">
                <span class="icon">
                  <ion-icon name="chevron-forward"></ion-icon>
                </span>
                REST API Specs
              </a>
            </li>
          </ul>
        </div>

        <div class="column">
          <h1 class="title">
            Contact Me
          </h1>
          <ul>
            <li>
              <a href="mailto:ozoneblacklight@gmail.com">
                <span class="icon">
                  <ion-icon name="mail"></ion-icon>
                </span>
                ozoneblacklight@gmail.com
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>


  <script src="./js/standard_checkout.js"></script>
</body>

</html>