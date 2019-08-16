<?php

namespace woo\command;

use woo\base\Request;

class DefaultCommand extends Command
{
    /**
     * @inheritdoc
     */
    public function doExecute(Request $request)
    {
        return static::CMD_OK;
    }
}