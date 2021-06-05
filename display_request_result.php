<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Display Request Results</title>
  <!-- bulma -->
  <link rel="stylesheet" href="./css/bulma/css/bulma.min.css">
  <!-- font: Roboto Mono -->
  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
  <!-- tab icon -->
  <link rel="shortcut icon" href="./resources/diagram.svg">
  <!-- ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule="" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.js"></script>
  
  <script data-ad-client="ca-pub-5022207804198581" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<body>
  <!-- hero -->
  <section class="hero" style="font-family: 'Roboto Mono', monospace;">
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
            <li>
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
            <li class="is-active">
              <a>
                <span class="icon">
                  <ion-icon name="newspaper"></ion-icon>
                </span>
                Transaction Results
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </section>


  <section class="section" style="font-family: 'Roboto Mono', monospace;">
    <div class="container">
      <div class="notification">

        <h1 class="title is-size-4">
          Transaction Details
        </h1>
        <p class="subtitle is-size-6">
          The table below displays all the POSTed value from the transaction response.
        </p>

        <hr>
        <div class="table-container">
          <table class="table is-size-7 is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <tbody>
              <?php
              foreach ($_POST as $key => $value) {
                echo '
                <tr>
                  <td>' . $key . '</td>
                  <td>' . $value . '</td>
                </tr>';
              }
              ?>

            </tbody>
          </table>
        </div>

        <hr>

        <article class="message is-small is-dark">
          <div class="message-body">
            If this transaction does not appear anywhere in the <span class="tag is-dark">Transaction Management moedule</span> in the gateway, please check the <strong>Rejected Transactions</strong> module instead.
          </div>
        </article>
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
</body>

</html>