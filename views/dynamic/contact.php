<form name="contactUsForm" method="post">
    <div class="container">
        <br>
        <br>
        <h4> Questions or Comments ? </h4>
        <h6> We'll do your best to figure it out. </h6>
        <div class="form-row">
            <div class="form-group col-md-4">
                <input class="form-control" id="name" placeholder="Name"
                       name="name" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <input type="email" class="form-control" id="email" placeholder="Email"
                       name="emailAddress" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <input type="tel" class="form-control" id="phoneNumber" placeholder="Enter 10 digit phone number"
                       name="phoneNumber"
                       pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                       size="10">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <textarea class="form-control" rows="5" id="comment" name="commentMessage" required></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <button type="submit" class="register-btn">Submit Message</button>
            </div>
        </div>
    </div>

</form>