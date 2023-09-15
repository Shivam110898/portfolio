$(document).ready(function () {
    CheckCartItems();
    MonitorSideCart();
    MonitorPopOver();
    ShowSearchResults();
    RunSlideShow();
    MonitorConsentCookie();
    //MonitorBOTM();

});

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function MonitorBOTM(){

    if(sessionStorage["botmShown"] != 'yes'){  
        sleep(120000).then(() => { ShowBotmModal() });
    }
}

function ShowBotmModal(){
    var modal = document.getElementById("botmModal");
    var cloebtn = document.getElementById("closebotm");

    $("#botmModal").css("display", "block");
    sessionStorage["botmShown"] = 'yes';

    cloebtn.onclick = function () {
        $("#botmModal").css("display", "none");
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            $("#botmModal").css("display", "none");
        }
    }
}
function MonitorConsentCookie(){
    const cookieBanner = document.querySelector('#cookie-banner');
    const hasCookieConsent = getCookie('_coo');

    if (!hasCookieConsent) {
        cookieBanner.classList.remove('hidden');
    }

    const consentCta = cookieBanner.querySelector('#consent-cookies');

    consentCta.addEventListener('click', () => {
        cookieBanner.classList.add('hidden');
        setCookie('_coo', 1, 60);
        setCookie('_v', 1, 60);
    });
}

function RunSlideShow(){
    $("#slideshow > div:gt(0)").hide();

    setInterval(function () {
        $('#slideshow > div:first')
            .fadeOut(500)
            .next()
            .fadeIn(500)
            .end()
            .appendTo('#slideshow');
    }, 3000);
}

function ShowSearchResults(){
    $('#keyword').on('input', function () {
        var searchKeyword = $(this).val();
        if (searchKeyword.length >= 1) {
            $.post('/logics/fetch_search', {
                keywords: searchKeyword
            }, function (data) {
                $('ul#content').empty().addClass('active');
                $.each(data, function () {
                    $('ul#content').append('<li><a href="/views/quickview?productid=' + this.id + '"><img src="/uploadedimgs/' + this.image + '">' + this.name + '</a></li>');
                });
            }, "json");
        } else {
            $('ul#content').empty().removeClass('active');
        }
    });
}

function MonitorPopOver(){
    $('.popover-markup>[data-toggle="popover"]').popover({
        html: true,
        title: function () {
            return $(this).parent().find('.head').html();
        },
        content: function () {
            return '<div class="popover-content1">' + $(this).parent().find('.content').html() +
                '</div>';
        }
    });
    $('body').on('click', function (e) {
        $('.popover-markup>[data-toggle="popover"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
}

function MonitorSideCart(){
    $(".cart-button, .close-button, #sidebar-cart-curtain").click(function (e) {
        e.preventDefault();
        var $body = $("body");
        // Add the show-sidebar-cart class to the body tag
        $body.toggleClass("show-sidebar-cart");

        // Check if the sidebar curtain is visible
        if ($("#sidebar-cart-curtain").is(":visible")) {
            // Hide the curtain
            $("#sidebar-cart-curtain").fadeOut(500);
            SetSideCartStatusToFalse();
        } else {
            // Show the curtain
            $("#sidebar-cart-curtain").fadeIn(500);
            window.addEventListener("load",function() {
                setTimeout(function(){
                    // This hides the address bar:
                    window.scrollTo(0, 1);
                }, 0);
            });
        }
    });
}


function OpenSideCart() {
    var $body = $("body");
    $body.toggleClass("show-sidebar-cart");
    $("#sidebar-cart-curtain").fadeIn();
    window.addEventListener("load",function() {
        setTimeout(function(){
            // This hides the address bar:
            window.scrollTo(0, 1);
        }, 0);
    });
}

function CloseSideCart() {
    var $body = $("body");
    $body.toggleClass("show-sidebar-cart");
    $("#sidebar-cart-curtain").fadeOut();
    SetSideCartStatusToFalse();
}

function SetSideCartStatusToFalse() {
    $.ajax({
        url: "/logics/logic.cart.php",
        method: "GET",
        data: {
            hideCart: "Y"
        },

        success: function (data) {

        }
    });
}

function CheckCartItems() {
    $.ajax({
        url: "/logics/logic.cart.php",
        method: "GET",
        data: {
            check_cart_items: "Y"
        },

        success: function (data) {
            if (data == 'updated') {
                CloseSideCart();
                ShowAlertBox("Some items in your Boxxes are selling fast, your Boxxes have been updated accordingly.");
            }
        }
    });
    setTimeout(CheckCartItems, 1000);

}

function UserLogin() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/logics/logic.authenticate.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "customer") {
                    location.reload();
                } else if (data == "error") {
                    var message = "Please enter valid login credentials.";
                    ShowAlertBox(message);
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function UserRegister() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.authenticate.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/views/login.php";
                } else if (data == "notmatch") {
                    var message = "Passwords do not match, please re-enter passwords.";
                    ShowAlertBox(message);
                } else if (data == "exists") {
                    var message = "An account with this email address already exists. Please login.";
                    ShowAlertBox(message);

                } else {
                    console.log(data);
                }
            }
        });
    });
}

