
<?php

//As long as the result of the sql query is not empty populate the view/table with the user information: usernames and user ids.


foreach($viewbag as $OEEData){

    echo"<tr>";
    echo"<td>$OEEData[Pilsner]</td>";
    echo"<td>$OEEData[Wheat]</td>";
    echo"<td>$OEEData[Ipa]</td>";
    echo"<td>$OEEData[Stout]</td>";
    echo"<td>$OEEData[Ale]</td>";
    echo"<td>$OEEData[AlcoholFree]</td>";
    echo"</tr>";
}

echo"</table>";


?>