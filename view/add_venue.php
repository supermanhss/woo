<?php

$request = \woo\base\register\RequestRegister::getRequest();

?>

<html>
    <head>
        <title>Add Venue</title>
    </head>
    <body>
        <h1>Add Venue</h1>

        <table>
            <tr>
                <td><?= $request->getFeedbackString() ?></td>
            </tr>
        </table>

        <form action="index.php" method="get" enctype="multipart/form-data">
            <input type="hidden" name="submitted" value="yes">
            <input aria-label="" type="text" name="venue_name" placeholder="">

            <button type="submit">提交</button>
        </form>
    </body>
</html>
