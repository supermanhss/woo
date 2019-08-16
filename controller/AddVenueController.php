<?php

namespace woo\controller;

use woo\domain\Venue;
use woo\process\VenueManager;

class AddVenueController extends PageController
{
    function process()
    {
        try {
            $request = $this->getRequest();

            $name = $request->getData('venue_name');
            if (is_null($request->getData('submitted'))) {
                $request->addFeedback("choose a name for the venue");
                $this->forward('add_venue.php');
            } elseif (! $name) {
                $request->addFeedback("name is required");
                $this->forward('add_venue.php');
            }

            $space_name = $request->getData('space_name');
            if (is_null($space_name)) {
                $request->addFeedback("choose a name for the space");
                $request->addData('venue', new Venue(null, $name));
                $this->forward("add_space.php");
            } elseif (! $space_name) {
                $request->addFeedback("space name is required");
                $request->addData('venue', new Venue(null, $name));
                $this->forward("add_space.php");
            }

            $venue_manager = new VenueManager();
            $data = $venue_manager->addVenue($name, array($space_name));

            $request->addData('venue_data', $data);
            $this->forward("venue_info.php");

        } catch (\Exception $e) {
            $this->forward('error.php');
        }
    }
}