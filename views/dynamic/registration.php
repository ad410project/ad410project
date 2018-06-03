<form name="registrationForm" onsubmit="return validateForm()" method="post">
    <div class="container">
        <div id="img">
            <img id="avatar" src="views/images/img_avatar2.png"/>
            <h1>Register</h1>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" placeholder="Enter first name" name="firstName"
                       required>
            </div>

            <div class="form-group col-md-6">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Enter last name" name="lastName"
                       required>
            </div>

            <div class="form-group col-md-6">
                <label for="emailAddress">Email Address</label>
                <input type="email" class="form-control" id="emailAddress" placeholder="Enter email address"
                       name="emailAddress" required>
            </div>

            <div class="form-group col-md-6">
                <label for="phoneNumber">Phone Number</label>
                <input type="tel" class="form-control" id="phoneNumber" placeholder="Enter 10 digit phone number"
                       name="phoneNumber" required
                       pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                       size="10">
            </div>

            <div class="form-group col-md-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password_1"
                       required>
            </div>

            <div class="form-group col-md-4">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Re-enter password"
                       name="password_2" required>
            </div>

            <div class="form-group col-md-12">
                <label for="userRole">Register as </label>
                <select name="userRole" id="userRole" required>
                    <option value="">Select...</option>
                    <option value="user">Individual User</option>
                    <option value="admin">Admin</option>
                    <option value="organization">Organization</option>
                </select>
            </div>

            <button type="submit" class="register-btn">Register</button>
        </div>
    </div>
    <div class="container signin">
        <p>Already have an account? <a href="#">Log in</a>.</p>
    </div>
</form>