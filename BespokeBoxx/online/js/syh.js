$(window).scroll(function () {
  sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function () {
  if (sessionStorage.scrollTop != "undefined") {
    $(window).scrollTop(sessionStorage.scrollTop);
  }  
  MonitorQuickViewModal();
  MonitorHamperCapacity();
  SelectBoxxColor();
  SelectBoxxSize();
  SelectBoxxFilling();
});

function MonitorQuickViewModal(){
  var modal = document.getElementById("quickViewItem");
  var cloebtn = document.getElementById("closeqwi");
  cloebtn.onclick = function () {
    $("#quickViewItem").css("display", "none");
  }
  window.onclick = function (event) {
    if (event.target == modal) {
      $("#quickViewItem").css("display", "none");
    }
  }

}

function SelectBoxxColor(){
  $('input[name="boxxColourRadio"]').change(function () {
    var pid = $('input[name="boxxColourRadio"]:checked').attr('id');
    AddToCart(pid, 'BoxxColour');

  });
}
function SelectBoxxSize(){
  $('input[name="boxxSizeRadio"]').change(function () {
    var pid = $('input[name="boxxSizeRadio"]:checked').attr('id');
    AddToCart(pid, 'BoxxSize');

  });
}
function SelectBoxxFilling(){
  $('input[name="boxxFillingCheckbox"]').on("click", function () {
    if ($(this).is(":not(:checked)")) {
      RemoveFromCart(this.id, "Filling");
    } else if ($(this).is(":checked")) {
      AddToCart(this.id, 'BoxxFilling');
    }
  });
}

function MonitorHamperCapacity(){
  $(".circle_percent").each(function () {
    var $this = $(this),
      $dataV = $this.data("percent"),
      $dataDeg = $dataV * 3.6,
      $round = $this.find(".round_per");
    $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
    $this.append('<div class="circle_inbox"><span class="percent_text"></span></div>');
    $this.prop('Counter', 0)
      .animate({
        Counter: $dataV
      }, {
        duration: 2000,
        easing: 'swing',
        step: function (now) {
          $this.find(".percent_text").text(Math.ceil(now) + "%");
        }
      });
    if ($dataV >= 51) {
      $round.css("transform", "rotate(" + 360 + "deg)");
      setTimeout(function () {
        $this.addClass("percent_more");
      }, 1000);
      setTimeout(function () {
        $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
      }, 1000);
    }
  });
}

function showDivs() {
  $.ajax({
    url: "/logics/logic.cart.php",
    method: "GET",
    data: {
      section_selection: "Y"
    },

    success: function (data) {
      if (data == 'colourSet') {
        showSize();
      } else if (data == 'sizeSet') {
        showFilling();
      } else if (data == 'fillingSet') {
        showProducts();
      } else {
        showColour();

      }
    }
  });
}

function showColour() {
  $("#step1").addClass('active');
  $("#step2").removeClass('active');
  $("#step3").removeClass('active');
  $("#step4").removeClass('active');
  window.location.href = "/views/buildyourbespokeboxx.php";
}

function showSize() {
  $("#step1").addClass('active');
  $("#step2").addClass('active');
  $("#step3").removeClass('active');
  $("#step4").removeClass('active');

  window.location.href = "/views/buildyourbespokeboxx_size.php";


}

function showFilling() {

  $("#step1").addClass('active');
  $("#step2").addClass('active');
  $("#step3").addClass('active');
  $("#step4").removeClass('active');
  window.location.href = "/views/buildyourbespokeboxx_filling.php";


}

function showProducts() {

  $("#step1").addClass('active');
  $("#step2").addClass('active');
  $("#step3").addClass('active');
  $("#step4").addClass('active');
  window.location.href = "/views/byb_beauty.php";


}

function ShowQuickViewItem(itemid) {
  $.ajax({
    url: "/logics/fetch_quickview.php",
    method: "GET",
    data: {
      productid: itemid
    },
    success: function (data) {
      $("#quickViewItem").css("display", "block");
      $('#detailedView').html(data);
    }

  });
}