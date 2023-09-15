$(document).ready(function () {
    document.getElementById("defaultOpen").click()
});

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function UserLoginFromCheckout() {
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
                    window.location.href="/views/checkout_summary.php";
                } else if (data == "error") {
                    var message = "Please enter valid login credentials";
                    ShowAlertBox(message);
                }
            }
        });
    });
}

function UserRegisterFromCheckout() {
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
                    var email = $("#txtemail").val();
                    var password = $("#txtpassword").val();
                    $.ajax({
                        type: 'POST',
                        url: '/logics/logic.authenticate.php',
                        data: {
                            email: email,
                            password: password
                        },
                        success: function (response) {
                            if (response == "customer") {
                                window.location.href="/views/checkout_summary.php";
                            } else if (response == "error") {
                                var message = "Please enter valid login credentials";
                                ShowAlertBox(message);

                            }
                        }
                    });
                    location.reload();
                } else if (data == "notmatch") {
                    var message = "Please make sure the passwords match.";
                    ShowAlertBox(message);
                } else if (data == "exists") {
                    openTab(event, 'Login');
                    $("#guestEmailAlert").css("display", "block");
                    var x = $('#txtemail').val();
                    $('input[name=email]').attr('value', x); 
                    
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function ContinueAsGuest() {
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
                    window.location.href="/views/checkout_summary.php";
                } else if (data == "exists") {
                    openTab(event, 'Login');
                    $("#guestEmailAlert").css("display", "block");
                    var x = $('#loginEmail').val();
                    $('input[name=email]').attr('value', x); 

                } else {
                    console.log(data);

                }
            }
        });
    });
}