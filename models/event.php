<?php
class event
{

    private $eventId;
    private $organizationId;
    private $name;
    private $description;
    private $addressLine1;
    private $addressLine2;
    private $city;
    private $state;
    private $postalCode;
    private $startDate;
    private $endDate;
    private $categories;
    private $types;
    private $price;
    private $minAge;
    private $maxAge;
    private $registrationOpen;
    private $registrationClose;

    public function __construct($eventId, $name, $description, $addressLine1, $addressLine2, $city, $state,
                                $postalCode, $startDate, $endDate, $organizationId, $categories, $types,
                                $price, $minAge, $maxAge, $registrationOpen, $registrationClose)
    {
        $this->eventId = $eventId;
        $this->name = $name;
        $this->description = $description;
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->city = $city;
        $this->state = $state;
        $this->postalCode = $postalCode;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->organizationId = $organizationId;
        $this->categories = $categories;
        $this->types = $types;
        $this->price = $price;
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
        $this->registrationOpen = $registrationOpen;
        $this->registrationClose = $registrationClose;
    }

    //Add a new event by passing an event object
    public static function addEvent($event)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentOrganizationId = ?");
        $stmt->bind_param('i', $event->getOrganizationId());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventName = ?");
        $stmt->bind_param('s', $event->getName());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventDescription = ?");
        $stmt->bind_param('s', $event->getDescription());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventPrice = ?");
        $stmt->bind_param('i', $event->getPrice());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentMinAge = ?");
        $stmt->bind_param('i', $event->getMinAge());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentMaxAge = ?");
        $stmt->bind_param('i', $event->getMaxAge());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventDate = ?");
        $stmt->bind_param('s', $event->getStartDate());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentRegistrationOpen = ?");
        $stmt->bind_param('s', $event->getRegistrationOpen());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentRegistrationClose = ?");
        $stmt->bind_param('s', $event->getRegistrationClose());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEndDate = ?");
        $stmt->bind_param('s', $event->getEndDate());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventType = ?");
        $stmt->bind_param('s', $event->getTypes());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventCategory = ?");
        $stmt->bind_param('s', $event->getCategories());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @addressLine1 = ?");
        $stmt->bind_param('s', $event->getAddressLine1());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @addressLine2 = ?");
        $stmt->bind_param('s', $event->getAddressLine2());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @city = ?");
        $stmt->bind_param('s', $event->getCity());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @state = ?");
        $stmt->bind_param('s', $event->getState());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @postalCode = ?");
        $stmt->bind_param('s', $event->getPostalCode());
        $stmt->execute();

        $db->query('CALL editEvent(@currentOrganizationId, @currentEventName, @currentEventDescription,
            @currentEventPrice, @currentMinAge, @currentMaxAge, @currentEventDate, @currentRegistrationOpen,
            @currentRegistrationClose, @currentEndDate, @currentEventType, @currentEventCategory,
            @addressLine1, @addressLine2, @city, @state, @postalCode)');

