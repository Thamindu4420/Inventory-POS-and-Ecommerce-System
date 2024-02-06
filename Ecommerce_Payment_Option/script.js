function paymentGateWay() {

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = () =>{
    if (xhttp.readyState == 4 && xhttp.status == 200){
        alert(xhttp.responseText);
        var obj = JSON.parse(xhttp.responseText);


// Make an AJAX request to send the email
var emailRequest = new XMLHttpRequest();
emailRequest.onreadystatechange = function() {
    if (emailRequest.readyState == 4 && emailRequest.status == 200) {
        console.log(emailRequest.responseText);
        

        // Payment completed. It can be a successful failure.
    payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);
        
    };

    // Payment window closed
    payhere.onDismissed = function onDismissed() {
        
        console.log("Payment dismissed");
    };

    // Error occurred
    payhere.onError = function onError(error) {
        
        console.log("Error:"  + error);
    };

    // Put the payment variables here
    var payment = {
        "sandbox": true,
        "merchant_id": "1224258",    
        "return_url": "http://localhost/payhere_config/",     
        "cancel_url": "http://localhost/payhere_config/",     
        "notify_url": "http://sample.com/notify",
        "order_id": obj ["order_id"],
        "items": obj ["items"],
        "amount": obj ["amount"],
        "currency": obj ["currency"],
        "hash": obj ["hash"], 
        "first_name": obj ["first_name"],
        "last_name": obj ["last_name"],
        "email": obj ["email"],
        "phone": obj ["phone"],
        "address": obj ["address"],
        "city": obj ["city"],
        "country": "Sri Lanka",
        "delivery_address": "No. 46, Galle road, Kalutara South",
        "delivery_city": "Kalutara",
        "delivery_country": "Sri Lanka",
        "custom_1": "",
        "custom_2": ""
    };

    payhere.startPayment(payment);

    }
};

emailRequest.open("GET", "send_email.php", true);
emailRequest.send();
}
};



xhttp.open("GET","payhereprocess.php",true);
xhttp.send();


}

