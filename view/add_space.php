<?php

use woo\view\ViewHelper;
use woo\domain\Venue;

$request = ViewHelper::getRequest();

/* @var Venue $venue */
$venue = $request->getData('venue');

?>

<html>
    <head>
        <title>Add a space for venue <?php echo $venue->getName() ?></title>
    </head>
    <body>
        <h1>Add a space for venue <?php echo $venue->getName() ?></h1>
        <table>
            <tr>
                <td><?php echo $request->getFeedbackString('</td></tr><tr><td>') ?></td>
            </tr>
        </table>

        <form action="index.php" method="get">
            <input aria-label="测试一下" type="text" name="space_name" value="<?php echo $request->getData('space_name') ?>">
            <input type="hidden" name="venue_name" value="<?php echo $venue->getName() ?>">
            <input type="hidden" name="submitted" value="<?php echo $request->getData('submitted') ?>">
            <input type="submit" value="submit">
        </form>
    </body>
</html>
