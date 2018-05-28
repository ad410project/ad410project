<?php
class event
{

    private $eventId;
    private $organizationId;
    private $name;
    private $description;
    private $address;
    private $startDate;
    private $endDate;
    private $categories;
    private $type;
    private $price;
    private $minAge;
    private $maxAge;
    private $registrationOpen;
    private $registrationClose;

    public function __construct($eventId, $name, $description, $address, $startDate, $endDate,
                                $organizationId, $categories, $type, $price, $minAge, $maxAge,
                                $registrationOpen, $registrationClose)
    {
        $this->eventId = $eventId;
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->organizationId = $organizationId;
        $this->categories = $categories;
        $this->type = $type;
        $this->price = $price;
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
        $this->registrationOpen = $registrationOpen;
        $this->registrationClose = $registrationClose;
    }

    public static function addEvent($event)
    {
        //get instance of db
        $db = Db::getInstance();

        //add event to database
    }

    public static function deleteEvent($eventId)
    {
        //get instance of db
        $db = Db::getInstance();

        //delete the event
    }

    public static function getAllEvents()
    {
        //get instance of db
        $db = Db::getInstance();

        $result = $db->query('CALL getEvents()');

        $db->close();

        return $result;
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

        return $result;
    }

    public static function getEventsByUserId($userId)
    {
        //get instance of db
        $db = Db::getInstance();

        //return events for the user ID
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

        return $result;
    }

    public static function getEventsByCategory($category)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @myCategoryId = ?");
        $stmt->bind_param('i', $category);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getCategoryEvent(@myCategoryId)');

        $db->close();

        return $result;
    }

    //return events matching type
    public static function getEventsByType($type)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @myTypeId = ?");
        $stmt->bind_param('i', $type);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getTypeEvent(@myTypeId)');

        $db->close();

        return $result;
    }

    public static function getEventsByKeyword($keyword)
    {
        //get instance of db
        $db = Db::getInstance();

        //return events with keyword in name or description
    }

    public static function getEventsByDateRange($startDate, $endDate)
    {
        //get instance of db
        $db = Db::getInstance();

        //bind the in parameters
        $stmt = $db->prepare("SET @startTime = ?");
        $stmt->bind_param('i', $startDate);
        $stmt->execute();

        $stmt = $db->prepare("SET @endTime = ?");
        $stmt->bind_param('i', $endDate);
        $stmt->execute();

        //execute the procedure
        $result = $db->query('CALL getEventsInDateRange(@startTime, @endTime)');

        $db->close();

        return $result;
    }

    public static function getEventsByAgeRange($minAge, $maxAge)
    {
        //get instance of db
        $db = Db::getInstance();

        //return events for the age range
    }

    public static function getEventsByPriceRange($minPrice, $maxPrice)
    {
        //get instance of db
        $db = Db::getInstance();

        //return events for the price range
    }

    public static function getEventsByLocation($location, $distance)
    {
        //get instance of db
        $db = Db::getInstance();

        //return events within a range of the location
    }

    public static function editEventField($eventId, $fieldToChange, $changeToThis)
    {
        //get instance of db
        $db = Db::getInstance();

        //edit event characteristics, might replace with multiple methods in the
        //form of setEventName, setEventDescription, setEventLocation, etc.
    }

    public static function addCategory($eventId, $category)
    {
        //get instance of db
        $db = Db::getInstance();

        //add a category to the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function removeCategory($eventId, $category)
    {
        //get instance of db
        $db = Db::getInstance();

        //remove a category from the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function addType($eventId, $type)
    {
        //get instance of db
        $db = Db::getInstance();

        //add a type to the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function removeType($eventId, $type)
    {
        //get instance of db
        $db = Db::getInstance();

        //remove a type from the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function addAddress($eventId, $address)
    {
        //get instance of db
        $db = Db::getInstance();

        //add an address to the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function removeAddress($eventId, $address)
    {
        //get instance of db
        $db = Db::getInstance();

        //remove an address from the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
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

    public function getAddress()
    {
        return $this->address;
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

    public function getType()
    {
        return $this->type;
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
}
