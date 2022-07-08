<?php include "./scripts/components.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- meta -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PRTPG API Tester</title>
  <!-- bulma -->
  <link rel="stylesheet" href="./css/bulma.min.css">
  <!-- font: Roboto Mono -->
  <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">

  <!-- axios -->
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

  <!-- smooth scroll -->
  <style>
  html {
    scroll-behavior: smooth;
  }
  </style>

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
            <li>
              <a href="standard_checkout-rewrite.php">
                <span class="icon">
                  <ion-icon name="card"></ion-icon>
                </span>
                Standard Checkout
              </a>
            </li>
            <li class="is-active">
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
  <section class="section" id="main_app">
    <div class="container">


      <!-- STEP 1 -->
      <div class="notification">
        <h1 class="title is-4">
          Step 1
        </h1>
        <h2 class="subtitle is-6">
          Generate an Auth Token
        </h2>


        <?=
input(
 'txt_auth_endpoint',
 'txt_auth_endpoint',
 'API Endpoint',
 'e.g. https://preprod.prtpg.com/transactionServices/REST/v1/authToken',
 '',
 '',
 '',
 'v-model="auth.endpoint" '
)
?>

        <!-- textarea for auth parameters -->
        <div class="field">
          <label for="txt_auth_params" class="label is-small"
            style="font-family: 'Roboto Mono', monospace;">Authorization Parameters</label>
          <div class="control">
            <textarea name="txt_auth_params" id="txt_auth_params" class="textarea is-small" placeholder="" rows="3"
              spellcheck="false" style="font-family: 'Roboto Mono', monospace;"
              v-model="build_auth_data_string"></textarea>
          </div>
        </div>

        <?=
