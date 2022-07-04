// main vue instance
const app = Vue.createApp({
  data() {
    return {
      pspPartnerID: "",
      merchantUsername: "",
      merchantSKey: "",
      getTokenButtonLoading: false,
      apiEndpoints: [
        "https://preprod.prtpg.com/transactionServices/REST/v1/authToken",
        "https://secure.prtpg.com/transactionServices/REST/v1/authToken",
      ],
      apiSelectedEndpoint:
        "https://preprod.prtpg.com/transactionServices/REST/v1/authToken",
      getTokenResponse: "",
      authToken: "",
      rangeFrom: "",
      rangeTo: "",
      statusSelect: [
        "begun",
        "authstarted",
        "authsuccessful",
        "authfailed",
        "authcancelled",
        "cancelstarted",
        "cancelled",
        "capturestarted",
        "capturesuccess",
        "capturefailed",
        "markedforreversal",
        "reversed",
        "chargeback",
        "failed",
        "payoutstarted",
        "payoutsuccessful",
        "payoutfailed",
      ],
      selectedStatus: "capturesuccess",
      hash: "",
      queryButtonLoading: false,
      queryEndpoints: [
        "https://preprod.prtpg.com/transactionServices/REST/v1/getTransactionList",
        "https://secure.prtpg.com/transactionServices/REST/v1/getTransactionList",
      ],
      selectedqueryEndpoint:
        "https://preprod.prtpg.com/transactionServices/REST/v1/getTransactionList",
      queryResult: "",
    };
  },

  methods: {
    async submitGetAuthToken() {
      try {
        // set button loading
        this.getTokenButtonLoading = true;

        // clear previous results
        this.getTokenResponse = "";

        // fetch
        const response = await fetch("./php/getAuthToken.php", {
          // Adding method type
          method: "POST",
          // Adding headers to the request
          headers: {
            "Content-type": "application/json; charset=UTF-8",
          },
          // Adding body or contents to send
          body: JSON.stringify({
            selectedEndpoint: this.apiSelectedEndpoint,
            partnerId: this.pspPartnerID,
            username: this.merchantUsername,
            sKey: this.merchantSKey,
          }),
        });
        // receive promise and parse into json
        const data = await response.json();
        // store API response from server
        this.getTokenResponse = data;
        // store the actual token if the object exists
        if (data.AuthToken) {
          this.authToken = data.AuthToken;
        }
      } catch (error) {
        console.error(error);
      } finally {
        // set button loading
        this.getTokenButtonLoading = false;
      }
    },

    async getQuery() {
      try {
        // set button loading
        this.queryButtonLoading = true;
        // fetch to generate md5 hash
        const responseHash = await fetch("./php/getHash.php", {
          // Adding method type
          method: "POST",
          // Adding headers to the request
          headers: {
            "Content-type": "application/json; charset=UTF-8",
          },
          // Adding body or contents to send
          body: JSON.stringify({
            data: `${this.getTokenResponse.memberId}|${this.merchantSKey}`,
          }),
        });
        // parse into plain text (string)
        const dataHash = await responseHash.text();
        // store into local variable
        this.hash = dataHash;

        // fetch send query to server script
        const response = await fetch("./php/query.php", {
          // Adding method type
          method: "POST",
          // Adding headers to the request
          headers: {
            "Content-type": "application/json; charset=UTF-8",
          },
          // Adding body or contents to send
          body: JSON.stringify({
            endpoint: this.selectedqueryEndpoint,
            memberId: this.getTokenResponse.memberId,
            fromDate: this.formatDate(this.rangeFrom),
            toDate: this.formatDate(this.rangeTo),
            status: this.selectedStatus,
            checksum: this.hash,
            token: this.authToken,
          }),
        });
        // parse into json
        const data = await response.json();
        // store results
        this.queryResult = data;
      } catch (error) {
        console.error(error);
      } finally {
        this.queryButtonLoading = false;
      }
    },

    /**
     * format js date range to comply with API specs
     * current format: yyyy-mm-dd
     * target format: dd/mm/yyyy
     * @param {String} strDate
     */
    formatDate(strDate) {
      // split by the dash
      let fromDate = strDate.split("-");
      // arrange according to spec
      const formatted = `${fromDate[2]}/${fromDate[1]}/${fromDate[0]}`;

      return formatted;
    },
  },
});

// mount vue app
const vm = app.mount("#app");
