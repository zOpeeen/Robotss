<?php

$userlist     = "./userlist.ini";
$fh       = fopen($userlist, 'r+');
$infouser = htmlspecialchars($_GET["username"]);
$infopass = htmlspecialchars($_GET["password"]);
$infoidentification  = htmlspecialchars($_GET["identification"]);
$users    = '';
$allow   = false;

while (!feof($fh)) 
{
    $user = explode(',', fgets($fh));
    $username = trim($user[0]);
    $password = trim($user[1]);
    $date     = trim($user[2]);
    $identification      = trim($user[3]);
    $status   = trim($user[4]);
	
    if (!empty($username) AND !empty($password)) 
    {
        if ($username == $infouser AND $password == $infopass) 
        {
            if (empty($date) AND empty($identification) AND empty($status)) 
            {
                $allow       = true;
                $date         = date('d-m-Y', strtotime("+1 month", strtotime($date)));
                $identification          = $infoidentification;
                $status       = "Granted";
                $initial_date = date('Y-m-d');
                $final_date   = $date;
                $initial_time = strtotime($initial_date);
                $final_time   = strtotime($final_date);
                $variation    = $final_time - $initial_time;
                $days         = (int) floor($variation / (60 * 60 * 24));
                echo $status . "|" . $identification . "|" . $days;
            } 
            else 
            {
                $allow       = true;
                $initial_date = date('Y-m-d');
                $final_date   = $date;
                $initial_time = strtotime($initial_date);
                $final_time   = strtotime($final_date);
                $variation    = $final_time - $initial_time;
                $days         = (int) floor($variation / (60 * 60 * 24));
                
                if ($days < 0) 
                {
                    $status = "Ended";
                    echo $status;
                } 
                else 
                {
                    echo $status . "|" . $identification . "|" . $days . "|" . $username . "|";
                }
            }
        }
        
        $users .= $username . ',' . $password . ',' . $date . ',' . $identification . ',' . $status;
        $users .= "\r\n";
    }
}

file_put_contents($userlist, $users);

fclose($fh);

if ($allow == false) 
{
    echo "Denied";
}

?>