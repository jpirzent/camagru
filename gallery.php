<?php

    include_once 'header.php';

    if (isset($_SESSION['u_id']))
    {
        include_once 'includes/dbh.inc.php';
        $sql = "SELECT image FROM images";
        $check = $conn->prepare($sql);
        $check->execute();
        $row = $check->fetch(PDO::FETCH_ASSOC);
        if ($row)
        {
            $imgData = $row['image'];
            //header("Content-type: image/jpeg");
            echo '<img src="data:image/jpeg;base64,'.str_replace(" ", "+", base64_encode($imgData)).'">';
        }
        else
        {
            echo "no image found";
        }
    }
    
    include_once 'footer.php';

?>