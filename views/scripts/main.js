function validateForm() {

    var password = document.forms["registrationForm"]["password"].value;
    if (!isOkPass(password).result) {
        alert(isOkPass(password).error);
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

//added by Francesco
function hideMapShowCal() {
    //toggle map
    var obj = document.getElementById('map');
    obj.style.display = 'none';
    var cal = document.getElementById('calendar');
    cal.style.display = 'block';
}

function showMapHideCal() {
    //toggle calendar
    var cal = document.getElementById('calendar');
    cal.style.display = 'none';
    var map = document.getElementById('map');
    map.style.display = 'block';
}

//userProfile form for editChild
function displayEditChildForm()
{
    //do remove first
    for (i = 0; i < 5; i++) {
        try {
            var elem = document.getElementById("editChildfName" + i);
            elem.remove();
            var elem2 = document.getElementById('editChildlName' + i);
            elem2.remove();
            var elem3 = document.getElementById('editChildlAge' + i);
            elem3.remove();
        }
        catch(Exception)
        {
            //do nothing
        }
    }

    var rowsObj = document.getElementById('numberKids');
    var numRows = rowsObj.options[rowsObj.selectedIndex].value;
    var container = document.getElementById("updateChild");

    //Create new divs
    for(i = 0; i < numRows; i++) {

        var obj = document.createElement('DIV');
        obj.id = 'editChildfName' + i;
        obj.className = '';
        obj.style.display = 'inline-block';
        obj.style.height = "50px";
        obj.style.width = '400px';
        //obj.innerHTML = "<input type=\"text\" class=\"form-control\" id=\"childFname\" placeholder=\"\" name=\"child-first_name\" required>";
        obj.innerHTML = "<label for=\"\">First Name</label>\n" +
            "            <input type=\"text\" class=\"form-control-sm col-md-6\" id=\"child-first_name" + i + "\"placeholder=\"\"  required>";
        container.appendChild(obj);

        var obj2 = document.createElement('DIV');
        obj2.id = 'editChildlName' + i;
        obj2.className = '';
        obj2.style.display = 'inline-block';
        obj2.style.height = '50px';
        obj2.style.width = '400px';
        //obj2.innerHTML = "<input type=\"text\" class=\"form-control\" id=\"childLname\" placeholder=\"\" name=\"child-last_name\" required>";
        obj2.innerHTML = "<label for=\"\">Last Name</label>\n" +
            "            <input type=\"text\" class=\"form-control col-md-6\" id=\"child-last_name" + i + "\"placeholder=\"\"  required>";
        container.appendChild(obj2);

        var obj3 = document.createElement('DIV');
        obj3.id = 'editChildlAge' + i;
        obj3.className = '';
        obj3.style.display = 'inline-block';
        obj3.style.height = '50px';
        obj3.style.width = '400px';
        //obj2.innerHTML = "<input type=\"text\" class=\"form-control\" id=\"childLname\" placeholder=\"\" name=\"child-last_name\" required>";
        obj3.innerHTML = "<label for=\"\">Age</label>\n" +
            "            <input type=\"text\" class=\"form-control col-md-6\" id=\"child-age" + i + "\"placeholder=\"\"  required>";
        container.appendChild(obj3);

    }
    return container;
}

function sendValuesToPHP()
{
    var values = {};
    var staticValues = {};

    var fName = document.getElementById('fName');
    var lName = document.getElementById('lName');
    var email = document.getElementById('email');
    var pWord = document.getElementById('pWord');
    var phone = document.getElementById('phone');

    if (null != fName && null != lName && null != email && null != pWord && null != phone) {
        var valFname = fName.value;
        var valLname = lName.value;
        var valEmail = email.value;
        var valPWord = pWord.value;
        var valPhone = phone.value;

        staticValues = {fN:valFname, lN:valLname, em:valEmail, pw:valPWord, ph:valPhone};
    }
    else
    {
        staticValues = {fN:"", lN:"", em:"", pw:"", ph:""};
    }

    for(i = 0; i < 5; i++) {
        try {

            var elem = document.getElementById("child-first_name" + i);
            var elem2 = document.getElementById("child-last_name" + i);
            var elem3= document.getElementById("child-age" + i);

            if (null != elem && null != elem2 && null != elem3) {
                var val = elem.value;
                var val2 = elem2.value;
                var val3 = elem3.value;
                values[i] = {fN:val, lN:val2, age:val3};
            }
            else
            {
                values[i] = {fN:null, lN:null, age:null};
            }

        }
        catch (Exception)
        {

        }
    }

    //POST array values to userProfile
    $.ajax({
        url: '../static/userProfile.php',
        type: 'POST',
        data: {q1:values, q2:staticValues},
        success: function (data) {
            console.log(values);

        }
    })
}

/*
* Organization Events js
* */
$("#myCarousel").on("slide.bs.carousel", function(e) {
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 3;
    var totalItems = $(".carousel-item").length;

    if (idx >= totalItems - (itemsPerSlide - 1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i = 0; i < it; i++) {
            // append slides to end
            if (e.direction == "left") {
                $(".carousel-item")
                    .eq(i)
                    .appendTo(".carousel-inner");
            } else {
                $(".carousel-item")
                    .eq(0)
                    .appendTo($(this).find(".carousel-inner"));
            }
        }
    }
});




