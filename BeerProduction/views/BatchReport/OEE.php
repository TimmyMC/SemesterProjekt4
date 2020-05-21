
<?php

//As long as the result of the sql query is not empty populate the view/table with the user information: usernames and user ids.


//    print_r($viewbag);

    echo"<tr>";
    echo"<td>$viewbag[Pilsner]</td><br>";
    echo"<td>$viewbag[Wheat]</td><br>";
    echo"<td>$viewbag[Ipa]</td><br>";
    echo"<td>$viewbag[Stout]</td><br>";
    echo"<td>$viewbag[Ale]</td><br>";
    echo"<td>$viewbag[AlcoholFree]</td><br>";
    echo"</tr>";


echo"</table>";


?>