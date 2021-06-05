/**
 * root vue instance
 */
var app = new Vue({
  el: "#main_app",
  /**
   * all the data!
   */
  data: {
    /**
     * use these for getting the auth data
     */
    auth: {
      endpoint:
        "https://preprod.prtpg.com/transactionServices/REST/v1/authToken",
      response: "",
    },
    button: {
      auth_is_processing: false,
    },
    checksum: {
      data_string: "<memberId>|<secureKey>|<merchantTransactionId>|<amount>",
      hash: "MD5 value will appear here.",
    },

    parameters_auth: [
      "authentication.partnerId=REPLACE_ME",
      "merchant.username=REPLACE_ME",
      "authentication.sKey=REPLACE_ME",
    ],
    parameters: [
      "authentication.memberId=REPLACE_ME",
      "authentication.terminalId=REPLACE_ME",
      "merchantTransactionId=REPLACE_ME",
      "amount=REPLACE_ME",
      "currency=REPLACE_ME",
      "orderDescriptor=Test Transaction",
      "shipping.country=PH",
      "shipping.city=Makati",
      "shipping.state=NCR",
      "shipping.postcode=1227",
      "shipping.street1=Valero St.",
      "customer.telnocc=63",
      "customer.phone=9294112356",
      "customer.email=test@test.com",
      "customer.givenName=Test",
      "customer.surname=Tester",
      "customer.ip=192.168.0.1",
      "customer.birthDate=19930528",
      "card.number=4111110000000021",
      "card.expiryMonth=12",
      "card.expiryYear=2030",
      "card.cvv=123",
      "paymentBrand=REPLACE_ME",
      "paymentMode=REPLACE_ME",
      "paymentType=REPLACE_ME",
      "authentication.checksum=REPLACE_ME",
    ],
    request: {
      url: "https://preprod.prtpg.com/transactionServices/REST/v1/payments",
      response: "",
    },

    response: {
      blank_result: "Blank",
    },

    /**
     * container for the redirect parameters for 3D
     */
    redirect_parameters: "",
  },
  /**
   * all the methods here
   */
  methods: {
    submit_auth_request: function () {
      // update button state
      this.button.auth_is_processing = true;
      this.auth.response = "";
      /**
       * post via axios,
       * apparently, the data can't be just a string so I have to use URLSearchParams
       */
      const url = "./scripts/request_auth.php";
      let data = new URLSearchParams();
      data.append("url", this.auth.endpoint);

      /**
       * build data string
       */
      let data_auth_string = "";
      const textarea = document.querySelector("#txt_auth_params");
      const param_array = textarea.value.split("\n");

      param_array.forEach((element, index) => {
        index !== param_array.length - 1
          ? (data_auth_string += element + "&")
          : (data_auth_string += element);
      });

      // append the data string
      data.append("data", data_auth_string);

      // post URL and DATA via axios
      axios
        .post(url, data)
        .then((response) => {
          console.trace(response);
          this.auth.response = response;
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          this.button.auth_is_processing = false;
          document.getElementById("auth_result").scrollIntoView();
        });
    },

    /**
     * method to generate the checksum
     */
    generate_checksum_hash: function () {
      const url = "./scripts/generate_md5.php";
      let data = new URLSearchParams();

      data.append("string", this.checksum.data_string);
      // post via axios
      axios
        .post(url, data)
        .then((response) => {
          this.checksum.hash = response.data;
        })
        .catch((error) => {
          // display error in the <p>
          this.checksum.hash = error;
        })
        .finally(() => {
          this.add_to_parameters();
        });
    },

    /**
     * add the hash to the textarea/parameter array
     */
    add_to_parameters: function () {
      // container for array index to pop
      this.parameters.forEach((item, index) => {
        /**
         * find the specific array index and pop it then replace with the hash
         */
        if (item.slice(0, 23) == "authentication.checksum") {
          // remove the item
          this.parameters.splice(index, 1);
          // replace with the updated with the checksum
          this.parameters.push("authentication.checksum=" + this.checksum.hash);
        }
      });
    },

    /**
     * submit the full request
     */
    submit_request: function () {
      // update button state, start loading animation
      this.button.auth_is_processing = true;
      this.request.response = "";
      /**
       * build data string
       */
      const textarea = document.querySelector("#txt_param").value.split("\n");
      let data_string = "";

      textarea.forEach((item, index) => {
        index !== textarea.length - 1
          ? (data_string += item + "&")
          : (data_string += item); // do not append '&' at the end of the string
      });

      // initialize POST variables
      const url = "./scripts/request_submit.php";
      let data = new URLSearchParams();
      data.append("url", this.request.url);
      data.append("data", data_string);

      /**
       * if the user clicks the send request before the token was generated,
       * send a fake token to emmit error
       */
      if (typeof this.auth.response.data != "undefined") {
        data.append("token", this.auth.response.data.AuthToken);
      } else {
        data.append("token", "NO_TOKEN_GENERATED");
      }

      // post using axios
      axios
        .post(url, data)
        .then((response) => {
          console.trace(response);
          this.request.response = response;

          /**
           * check if the redirect object exist
           */
          if (response.data.redirect) {
            this.redirect_parameters = response.data.redirect;
          }
        })
        .catch((error) => {
          // display the error
          this.request.response = error;
        })
        .finally(() => {
          // stop loading animation
          this.button.auth_is_processing = false;
          document.getElementById("trx_result").scrollIntoView();
        });
    },

    /**
     * on select dropdown is changed
     */
    update_paramenters: function (event) {
      // get selected item
      // console.log('Selected: ' + event.target.options[event.target.selectedIndex].text)
      const item = event.target.options[event.target.selectedIndex].text;

      switch (item) {
        case "Synchronous":
          this.parameters = [
            "authentication.memberId=REPLACE_ME",
            "authentication.terminalId=REPLACE_ME",
            "merchantTransactionId=REPLACE_ME",
            "amount=REPLACE_ME",
            "currency=REPLACE_ME",
            "orderDescriptor=Test transaction",
            "shipping.country=PH",
            "shipping.city=Makati",
            "shipping.state=NCR",
            "shipping.postcode=1227",
            "shipping.street1=Valero St.",
            "customer.telnocc=63",
            "customer.phone=9294112356",
            "customer.email=test@test.com",
            "customer.givenName=Test",
            "customer.surname=Tester",
            "customer.ip=192.168.0.1",
            "customer.birthDate=19930528",
            "card.number=4111110000000021",
            "card.expiryMonth=12",
            "card.expiryYear=2030",
            "card.cvv=123",
            "paymentBrand=REPLACE_ME",
            "paymentMode=REPLACE_ME",
            "paymentType=REPLACE_ME",
          ];
          this.generate_return_url();
          break;

        case "Back Office":
          this.parameters = [
            "authentication.memberId=REPLACE_ME",
            "authentication.checksum=REPLACE_ME",
            "paymentType=IN",
            "idType=PID",
            "paymentId=REPLACE_ME",
          ];
          break;

        case "Payout":
          this.parameters = [
            "authentication.memberId=REPLACE_ME",
            "authentication.checksum=REPLACE_ME",
            "merchantTransactionId=REPLACE_ME",
            "amount=50.00",
            "paymentId=REPLACE_ME",
            "authentication.terminalId=REPLACE_ME",
            "merchant.email=test@test.com",
          ];
          break;

        case "Cx Signup":
          this.parameters = [
            "authentication.memberId=REPLACE_ME",
            "authentication.checksum=REPLACE_ME",
            "customer.givenName=Bruce",
            "customer.surname=Wayne",
            "customer.sex=Male",
            "customer.email=test@test.com",
            "customer.phone=1234567890",
            "shipping.country=US",
            "shipping.postcode=111401",
            "customer.birthDate=19981202",
          ];
          break;

        case "RG (Standalone)":
          this.parameters = [
            "authentication.memberId=REPLACE_ME",
            "authentication.checksum=REPLACE_ME",
            "shipping.language=ENG",
            "shipping.country=PH",
            "shipping.city=Makati",
            "shipping.state=NCR",
            "shipping.postcode=1227",
            "shipping.street=Valero St.",
            "customer.telnocc=63",
            "customer.phone=9854789658",
            "customer.email=test@test.com",
            "shipping.givenName=Test",
            "shipping.surname=Tester",
            "customer.ip=192.168.0.1",
            "customer.birthDate=19890202",
            "card.number=REPLACE_ME",
            "card.expiryMonth=REPLACE_ME",
            "card.expiryYear=REPLACE_ME",
            "card.cvv=REPLACE_ME",
            "paymentBrand=VISA",
            "paymentMode=CC",
            "[customer.customerId=REPLACE_ME]",
            "createRegistration=true",
          ];
          break;

        case "Trx w/ Token":
          this.parameters = [
            "authentication.memberId=REPLACE_ME",
            "authentication.checksum=REPLACE_ME",
            "authentication.terminalId=REPLACE_ME",
            "amount=50.00",
            "currency=EUR",
            "card.cvv=REPLACE_ME",
            "paymentType=DB",
            "customer.ip=192.168.0.1",
            "redirectMethod=GET/POST",
            "[installment=3]",
          ];
          this.generate_return_url();
          break;

        case "Delete Token":
          this.parameters = [
            "authentication.memberId=REPLACE_ME",
            "authentication.checksum=REPLACE_ME",
            "authentication.terminalId=REPLACE_ME",
            "paymentType=DL",
          ];
          break;

        case "List Tokens":
          this.parameters = [
            "authentication.memberId=REPLACE_ME",
            "authentication.checksum=REPLACE_ME",
          ];
      }
    },

    /**
     * build string for redirect url
     */
    generate_return_url: function () {
      const href = window.location.href;
      // get url path except last segment
      let redir =
        href.substring(0, href.lastIndexOf("/")) +
        "/display_request_result.php";
      // push string to default parameters array
      this.parameters.push("merchantRedirectUrl=" + redir);
    },

    /**
     * create HTML form and submit
     */
    goto_acs_page: function () {
      // create the form element
      const form = document.createElement("form");
      document.body.appendChild(form);
      form.method = "post";
      form.action = this.redirect_parameters.url;

      // append the parameters as text areas
      const data = this.redirect_parameters.parameters;

      // this object will contain every name=value pair one at a time
      let obj_container = {};

      /**
       * create inputs for each parameter and append to the form
       */
      for (const property in data) {
        obj_container = data[property];
        let input = document.createElement("input");
        input.type = "hidden";
        input.name = obj_container.name;
        input.value = obj_container.value;

        // add to form
        form.appendChild(input);
      }

      // submit the created form
      form.submit();
    },
  },

  /**
   * computed shite here
   */
  computed: {
    /**
     * build string for authorization
     */
    build_auth_data_string: {
      get: function () {
        data_string = "";

        this.parameters_auth.forEach((element, index) => {
          index !== this.parameters_auth.length - 1
            ? (data_string += element + "\n")
            : (data_string += element);
        });

        return data_string;
      },

      set: function () {
        const textarea = document.querySelector("#txt_auth_params");
        const param_array = textarea.value.split("\n");
        // clear the array
        this.parameters_auth = [];
        // push new items
        param_array.forEach((element) => {
          this.parameters_auth.push(element);
        });
      },
    },

    /**
     * process the array so that the textarea will render it properly
     */
    parameter_string: {
      // getter
      get: function () {
        let parameter_string = "";
        this.parameters.forEach((element, index) => {
          // if it's not the end of the array yet
          index !== this.parameters.length - 1
            ? (parameter_string += element + "\n")
            : (parameter_string += element);
        });
        return parameter_string;
      },

      // setter
      set: function () {
        const textarea = document.querySelector("#txt_param");
        const param_array = textarea.value.split("\n");
        // clear the array
        this.parameters = [];
        // push new items
        param_array.forEach((element) => {
          this.parameters.push(element);
        });
      },
    },
  },

  /**
   * MOUNTED
   */
  mounted: function () {
    this.generate_return_url();
  },
});

