$(document).ready(function () {
    var modalGiftMessage = document.getElementsByClassName("giftMessageModal")[0];
    
    window.onclick = function (event) {
    if (event.target == modalGiftMessage) {
            modalGiftMessage.style.display = "none";
        }
    }
});

function HideModal(id){
    var modal = document.getElementById(id);
    modal.style.display = "none";

}
function ShowModal(id){
    var modal = document.getElementById(id);
    $("html, body").scrollTop($('#' + id)).offset().top;

    modal.style.display = "block";

}

function ChangeGuestEmail(){
    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'GET',
        data: {
            change_guest : "Y"
           
        },
        success: function (data) {
            if (data == "changeEmail") {
                location.reload();
            }  else {
                console.log(data);
            }
        }
    });
}

function SaveDeliveryAddress(address_id, boxx_id,type){
    $.ajax({
        url: "/logics/logic.cart.php",
        type: 'GET',
        data: {
            address_id : address_id,
            boxx_id : boxx_id,
            type : type
        },
        success: function (data) {
            if (data == "addressAdded") {
                location.reload();
            }  else {
                console.log(data);
            }
        }
    });
}


function AddGiftMessage(){
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.cart.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "messageSet") {
                    location.reload();
                } else {
                    console.log(data);
                }
            }
        });
    });
}
