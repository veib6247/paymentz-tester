/**
 * root vue instance
 */
var app = new Vue({
  el: "#main",
  /**
   * ALL THE DATA
   */
  data: {
    request: {
      endpoint: "https://preprod.prtpg.com/transaction/Checkout",
    },

    checksum: {
      data:
        "<memberId>|<toType>|<amount>|<merchantTransactionId>|<merchantRedirectUrl>|<secureKey>",
      hash: "MD5 value will appear here.",
    },

    parameters: {
      default: [
        "memberId=REPLACE_ME",
        "totype=REPLACE_ME",
        "merchantTransactionId=REPLACE_ME",
        "amount=REPLACE_ME",
        "orderDescription=Test Transaction",
        "country=PH",
        "city=Makati",
        "state=NCR",
        "postcode=1227",
        "street=Valero St.",
        "telnocc=63",
        "phone=9854785236",
        "email=test@test.com",
        "ip=192.168.0.1",
        "currency=REPLACE_ME",
        "terminalid=REPLACE_ME",
        "reservedField1=",
        "paymentMode=REPLACE_ME",
        "paymentBrand=REPLACE_ME",
        "checksum=REPLACE_ME",
      ],
    },
  },

  /**
   * ALL THE METHODS
   */
  methods: {
    /**
     * add generated hash to text area
     */
    add_to_params: function () {
      console.log("function called");
      // container for array index to pop
      this.parameters.default.forEach((item, index) => {
        /**
         * find the specific array index and pop it then replace with the hash
         */
        if (item.slice(0, 8) == "checksum") {
          // remove the item
          this.parameters.default.splice(index, 1);
          // replace with the updated with the checksum
          this.parameters.default.push("checksum=" + this.checksum.hash);
        }
      });

      // if (this.checksum.data !== "") {
      //   const textarea = document.querySelector("#txt_params");
      //   textarea.value += "\nchecksum=" + this.checksum.hash;
      // } else {
      //   alert("Checksum Data must not be empty!");
      // }
    },

    /**
     * axios to post to script
     */
    generate_hash: function () {
      const url = "./scripts/generate_md5.php";
      let data = new URLSearchParams();
      data.append("string", this.checksum.data);
      // ~
      axios
        .post(url, data)
        .then((response) => {
          this.checksum.hash = response.data;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.add_to_params();
        });
    },
    /**
     * submit
     */
    submit_request: function () {
      if (this.checksum.data !== "") {
        // do to
      } else {
        alert("Checksum Data must not be empty!");
      }
    },
  },

  /**
   * ALL COMPUTED STUFF
   */
  computed: {
    parameter_to_string: {
      /**
       * returns string for textarea
       */
      get: function () {
        let parameter_string = "";
        this.parameters.default.forEach((element, index) => {
          // if it's not the end of the array yet
          index !== this.parameters.default.length - 1
            ? (parameter_string += element + "\n")
            : (parameter_string += element);
        });

        return parameter_string;
      },

      /**
       * updates parameters array
       */
      set: function () {
        const textarea = document.querySelector("#txt_params");
        const param_array = textarea.value.split("\n");
        // clear the array
        this.parameters.default = [];
        // push new items
        param_array.forEach((element) => {
          this.parameters.default.push(element);
        });
      },
    },
  },

  /**
   * MOUNTED
   */
  mounted: function () {
    /**
     * build string for redirect url
     */
    const href = window.location.href;
    // get url path except last segment
    let redir =
      href.substring(0, href.lastIndexOf("/")) + "/display_request_result.php";
    // push string to default parameters array
    this.parameters.default.push("merchantRedirectUrl=" + redir);
  },
});
