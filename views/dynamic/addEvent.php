<h3>Add Event</h3>

<form name="addEventsForm" action="#" method="post">

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="eventName">Event Name:</label>
            <input type="text" class="form-control" id="eventName" placeholder="Enter event name" name="eventName">
        </div>

        <div class="form-group col-md-4">
            <label for="eventDescription">Event Description:</label>
            <input type="text" class="form-control" id="eventDescription" placeholder="Enter event description" name="eventDescription">
        </div>

        <div class="form-group col-md-4">
            <label for="eventDate">Event Date:</label>
            <input type="text" class="form-control" id="eventDate" placeholder="Enter event date" name="eventDate">
        </div>

        <div class="form-group col-md-4">
            <label for="ageMin">Age minimum:</label>
            <input type="text" class="form-control" id="ageMin" placeholder="Enter minimum age" name="ageMin">
        </div>

        <div class="form-group col-md-4">
            <label for="ageMax">Age maximum:</label>
            <input type="text" class="form-control" id="ageMax" placeholder="Enter maximum age" name="ageMax">
        </div>


        <div class="form-group col-md-4">
            <label for="imdbID">IMDB ID: </label>
            <input type="text" class="form-control" id="imdbId" placeholder="Enter IMDB ID" name="imdbId" pattern="tt\d{7}" title="IMDB ID should start with lowercase double t followed by 7 digit numbers e.g. tt1234567">
        </div>

        <div class="form-group col-md-4">
            <label for="registrationOpenDate">Registration Open Date:</label>
            <input type="text" class="form-control" id="registrationOpenDate" placeholder="Enter event registration open date" name="registrationOpenDate">
        </div>

        <div class="form-group col-md-4">
            <label for="registrationCloseDate">Event Date:</label>
            <input type="text" class="form-control" id="registrationCloseDate" placeholder="Enter event registration close date" name="registrationCloseDate">
        </div>
    </div>

    <button type="submit" class="btn btn-info btn-rounded"">Add to my Event list</button>
</form>