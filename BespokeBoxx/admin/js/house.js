///// Section-1 CSS-Slider /////    
// Auto Switching Images for CSS-Slider
function bannerSwitcher() {
  next = $('.sec-1-input').filter(':checked').next('.sec-1-input');
  if (next.length) next.prop('checked', true);
  else $('.sec-1-input').first().prop('checked', true);
}

var bannerTimer = setInterval(bannerSwitcher, 5000);

$('nav .controls label').click(function () {
  clearInterval(bannerTimer);
  bannerTimer = setInterval(bannerSwitcher, 5000)
});


function updateCartItem(obj, id) {
  $.ajax({
    url: '/pages/cartAction.php',
    method: "GET",
    data: {
      action: "updateCartItem",
      id: id,
      qty: obj.value
    },

    success: function (response) {
      if (response == "ok") {
        location.reload();
      } else {
        alert("Failed");
      }
    }
  });
}

$("form#contactus").submit(function (e) {
  e.preventDefault();

  var fullname = $("#fullname").val();
  var email = $("#email").val();
  var message = $("#message").val();

  $.ajax({
    type: 'POST',
    url: '/logics/logic.authenticate.php',
    data: {
      fullname: fullname,
      email: email,
      message: message
    },
    success: function (data) {
      if (data = "success") {
        alert("Message Sent.");
        location.reload();
      }
    },
    error: function (data) {
      alert(data);

    }
  });
});

function showMessage() {
  var x = document.getElementById("mess");
  x.className = "show";
  setTimeout(function () {
    x.className = x.className.fadeIn("show", "");
  }, 3000);


}
