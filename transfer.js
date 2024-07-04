document.addEventListener("DOMContentLoaded", function () {
  var loader = document.getElementById("loader");
  var recipientAccountInput = document.getElementById("recipient_account");
  var nameInput = document.getElementById("name");
  var bankInput = document.getElementById("bank");
  var formElements = document.querySelectorAll(
    "#transferForm input, #transferForm textarea, #transferForm button"
  );

  bankInput.addEventListener("blur", function () {
    var bankName = this.value.trim();
    var accountNumber = recipientAccountInput.value.trim();

    if (bankName && accountNumber) {
      loader.style.display = "inline-block";
      setTimeout(function () {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "check_account.php", true);
        xhr.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.name) {
              nameInput.value = response.name;
            } else {
              nameInput.value = "Account not found";
            }
            loader.style.display = "none";

            formElements.forEach(function (element) {
              element.disabled = false;
            });
          }
        };
        xhr.send(
          "bankName=" +
            encodeURIComponent(bankName) +
            "&accountNumber=" +
            encodeURIComponent(accountNumber)
        );
      }, 1000);
    }
  });
});
