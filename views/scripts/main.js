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
    //invalidate editUser form first to disallow changes
    $("#editUserFormContainer :input").prop('readonly', true);
    //do remove first
    try
    {
        var elem = document.getElementById('editChildRow');
        elem.remove();
        var elem2 = document.getElementById('editChildRow2');
        elem2.remove();
    }
    catch(Exception)
    {

    }

    var container = document.getElementById("updateChild");

    var myRow = document.createElement('DIV');
    myRow.id = 'editChildRow';
    myRow.style.display = 'inline-block';
    myRow.className = 'row';
    myRow.style.width = '600px';

    var myRow2 = document.createElement('DIV');
    myRow2.id = 'editChildRow2';
    myRow2.style.display = 'inline-block';
    myRow2.className = 'row';
    myRow2.style.width = '600px';

    var obj = document.createElement('DIV');
    obj.id = 'editChildfName';
    obj.className = 'form-group col-md-6';
    obj.style.display = 'inline-block';
    obj.innerHTML = "<label for=\"\">First Name</label>\n" +
        "            <input type=\"text\" class=\"form-control form-control-sm\" id=\"child-first_name" + "\"placeholder=\"\"  required>";

    var obj2 = document.createElement('DIV');
    obj2.id = 'editChildlName';
    obj2.className = 'form-group col-md-6';
    obj2.style.display = 'inline-block';
    obj2.innerHTML = "<label for=\"\">Last Name</label>\n" +
        "            <input type=\"text\" class=\"form-control form-control-sm \" id=\"child-last_name"  + "\"placeholder=\"\"  required>";

    myRow.appendChild(obj);
    myRow.appendChild(obj2);


    var obj3 = document.createElement('DIV');
    obj3.id = 'editChildlAge';
    obj3.className = 'form-group col-md-6';
    obj3.style.display = 'inline-block';
    obj3.innerHTML = "<label for=\"\">Date of birth</label>\n" +
        "            <input type=\"date\" class=\"form-control form-control-sm \" id=\"child-age" + "\"placeholder=\"\"  required>";

    var obj4 = document.createElement('DIV');
    obj4.id='btnEditChildSubmitCancel';
    obj4.className = 'form-group col-md-6';
    obj4.style.display = 'inline-block';
    obj4.innerHTML = "<button class=\"btn btn-primary col-md-3\" type=\"submit\" onclick='addKid()'>Submit</button>" +
        "               <button class=\"btn btn-secondary col-md-3\" type=\\\"button\\\" onclick='removeEditChildForm()'>Cancel</button>";

    myRow2.appendChild(obj3);
    myRow2.appendChild(obj4);

    container.appendChild(myRow);
    container.appendChild(myRow2);

    return container;
}

function removeEditChildForm()
{
    try
    {
        var elem = document.getElementById('editChildRow');
        elem.remove();
        var elem2 = document.getElementById('editChildRow2');
        elem2.remove();

        $("#editUserFormContainer :input").prop('readonly', false);
    }
    catch(Exception)
    {

    }
}


// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                else
                {
                    //Update profile
                    updateUserProfile();
                }
                form.classList.add('was-validated');


            }, false);
        });
    }, false);
})();

function updateUserProfile()
{

    var staticValues = {};

    var fName = document.getElementById('fName');
    var lName = document.getElementById('lName');
    var email = document.getElementById('email');
    var pWord = document.getElementById('pWord');
    var phone = document.getElementById('phone');

    if (null != fName && null != lName && null != email && null != pWord && null != phone)
    {
        var valFname = fName.value;
        var valLname = lName.value;
        var valEmail = email.value;
        var valPWord = pWord.value;
        var valPhone = phone.value;

        staticValues = {fN:valFname, lN:valLname, em:valEmail, pw:valPWord, ph:valPhone};
    }
    else
    {
        staticValues = {fN:fName.placeholder, lN:lName.placeholder, em: email.placeholder, pw: pWord.placeholder, ph: phone.placeholder};
    }

    removeEditChildForm();
    $("#editUserFormContainer :input").prop('readonly', false);

    //POST array values to userProfile
    $.ajax({
        url: '../dynamic/userProfile.php',
        type: 'POST',
        data: {q:staticValues},
        success: function (data) {
            console.log(staticValues);

        }
    })
}

function addKid()
{
    var dynamicValues = {};
    try {
        var elem = document.getElementById("child-first_name");
        var elem2 = document.getElementById("child-last_name");
        var elem3= document.getElementById("child-age");

        if (null != elem && null != elem2 && null != elem3) {
            var val = elem.value;
            var val2 = elem2.value;
            var val3 = elem3.value;
            dynamicValues = {fN:val, lN:val2, age:val3};
        }
        else
        {
            dynamicValues = {fN:null, lN:null, age:null};
        }
    }
    catch (Exception)
    {

    }

    removeEditChildForm();
    $("#editUserFormContainer :input").prop('readonly', false);

    //POST array values to userProfile
    $.ajax({
        url: '../dynamic/userProfile.php',
        type: 'POST',
        data: {q2:dynamicValues},
        success: function (data) {
            console.log(dynamicValues);
        }
    })
}