button(
 'btn_auth',
 'btn_auth',
 'Get Auth Key',
 'is-small is-dark',
 '@click="submit_auth_request" :class="{\'is-loading\': button.auth_is_processing}" '
)
?>


        <!-- display component -->
        <display-auth-result id="auth_result" v-if="auth.response" :response="auth.response">
        </display-auth-result>
      </div>





      <!-- STEP 2 -->
      <div class="notification">
        <h1 class="title is-4">
          Step 2
        </h1>
        <h2 class="subtitle is-6">
          Generate a Checksum
        </h2>
        <p class="is-size-7">
          Our system will generate the hash string. You only need to input the correct format. This is required to check
          the integrity of the request.
        </p>
        <br />

        <label for="txt_checksum_string" class="label is-small" style="font-family: 'Roboto Mono', monospace;">Checksum
          Data</label>
        <div class="field has-addons">
          <div class="control is-expanded">
            <input type="text" name="txt_checksum_string" id="txt_checksum_string" class="input is-small"
              spellcheck="false" style="font-family: 'Roboto Mono', monospace;" v-model="checksum.data_string"
              @blur="generate_checksum_hash" @change="generate_checksum_hash">
          </div>
          <div class="control">
            <div class="select is-small">
              <!-- call method when value changes -->
              <select v-model="checksum.data_string" style="font-family: 'Roboto Mono', monospace;">
                <option value="<memberId>|<secureKey>|<merchantTransactionId>|<amount>">Synchronous</option>
                <option value="<memberId>|<secureKey>|<paymentId>|<amount>">Capture/Refund</option>
                <option value="<memberId>|<secureKey>|<paymentId>">Inquire/Cancel</option>
                <option value="<memberId>|<merchantTransactionId>|<amount>|<secureKey>">Payout</option>
                <option value="<memberId>|<secureKey>|<merchantTransactionId>|<amount>">RG@payment</option>
                <option value="<memberId>|<secureKey>|<cardNumber>/<bic>">RG (Standalone)</option>
                <option value="<memberId>|<secureKey>|<registrationId>|<amount>">Using RG</option>
                <option value="<memberId>|<secureKey>|<registrationId>">Del RG</option>
                <option value="<merchantId>|<Merchant's secureKey>|<givenName>|<surname>|<email>">Cx RG - M</option>
                <option value="<partnerId>|<Partner's secureKey>|<givenName>|<surname>|<email>">Cx RG - P</option>
                <option value="<merchantId>|<Merchant's secureKey>">List RG - M</option>
                <option value="<partnerId>|<Partner's secureKey>">List RG - P</option>
                <option value="<memberid>|<secureKey>|<registrationId>">List Inst</option>
              </select>
            </div>
          </div>
        </div>






        <article class="message is-small is-dark" style="font-family: 'Roboto Mono', monospace;">
          <div class="message-body">
            Generated Hash: <span class="tag is-dark">{{checksum.hash}}</span>
          </div>
        </article>






      </div>
      <!-- STEP 3 -->
      <div class="notification">
        <h1 class="title is-4">
          Step 3
        </h1>
        <h2 class="subtitle is-6">
          Fill up additional parameters
        </h2>

        <label for="txt_request_endpoint" class="label is-small" style="font-family: 'Roboto Mono', monospace;">API
          Endpoint</label>
        <div class="field has-addons">
          <div class="control is-expanded">
            <input type="text" name="txt_request_endpoint" id="txt_request_endpoint" class="input is-small"
              spellcheck="false" style="font-family: 'Roboto Mono', monospace;" v-model="request.url">
          </div>
          <div class="control">
            <div class="select is-small">
              <!-- call method when value changes -->
              <select v-model="request.url" @change="update_paramenters($event)"
                style="font-family: 'Roboto Mono', monospace;">
                <option value="https://preprod.prtpg.com/transactionServices/REST/v1/payments">Synchronous</option>
                <option value="https://preprod.prtpg.com/transactionServices/REST/v1/payments/{id}">Back Office</option>
                <option value="https://preprod.prtpg.com/transactionServices/REST/v1/payout">Payout</option>
                <option value="https://preprod.prtpg.com/merchantServices/api/v1/customerSignup">Cx Signup</option>
                <option value="https://preprod.prtpg.com/transactionServices/REST/v1/registrations">RG (Standalone)
                </option>
                <option value="https://preprod.prtpg.com/transactionServices/REST/v1/paywithtoken/{id}">Trx w/ Token
                </option>
                <option value="https://preprod.prtpg.com/transactionServices/REST/v1/paywithtoken/[id]">Delete Token
                </option>
                <option value="https://preprod.prtpg.com/transactionServices/REST/v1/getCardsAndAccounts">List Tokens
                </option>
              </select>
            </div>
          </div>
        </div>



        <div class="field">
          <label for="txt_param" class="label is-small"
            style="font-family: 'Roboto Mono', monospace;">Parameters</label>
          <div class="control">
            <textarea id="txt_param" class="textarea is-small" placeholder="" rows="28" spellcheck="false"
              style="font-family: 'Roboto Mono', monospace;" v-model="parameter_string"></textarea>
          </div>
        </div>

        <?=
button(
 'btn_submit_request',
 'btn_submit_request',
 'Submit Request',
 'is-small is-dark',
 '@click="submit_request" :class="{\'is-loading\': button.auth_is_processing}" '
)
?>

        <!-- display request result here -->
        <display-result id="trx_result" v-if="request.response" :response="request.response">
        </display-result>


        <br>
        <!--
          if the redirect object property exist,
          show the user the button
        -->
        <div class="field" v-if="redirect_parameters">
          <div class="control">
            <button class="button is-small is-dark" @click="goto_acs_page">
              Go to ACS Page
            </button>
          </div>
        </div>
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

  <!-- self host vue 2 -->
  <script src="./js/vue.min.js"></script>

  <!-- local js -->
  <script src="./js/app.js"></script>

  <!-- ko-fi floating widget button -->
  <script src='https://storage.ko-fi.com/cdn/scripts/overlay-widget.js'></script>
  <script>
    kofiWidgetOverlay.draw('fukazer0', {
      'type': 'floating-chat',
      'floating-chat.donateButton.text': 'Support me',
      'floating-chat.donateButton.background-color': '#5bc0de',
      'floating-chat.donateButton.text-color': '#323842'
    });
  </script>
</body>

</html>