        $db->close();
    }

    public static function deleteEvent($eventId)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventId = ?");
        $stmt->bind_param('i', $eventId);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEvent(@currentEventId)');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getAllEvents()
    {
        //get instance of db
        $db = Db::getInstance();

        $result = $db->query('CALL getEvents()');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getEventById($eventId)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @myEventId = ?");
        $stmt->bind_param('i', $eventId);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEvent(@myEventId)');

        $db->close();

        return event::getEventArray($result);

    }

    public static function getEventsByUserId($userId)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentUserId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsByUserId(@currentUserId)');

        $db->close();

        return event::getEventArray($result);
    }

    //function for returning events data formatted for the user profile
    public static function getEventsForUserDisplay($userId) {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentUserId = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsByUserIdTrimmed(@currentUserId)');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getEventsByChildId($childId)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @myChildId = ?");
        $stmt->bind_param('i', $childId);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getChildEvents(@myChildId)');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getEventsByCategory($category)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentCategoryName = ?");
        $stmt->bind_param('s', $category);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsByCategory(@currentCategoryName)');

        $db->close();

        return event::getEventArray($result);
    }

    //return events matching type
    public static function getEventsByType($type)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentType = ?");
        $stmt->bind_param('s', $type);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsByType(@currentType)');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getEventsByKeyword($keyword)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentKeyword = ?");
        $stmt->bind_param('s', $keyword);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsByKeyword(@currentKeyword)');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getEventsByDateRange($startDate, $endDate)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventDate = ?");
        $stmt->bind_param('s', $startDate);
        $stmt->execute();

        $stmt = $db->prepare("SET @currentEndDate = ?");
        $stmt->bind_param('s', $endDate);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsInDateRange(@currentEventDate, @currentEndDate)');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getEventsByAgeRange($minAge, $maxAge)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentMinAge = ?");
        $stmt->bind_param('i', $minAge);
        $stmt->execute();

        $stmt = $db->prepare("SET @currentMaxAge = ?");
        $stmt->bind_param('i', $maxAge);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsByAgeRange(@currentMinAge, @currentMaxAge)');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getEventsByPriceRange($minPrice, $maxPrice)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentMinPrice = ?");
        $stmt->bind_param('i', $minPrice);
        $stmt->execute();

        $stmt = $db->prepare("SET @currentMaxPrice = ?");
        $stmt->bind_param('i', $maxPrice);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsByPriceRange(@currentMinPrice, @currentMaxPrice)');

        $db->close();

        return event::getEventArray($result);
    }

    public static function getEventsByPostalCode($postalCode)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentCode = ?");
        $stmt->bind_param('s', $postalCode);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsByPostalCode(@currentCode)');

        $db->close();

        return event::getEventArray($result);
    }

    //Edit an event in the Db by passing an event object with matching Id and the other changes you want
    public static function editEvent($event)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventId = ?");
        $stmt->bind_param('i', $event->getEventId());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentOrganizationId = ?");
        $stmt->bind_param('i', $event->getOrganizationId());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventName = ?");
        $stmt->bind_param('s', $event->getName());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventDescription = ?");
        $stmt->bind_param('s', $event->getDescription());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventPrice = ?");
        $stmt->bind_param('i', $event->getPrice());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentMinAge = ?");
        $stmt->bind_param('i', $event->getMinAge());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentMaxAge = ?");
        $stmt->bind_param('i', $event->getMaxAge());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventDate = ?");
        $stmt->bind_param('s', $event->getStartDate());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentRegistrationOpen = ?");
        $stmt->bind_param('s', $event->getRegistrationOpen());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentRegistrationClose = ?");
        $stmt->bind_param('s', $event->getRegistrationClose());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEndDate = ?");
        $stmt->bind_param('s', $event->getEndDate());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventType = ?");
        $stmt->bind_param('s', $event->getTypes());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @currentEventCategory = ?");
        $stmt->bind_param('s', $event->getCategories());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @addressLine1 = ?");
        $stmt->bind_param('s', $event->getAddressLine1());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @addressLine2 = ?");
        $stmt->bind_param('s', $event->getAddressLine2());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @city = ?");
        $stmt->bind_param('s', $event->getCity());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @state = ?");
        $stmt->bind_param('s', $event->getState());
        $stmt->execute();

        //bind the in parameters
        $stmt = $db->prepare("SET @postalCode = ?");
        $stmt->bind_param('s', $event->getPostalCode());
        $stmt->execute();

        $db->query('CALL editEvent(@currentEventId, @currentOrganizationId, @currentEventName, 
            @currentEventDescription, @currentEventPrice, @currentMinAge, @currentMaxAge, @currentEventDate, 
            @currentRegistrationOpen, @currentRegistrationClose, @currentEndDate, @currentEventType,
            @currentEventCategory, @addressLine1, @addressLine2, @city, @state, @postalCode)');

        $db->close();
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    public function getCity()
    {
        return $this->city;
    }


    public function getState()
    {
        return $this->state;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function getStartDate(){
        return $this->startDate;
    }

    public function getEndDate(){
        return $this->endDate;
    }

    public function getOrganizationId()
    {
        return $this->organizationId;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getMinAge()
    {
        return $this->minAge;
    }

    public function getMaxAge()
    {
        return $this->maxAge;
    }

    public function getRegistrationOpen()
    {
        return $this->registrationOpen;
    }

    public function getRegistrationClose()
    {
        return $this->registrationClose;
    }

    //helper function for getting an Event array from sql result
    private static function getEventArray($result) {
        $array = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
            {

                $array[] = new event($row["eventId"],$row["eventName"], $row["eventDescription"],
                    $row["addressLine1"], $row["addressLine2"], $row["city"], $row["state"],
                    $row["postalCode"], $row["eventDate"], $row["endDate"], $row["organizationId"],
                    $row["eventCategory"], $row["eventType"], $row["eventPrice"], $row["minAge"],
                    $row["maxAge"], $row["registrationOpen"], $row["registrationClose"]);
            }
        }
        return $array;
    }
}