<?php

namespace woo\process;

class VenueManager extends Base
{
    static $add_venue = "INSERT venue(`name`) VALUES(?)";
    static $add_space = "INSERT space(`name`,`venue`) VALUES(?,?)";
    static $check_slot = "SELECT id,name FROM event WHERE space = ? AND (start+duratuin) > ? AND start < ?";
    static $add_event = "INSERT event(name,space,start,duration) VALUES(?,?,?,?)";

    /**
     * Add Venue
     *
     * @param $venue_name
     * @param array $spaces
     * @return array
     */
    public function addVenue($venue_name, array $spaces)
    {
        $data = array();
        $data['venue'] = array('name' => $venue_name);

        $this->doStatement(static::$add_venue, array($venue_name));
        $venue_id = self::$DB->lastInsertId();
        array_unshift($data['venue'], $venue_id);

        $data['spaces'] = array();
        foreach ($spaces as $space_name) {
            $values = array($space_name, $venue_id);
            $this->doStatement(static::$add_space, $values);
            $space_id = self::$DB->lastInsertId();

            array_unshift($values, $space_id);

            $data['spaces'][] = $values;
        }

        return $data;
    }

    /**
     * Book event
     *
     * @param $space_id
     * @param $name
     * @param $time
     * @param $duration
     */
    public function bookEvent($space_id, $name, $time, $duration)
    {
        $values = array($space_id, $time, $time + $duration);
        $stmt = $this->doStatement(static::$check_slot, $values);
        if ($result = $stmt->fetch()) {
            exit('double booked');
        }

        $this->doStatement(static::$add_event, array($name, $space_id, $time, $duration));
    }
}
