<?php
class event
{

    private $eventId;
    private $organizationId;
    private $creatorId;
    private $name;
    private $description;
    private $location;
    private $startDate;
    private $endDate;
    private $categories;
    private $type;
    private $price;
    private $minAge;
    private $maxAge;
    private $registrationOpen;
    private $registrationClose;

    public function __construct($eventId, $creatorId, $name, $description, $location, $startDate, $endDate,
                                $organizationId, $categories, $type, $price, $minAge, $maxAge,
                                $registrationOpen, $registrationClose)
    {
        $this->eventId = $eventId;
        $this->creatorId = $creatorId;
        $this->name = $name;
        $this->description = $description;
        $this->location = $location;
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
        //add event to database
    }

    public static function deleteEvent($eventId)
    {
        //delete the event
    }

    public static function getEventsByUserId($userId)
    {
        //return events for the user ID
    }

    public static function getEventsByCategory($category)
    {
        //return events matching category
    }

    public static function getEventsByType($type)
    {
        //return events matching type
    }

    public static function getEventsByKeyword($keyword)
    {
        //return events with keyword in name or description
    }

    /*
     * IN:
     * $startDate a start date for the range in DATETIME format
     * $endDate an end date for the range in DATETIME format
     *
     * OUT:
     * an array of event type objects
     */
    public static function getEventsByDateRange($startDate, $endDate)
    {
       $db = Db::getInstance();
       $events = [];

       $Query = 'CALL getEventsInDateRange(:start,:end)';

       if($stmt = $db->prepare($Query)) {

           $stmt->bind_param($startDate, $endDate);

           $stmt->execute();

           $stmt->bind_result($id, $orgId, $name, $desc, $price, $minAge, $maxAge, $eventDate, $regOpen, $regClosed);

           for ($i = 0; $stmt->fetch(); $i++) {
               $events[$i] = new event($id, $orgId, $name, $desc, $price, $minAge, $maxAge, $eventDate, $regOpen, $regClosed);
           }
           return $events;
       }
       else {
           return false;
       }
    }

    public static function getEventsByAgeRange($minAge, $maxAge)
    {
        //return events for the age range
    }

    public static function getEventsByPriceRange($minPrice, $maxPrice)
    {
        //return events for the price range
    }

    public static function getEventsByLocation($location, $distance)
    {
        //return events within a range of the location
    }

    public static function editEventField($eventId, $fieldToChange, $changeToThis)
    {
        //edit event characteristics, might replace with multiple methods in the
        //form of setEventName, setEventDescription, setEventLocation, etc.
    }

    public static function addCategory($eventId, $category)
    {
        //add a category to the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function removeCategory($eventId, $category)
    {
        //remove a category from the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function addType($eventId, $type)
    {
        //add a type to the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function removeType($eventId, $type)
    {
        //remove a type from the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function addAddress($eventId, $address)
    {
        //add an address to the event in the database

        //categories, types, and addresses likely need their own
        //methods for changes since they can have multiple entries
    }

    public static function removeAddress($eventId, $address)
    {
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

    public function getLocation()
    {
        return $this->location;
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
