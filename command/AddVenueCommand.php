<?php

namespace woo\command;

use woo\base\Request;
use woo\domain\Venue;

class AddVenueCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function doExecute(Request $request)
    {
        $name = $request->getData('venue_name');
        if (! $name) {
            $request->addFeedback('no name provided');
            return static::CMD_INSUFFICIENT_DATA;
        }

        $venue_obj = new Venue(null, $name);
        $request->addData('venue', $venue_obj);
        $request->addFeedback("'$name' added");

        return static::CMD_OK;
    }
}
