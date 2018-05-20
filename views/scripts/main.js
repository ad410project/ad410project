function validateForm() {

    var password = document.forms["registrationForm"]["password"].value;
    if (!isOkPass(password).result) {
        alert(isOkPass(password).error);
        return false;
    }

    var numOfKids = document.forms["registrationForm"]["numOfKids"].value;
    if (numOfKids == null || numOfKids === '') {
        alert("Please select number of kids");
        return false;
    }


    var confirmPassword = document.forms["registrationForm"]["confirmPassword"].value;
    if (confirmPassword !== password) {
        alert("Passwords must match.");
        return false;
    }
}

function isOkPass(p){
    var anUpperCase = /[A-Z]/;
    var aLowerCase = /[a-z]/;
    var aNumber = /[0-9]/;
    var aSpecial = /[!|@|#|$|%|^|&|*|(|)|-|_]/;
    var obj = {};
    obj.result = true;

    if(p.length < 8){
        obj.result=false;
        obj.error= "Password not long enough. Must be at least 8 characters."
        return obj;
    }

    var numUpper = 0;
    var numLower = 0;
    var numNums = 0;
    var numSpecials = 0;
    for(var i=0; i<p.length; i++){
        if(anUpperCase.test(p[i]))
            numUpper++;
        else if(aLowerCase.test(p[i]))
            numLower++;
        else if(aNumber.test(p[i]))
            numNums++;
        else if(aSpecial.test(p[i]))
            numSpecials++;
    }

    if(numUpper < 2 || numLower < 2 || numNums < 2 || numSpecials <2){
        obj.result=false;
        obj.error="Passwords must contain at least 2 upper case, 2 lower case, 2 numbers and 2 special characters.";
        return obj;
    }
    return obj;
}

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom:6,
        center: {lat: 47.608013, lng: -122.335167}
    });

    setMarkers(map);
}


function setMarkers(map){

    for (var i = 0; i < locations.length; i++) {
        var city = locations[i];
        // document.getElementById('demo').innerHTML = locations.length.toString();
        var marker = new google.maps.Marker({
            position: {lat: parseInt(city[0]), lng: parseInt(city[1])},
            map: map
        });
    }
}

//tentative added by Francesco
function hideMap() {
    document.getElementById("map").setAttribute('hidden','true');
}

//@TODO need to show map after moving off calendar tab and back onto map tab. This does not work currently
function showMap() {
    document.getElementById("map").setAttribute('hidden','false');
}




