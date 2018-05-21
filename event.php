<?php
class event
{

    private $eventId;
    private $creatorId;
    private $name;
    private $description;
    private $location;
    private $startTime;
    private $endTime;
    private $organizer;
    private $categories;
    private $type;
    private $cost;
    private $minimumAge;
    private $maximumAge;
    private $registrationStartTime;
    private $registrationEndTime;

    public function __construct($eventId, $creatorId, $name, $description, $location, $startTime, $endTime,
                                $organizer, $categories, $type, $cost, $minimumAge, $maximumAge,
                                $registrationStartTime, $registrationEndTime)
    {
        $this->eventId = $eventId;
        $this->creatorId = $creatorId;
        $this->name = $name;
        $this->description = $description;
        $this->location = $location;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->organizer = $organizer;
        $this->categories = $categories;
        $this->type = $type;
        $this->cost = $cost;
        $this->minimumAge = $minimumAge;
        $this->maximumAge = $maximumAge;
        $this->registrationStartTime = $registrationStartTime;
        $this->registrationEndTime = $registrationEndTime;
    }

    public static function addEvent($event)
    {
        //add event to database
    }

    public static function deleteEvent($eventId)
    {
        //delete the event
    }

    public function editEvent($fieldToEdit, $changeToThis)
    {
        //edit event characteristics, might replace with multiple methods in the
        //form of setEventName, setEventDescription, setEventLocation, etc.
    }

    public function addCategory($category)
    {
        $categories[] = $category;
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

    public function getStartTime(){
        return $this->startTime;
    }

    public function getEndTime(){
        return $this->endTime;
    }

    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getMinimumAge()
    {
        return $this->minimumAge;
    }

    public function getMaximumAge()
    {
        return $this->maximumAge;
    }

    public function getRegistrationStartTime()
    {
        return $this->registrationStartTime;
    }

    public function getRegistrationEndTime()
    {
        return $this->registrationEndTime;
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

    public static function getEventsByDateRange($startDate, $endDate)
    {
        //return events that fall within the date range
    }

    public static function getEventsByUserId($userId)
    {
        //return events for the user ID
    }
}