function ShowAlertBox(message) {
    $('#alertModal').find('.modal-body p').text(message);
    $('#alertModal').modal('show');
}

function EditCustomerDetails() {
    $("form#editCustomerForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.customer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    var message = "Your details have been updated.";
                    ShowAlertBox(message);

                } else if (data == "exists") {
                    var message = "An account with this email address already exists. ";
                    ShowAlertBox(message);
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function AddAddress() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.customer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    location.href = "/views/checkout_summary.php"

                } else if (data == "exists") {
                    $("#addressAlreadyExists").css("display", "block");
                    console.log(data);

                } else {
                    console.log(data);
                }
            }
        });
    });
}

function UpdateAddress() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.customer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "updatedAddress") {
                    var message = "Address updated. ";
                    ShowAlertBox(message);
                } else if (data == "exists") {
                    var message = "Address already exists. ";
                    ShowAlertBox(message);
                    if ("/views/myaddress.php") {
                        location.reload();
                    }
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function EditAddress(id) {
    $.ajax({
        url: "/logics/logic.customer.php",
        method: "GET",
        data: {
            Edit: "Edit"
        },

        success: function (response) {
            if (response == "success") {
                window.location.href = "/views/editaddress.php?id=" + id;
            } else {
                console.log(response);
            }
        }
    });
}

function ChangePassword() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/logics/logic.authenticate.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "success") {
                    var message = "Your password has been changed. Please login.";
                    ShowAlertBox(message);
                    window.location.href = "/views/login.php";
                } else if (data == "notmatch") {
                    var message = "Please ensure that both passwords match.";
                    ShowAlertBox(message);
                } else if (data == "exists") {
                    var message = "New password matches the existing password.";
                    ShowAlertBox(message);
                }
            }
        });
    });
}


function Delete(Del, url) {
    confirmDialog("Are you sure you want to remove this item?", (ans) => {
        if (ans) {
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    Del: Del
                },

                success: function (response) {
                    if (response == "addressDelete") {
                        location.reload();
                    } else {
                        console.log(response);
                    }
                }
            });
        } else {
            location.reload();
        }
    });


}

function LoadProducts(query, category_id) {
    $.ajax({
        url: "/logics/fetch_products",
        method: "POST",
        data: {
            query: query,
            category_id: category_id
        },
        success: function (data) {
            $('#Products').html(data);
        },

    });
}


function EditHamper(hamperId) {

    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'GET',
        data: {
            edit_boxx: hamperId
        },
        success: function (data) {

            if (data == "hamperToBeEdited") {
                window.location.href = "/views/byb_beauty.php";

            } else {
                alert(data);
            }
        }
    });
}


function AddDiscount() {
    $("form#discounForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.cart.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "valid") {
                    location.reload();
                } else {
                    CloseSideCart();
                    var message = "Please enter a valid promo code.";
                    ShowAlertBox(message);
                }
            }
        });
    });
}


function PasswordRecovery() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.customer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "sent") {
                    var message = "An email has been sent to your email address with the password recovery link.";
                    ShowAlertBox(message);
                } else if (data == "notvalid") {
                    var message = "No account associated with this email. Please enter the email address used to register your account.";
                    ShowAlertBox(message);
                }
            }
        });
    });
}

function AddToCart(id, type) {

    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'POST',
        data: {
            product_id: id,
            product_type: type
        },
        success: function (data) {

            if (data == "addedToCart") {
                showDivs();
            } else if (data == "productaddedToCart") {
                location.reload();
            } else if (data == "fillingaddedToCart") {
                location.reload();
            } else if (data == "sizeAlreadyaddedToCart") {
                location.reload();
            } else if (data == "colourAlreadyaddedToCart") {
                location.reload();
            } else if (data == "boxxAddedToCart") {
                location.reload();
            } else if (data == "maxReached") {
                var message = "The current Boxx basket is at full capacity. Please select a bigger Boxx.";
                ShowAlertBox(message);
            } else if (data == "maxFillingReached") {
                var message = "You've already picked 2 Boxx fillings. Please unselect at least 1 filling before choosing another combination.";
                ShowAlertBox(message);
            } else if (data == "moreProductsThanLimit") {
                var message = "The current selection of products exceeds the capacity for this Boxx. Please unselect a few products before choosing a smaller Boxx.";
                ShowAlertBox(message);
            } else {
                alert(data);
            }
        }
    });
}

