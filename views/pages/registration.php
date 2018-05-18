<?php include '../templates/header.html'; ?>

<h3>Registration Form</h3>

<form name="registrationForm" onsubmit="return validateForm()" method="post">

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" placeholder="Enter first name" name="firstName" required>
        </div>

        <div class="form-group col-md-6">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" placeholder="Enter last name" name="lastName" required>
        </div>

        <div class="form-group col-md-6">
            <label for="emailAddress">Email Address</label>
            <input type="email" class="form-control" id="emailAddress" placeholder="Enter email address" name="emailAddress" required>
        </div>

        <div class="form-group col-md-6">
            <label for="phoneNumber">Phone Number</label>
            <input type="tel" class="form-control" id="phoneNumber" placeholder="Enter 10 digit phone number" name="phoneNumber" required
                   pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                    size="10">
        </div>


        <div class="form-group col-md-12">
            <label for="numOfKids">Number of Kids </label>
            <select name="numOfKids" id="numOfKids">
                <option value="">Select...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>


        <div class="form-group col-md-4">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
        </div>

        <div class="form-group col-md-4">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Re-enter password" name="confirmPassword" required>
        </div>


    </div>

    <button type="submit" class="btn btn-info btn-rounded"">Register</button>
</form>

<br>
<br>

<?php include '../templates/footer.html'; ?>