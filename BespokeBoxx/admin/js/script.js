$(window).scroll(function () {
    sessionStorage.scrollTop = $(this).scrollTop();
});
$(document).ready(function () {
    if (sessionStorage.scrollTop != "undefined") {
        $(window).scrollTop(sessionStorage.scrollTop);
    }
    var i = 1;

    $("#add").click(function () {
        i++;
        $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="pname[]" placeholder="Enter property name" /></td><td><input type="text" name="pvalue[]" placeholder="Enter property value"/></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Remove</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
      // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();


});

function ChangeVisOrder(id, order){
    $.ajax({
        url: "/logics/logic.products.php",
        method: "GET",
        data: {
            product_id: id,
            visOrder : order
        },
        success: function (data) {
            if(data == "orderChanged"){
                LoadProducts('',3,'div3');
                LoadProducts('',4,'div4');
                LoadProducts('',5,'div5');
                LoadProducts('',6,'div6');
                LoadProducts('',9,'div9');
                LoadProducts('',10,'div10');
                LoadProducts('',11,'div11');
                LoadProducts('',12,'div12');
                LoadProducts('',14,'div14');

            }
            
        }
    });

}
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }
  

function UserLogin() {

    $("form#loginForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.authenticate.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == "admin") {
                    window.location.href = "/layouts/dashboard.php";
                } else if (response == "error") {
                    alert("Please enter valid login credentials");
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
                    alert("Please make sure the passwords match.");
                } else if (data == "exists") {
                    alert("User already exists");
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function EditCustomerDetails() {
    $("form#editCustomerForm").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/controllers/logic.customer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    alert("Your details have been updated.");
                } else if (data == "exists") {
                    alert("Email already in use.");
                } else {
                    console.log(data);
                }
            }
        });
    });
}


function AddAddress() {
    $("form#addAddress").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/controllers/logic.customer.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/views/myaddress.php";

                } else if (data == "exists") {
                    alert("Address already added.");
                    if ("/views/myaddress.php") {
                        setTimeout(function () {
                            location.reload();
                        }, 0000);
                    }
                } else {
                    console.log(data);
                }
            }
        });
    });
}




function ChangePassword() {
    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();
    $.ajax({
        type: 'POST',
        url: '/logics/logic.authenticate.php',
        data: {
            updatePassword: "updatePassword",
            password: password,
            confirmPassword: confirmPassword
        },
        success: function (response) {
            if (response == "success") {
                window.location.href = "/layouts/profile.php";
            } else if (response == "notmatch") {
                alert("Please make sure the passwords match.");
            } else if (response == "exists") {
                alert("New password matches the existing password.");
            }
        }
    });

}

function ToggleStatus(status, id, url) {

    $.ajax({
        url: url,
        method: "GET",
        data: {
            action: status,
            id: id
        },

        success: function (data) {
            if (data == "toggleCategory") {
                LoadCategories();
            } else if (data == "toggleProduct") {
                console.log(data);
                LoadProducts('',3,'div3');
                LoadProducts('',4,'div4');
                LoadProducts('',5,'div5');
                LoadProducts('',6,'div6');
                LoadProducts('',9,'div9');
                LoadProducts('',10,'div10');
                LoadProducts('',11,'div11');
                LoadProducts('',12,'div12');
                LoadProducts('',14,'div14');

            } else if (data == "toggleUser") {
                LoadUsers();
            } else if (data == "toggleCustomer") {
                location.reload();
            } else if (data == "toggleOrder") {
                location.reload();
            } else if (data == "toggleRole") {
                LoadRoles();
            } else if (data == "toggleDiscount") {
                LoadDiscounts();
            } else if (data == "toggleDelivery") {
                LoadDelivery();
            } else {
                console.log(data);
            }
        }
    });
}

function Delete(Del, url) {

    if (confirm("Are you sure you want to delete this item?")) {
        $.ajax({
            url: url,
            method: "GET",
            data: {
                Del: Del
            },

            success: function (response) {
                if (response == "catdel") {
                    LoadCategories();
                } else if (response == "prodel") {
                    LoadProducts('',3,'div3');
                    LoadProducts('',4,'div4');
                    LoadProducts('',5,'div5');
                    LoadProducts('',6,'div6');
                    LoadProducts('',9,'div9');
                    LoadProducts('',10,'div10');
                    LoadProducts('',11,'div11');
                    LoadProducts('',12,'div12');
                    LoadProducts('',14,'div14');
                } else if (response == "userdel") {
                    LoadUsers();
                } else if (response == "roledel") {
                    LoadRoles();
                } else if (response == "customerdel") {
                    LoadCustomers();
                } else if (response == "discountDel") {
                    LoadDiscounts();
                } else if (response == "deliveryDel") {
                    LoadDelivery();
                } else if (response == "addressDelete") {
                    window.location.href = "/views/myaddress.php";
                } else if (response == "orderDel") {
                    location.reload();
                } else {
                    alert("Failed to delete.");
                }
            }
        });
    }

}