function RemoveFromCart(del, type) {
    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'GET',
        data: {
            Del: del,
            Type: type
        },
        success: function (data) {

            if (data == "removed") {
                location.reload();
            } else if (data == "fillingremoved") {
                location.reload();

            } else if (data == "minimum1filling") {
                var message = "You need to pick at least 1 Boxx filling.";
                ShowAlertBox(message);
            } else {
                location.reload();
            }
        }
    });
}

function AddBoxxToCart(hamperId) {

    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'GET',
        data: {
            AddBoxxToCart: hamperId
        },
        success: function (data) {

            if (data == "boxxAddedToCart") {
                window.location.href = "/views/buildyourbespokeboxx.php";
            } else if (data = "maxReached") {
                var message = "If you would like to order more than 3 Boxxes, please get in touch with us using our Bespoke/Corporate contact form, or email info@bespokeboxx.co.uk";
                ShowAlertBox(message);
            } else {
                alert(data);
            }
        }
    });
}

function AddHOTM(botmid, prodid) {
    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'GET',
        data: {
            botmid: botmid,
            product_id: prodid,
        },
        success: function (data) {
            if (data == "botmAdded") {
                window.location.href = "/index.php";
            } else if (data = "maxReached") {
                var message = "If you would like to order more than 3 Boxxes, please get in touch with us using our Bespoke/Corporate contact form, or email info@bespokeboxx.co.uk";
                ShowAlertBox(message);
            } else {
                alert(data);
            }
        }
    });
}

function ClearCart() {
    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'GET',
        data: {
            clear_cart: "Y"
        },
        success: function (data) {
            if (data == "cleared") {
                location.reload();
            } else {
                console.log(data);
            }
        }
    });
}

function ClearSelection(hamperId) {
    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'GET',
        data: {
            clear_selection: hamperId
        },
        success: function (data) {
            if (data == "cleared") {
                window.location.href = "/views/buildyourbespokeboxx.php";
            } else {
                console.log(data);
            }
        }
    });
}

function SendEmailToBB() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.customer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "sent") {
                    var message = "Thank you for your message, we'll be in touch shortly.";
                    ShowAlertBox(message);
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function getCookie(cname) {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const ca = decodedCookie.split(';');

    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }

    return "";
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();

    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

    const expires = "expires=" + d.toUTCString();

    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function DeleteCustomerAccount() {
    confirmDialog("Are you sure you want to delete your account? This process is isreversible, you will lose all of your saved addresses and order history.", (ans) => {
        if (ans) {
            $.ajax({
                url: "/logics/logic.authenticate.php",
                type: 'GET',
                data: {
                    deleteEmail: "YES"
                },
                success: function (data) {

                    if (data == "accountDeleted") {
                        location.reload();

                    } else {
                        alert(data);
                    }
                }
            });
        } else {
            location.reload();
        }
    });
}

function confirmDialog(message, handler) {
    $(`<div class="modal fade" id="myModal"> 
         <!-- Modal content--> 
          <div class="alert-modal-content"> 
             
             <div class="modal-body">
          <div class="row">
            <p class="name">${message}</p>
          </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success  btn-yes">Yes</button> 
            <button class="btn btn-danger  btn-no">No</button> 
        </div>
      </div> 
    </div>`).appendTo('body');

    //Trigger the modal
    $("#myModal").modal({
        backdrop: 'static',
        keyboard: false
    });

    //Pass true to a callback function
    $(".btn-yes").click(function () {
        handler(true);
        $("#myModal").modal("hide");
    });

    //Pass false to callback function
    $(".btn-no").click(function () {
        handler(false);
        $("#myModal").modal("hide");
    });

    //Remove the modal once it is closed.
    $("#myModal").on('hidden.bs.modal', function () {
        $("#myModal").remove();
    });
}

var loading = function (isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
    } else {
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
    }
};

function showAccount() {
    SetSideCartStatusToFalse();
    window.location.href = "/views/checkout.php";
}

function showSummary() {
    window.location.href = "/views/checkout_summary.php";
}

function showPay() {
    window.location.href = "/views/checkout_pay.php";
}