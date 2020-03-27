<?php
class User extends Dbh
{
    //function to get all users 
    public function getAllUsers()
    {
        $stmt = $this->connect()->query("SELECT * FROM users");
        while ($row = $stmt->fetch()) {
            echo $username = $row['username'] . ', ';
        }
    }
}