function CreateCategory() {
    $("form#CreateCategory").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.categories.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/layouts/categories.php";
                } else if (data == "exists") {
                    alert("Category already exists");
                } else {
                    console.log(data);
                }
            }
        });
    });

}

function UpdateCategory() {
    $("form#UpdateCategory").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.categories.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "updatedcat") {
                    window.location.href = "/layouts/categories.php";

                } else {
                    console.log(data);
                }
            }
        });
    });
}

function EditCategory(id) {
    $.ajax({
        url: '/logics/logic.products.php',
        method: "GET",
        data: {
            Edit: "Edit"
        },

        success: function (response) {
            if (response == "success") {
                window.location.href = "/edit/category_edit.php?id=" + id;
            } else {
                console.log(response);
            }
        }
    });
}


function CreateProduct() {
    $("form#CreateProduct").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.products.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/layouts/products.php";
                } else if (data == "exists") {
                    alert("Product already exists");
                } else {
                    alert(data);
                }
            }
        });
    });

}

function UpdateProduct() {
    $("form#UpdateProduct").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.products.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "updated") {
                    window.location.href = "/layouts/products.php";
                }  else {
                    alert(data);
                }
            }
        });
    });
}

function UpdateProductImage() {
    $("form#UpdateProductImage").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.products.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "updated") {
                    window.location.href = "/layouts/products.php";
                } else if (data == "invalid") {
                    alert("Please select a valid file type.");
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function EditProduct(id) {
    $.ajax({
        url: '/logics/logic.products.php',
        method: "GET",
        data: {
            Edit: "Edit"
        },

        success: function (response) {
            if (response == "success") {
                window.location.href = "/edit/product_edit.php?id=" + id;
            } else {
                console.log(response);
            }
        }
    });
}

function CreateUser() {
    $("form#CreateUser").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.users.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/layouts/users.php";
                } else if (data == "exists") {
                    alert("User already exists");
                } else if (data == "notmatch") {
                    alert("Please make sure the passwords match.");
                } else {
                    alert(data);
                }
            }
        });
    });

}

function UpdateUser() {
    $("form#UpdateUser").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.users.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "updated") {
                    window.location.href = "/layouts/users.php";
                } else if (data == "exists") {
                    alert("User already exists");
                } else if (data == "notmatch") {
                    alert("Please make sure the passwords match.");
                } else {
                    alert(data);
                }
            }
        });
    });
}

function EditUser(id) {
    $.ajax({
        url: '/logics/logic.users.php',
        method: "GET",
        data: {
            Edit: "Edit"
        },

        success: function (response) {
            if (response == "success") {
                window.location.href = "/edit/user_edit.php?id=" + id;
            } else {
                console.log(response);
            }
        }
    });
}

function CreateRole() {
    $("form#CreateRole").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.roles.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/layouts/roles.php";
                } else if (data == "exists") {
                    alert("Role already exists");
                } else {
                    console.log(data);
                }
            }
        });
    });

}

function UpdateRole() {
    $("form#UpdateRole").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.roles.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/layouts/roles.php";
                } else if (data == "exists") {
                    alert("Role already exists");
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function EditRole(id) {
    $.ajax({
        url: '/logics/logic.users.php',
        method: "GET",
        data: {
            Edit: "Edit"
        },

        success: function (response) {
            if (response == "success") {
                window.location.href = "/edit/role_edit.php?id=" + id;
            } else {
                console.log(response);
            }
        }
    });
}


function UpdateCustomer() {
    $("form#UpdateCustomer").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.customers.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/layouts/customers.php";
                } else if (data == "exists") {
                    alert("Customer already exists");
                } else {
                    console.log(data);
                }
            }
        });
    });
}

function EditCustomer(id) {
    $.ajax({
        url: '/logics/logic.customers.php',
        method: "GET",
        data: {
            Edit: "Edit"
        },

        success: function (response) {
            if (response == "success") {
                window.location.href = "/edit/customer_edit.php?id=" + id;
            } else {
                console.log(response);
            }
        }
    });
}