/**
 * component to display auth response in a textarea
 */
Vue.component("display-auth-result", {
  props: ["response"],
  template: `
    <div>
      <div class="field">
        <label for="txt_auth_response" class="label is-medium" style="font-family: 'Roboto Mono', monospace;">Data</label>
        <div class="control">
          <textarea name="txt_auth_response" id="txt_auth_response" cols="30" rows="11" class="textarea is-small" style="font-family: 'Roboto Mono', monospace;" spellcheck="false">{{response.data}}</textarea>
        </div>
      </div>

      <article class="message is-small is-dark" style="font-family: 'Roboto Mono', monospace;">
        <div class="message-body">
          Take note that your <span class="tag is-dark">Authorization Token</span> is only valid for 1 hour, after which you will have to generate a new one.
        </div>
      </article>
    </div>
  `,
});

/**
 * component to display request result
 */
Vue.component("display-result", {
  props: ["response"],
  template: `
    <div>
      <div class="field">
        <label for="txt_response" class="label is-medium" style="font-family: 'Roboto Mono', monospace;">Data</label>
        <div class="control">
        <textarea name="txt_response" id="txt_response" cols="30" rows="25" class="textarea is-small" style="font-family: 'Roboto Mono', monospace;" spellcheck="false">{{response.data}}</textarea>
        </div>
      </div>
    </div>
  `,
});