function LoadCategories(query) {
    $.ajax({
        url: "/logics/fetch_categories.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#result').html(data);
        }
    });
}


function LoadProducts(query,catid,resultDivId) {
    $.ajax({
        url: "/logics/fetch_products.php",
        method: "POST",
        data: {
            query: query,
            category_id : catid
        },
        success: function (data) {
            $('#'+resultDivId).html(data);
        }
    });
}

function LoadUsers(query) {
    $.ajax({
        url: "/logics/fetch_users.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#result').html(data);
        }
    });
}

function LoadRoles(query) {
    $.ajax({
        url: "/logics/fetch_roles.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#result').html(data);
        }
    });
}

function LoadCustomers(query) {
    $.ajax({
        url: "/logics/fetch_customers.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#result').html(data);
        }
    });
}

function LoadOrderDetails(query) {
    $.ajax({
        url: "/logics/fetch_order_details.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#result').html(data);
        }
    });
}

function LoadPendingDetails(query, reload_on_return) {
    $.ajax({
        url: "/logics/fetch_pending_order_details.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#result').html(data);
            if (reload_on_return) {
                setTimeout(
                    function () {
                        location.reload();
                    }, 0000);
            }

        }
    });
    setTimeout(LoadPendingDetails, 5000);
}

function LoadDispatchedDetails(query, reload_on_return) {
    $.ajax({
        url: "/logics/fetch_dispatched_order_details.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#dispatchresult').html(data);
            if (reload_on_return) {
                setTimeout(
                    function () {
                        location.reload();
                    }, 0000);
            }

        }
    });

}

function LoadCancelledOrders(query, reload_on_return) {
    $.ajax({
        url: "/logics/fetch_cancel_order_details.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#cancelresult').html(data);
            if (reload_on_return) {
                setTimeout(
                    function () {
                        location.reload();
                    }, 0000);
            }

        }
    });

}



function ViewOrderDetails(id) {
    $.ajax({
        url: "/layouts/order_details.php",
        method: "GET",
        data: {
            id: id
        },
        success: function (data) {
            window.location.href = "/layouts/order_details.php?id=" + id;


        }
    });
}

function ViewCustomerDetails(id) {
    $.ajax({
        url: "/layouts/customer_details.php",
        method: "GET",
        data: {
            id: id
        },
        success: function (data) {
            window.location.href = "/layouts/customer_details.php?id=" + id;
        }
    });
}

function LoadDiscounts(query) {
    $.ajax({
        url: "/logics/fetch_discounts.php",
        method: "POST",
        data: {
            query: query
        },
        success: function (data) {
            $('#result').html(data);
        }
    });
}

function CreateDiscount() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.discount.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/layouts/discounts.php";
                } else if (data == "exists") {
                    alert("Discount already exists");
                } else {
                    console.log(data);
                }
            }
        });
    });

}

function UpdateDiscount() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.discount.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "updateddiscount") {
                    window.location.href = "/layouts/discounts.php";

                } else {
                    console.log(data);
                }
            }
        });
    });
}

function EditDiscount(id) {
    $.ajax({
        url: '/logics/logic.discount.php',
        method: "GET",
        data: {
            Edit: "Edit"
        },

        success: function (response) {
            if (response == "success") {
                window.location.href = "/edit/discount_edit.php?id=" + id;
            } else {
                console.log(response);
            }
        }
    });
}



function LoadDelivery() {
    $.ajax({
        url: "/logics/fetch_delivery.php",
        method: "POST",
        success: function (data) {
            $('#result').html(data);

        }
    });
}

function CreateDelivery() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.delivery.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "inserted") {
                    window.location.href = "/layouts/delivery.php";
                } else if (data == "exists") {
                    alert("Delivery cost already exists");
                } else {
                    console.log(data);
                }
            }
        });
    });

}

function UpdateDelivery() {
    $("form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "/logics/logic.delivery.php",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data == "updateddelivery") {
                    window.location.href = "/layouts/delivery.php";

                } else {
                    console.log(data);
                }
            }
        });
    });
}

function EditDelivery(id) {
    $.ajax({
        url: '/logics/logic.delivery.php',
        method: "GET",
        data: {
            Edit: "Edit"
        },

        success: function (response) {
            if (response == "success") {
                window.location.href = "/edit/delivery_edit.php?id=" + id;
            } else {
                console.log(response);
            }
        }
    });
}