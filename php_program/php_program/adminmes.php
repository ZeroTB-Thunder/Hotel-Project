<?php

include 'Database/compoment/connect.php';

if(isset($_POST['delete'])){

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `messages` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_bookings = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
      $delete_bookings->execute([$delete_id]);
      $success_msg[] = 'Message deleted!';
   }else{
      $warning_msg[] = 'Message deleted already!';
   }

}

?>

<!DOCTYPE html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GACHA HOTEL</title>
    <link rel="stylesheet" href="css/dashstyle.css">
</head>
<body>
<header>
    <div id="menu-bar" class="fas fa-bars"></div>
    <a class="logo"><span>G</span>ACHA HOTEL</a>
    <nav class="navbar">
        <a href="dashboard.php">Home</a>
        <a href="adminbook.php">Bookings</a>
        <a href="adminmes.php">Messages</a>
        <a href="logout.php" onclick="return confirm('Do yo want to logout from this website?');">Logout</a>
    </nav>
    </header>
    <section class="grid">
        <h1 class="heading">Messages</h1>
        <div class="box-container">
            <?php
           $select_messages = $conn->prepare("SELECT * FROM `messages`");
           $select_messages->execute();
           if($select_messages->rowCount() > 0){
              while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
        ?>
            <div class="box">
                    <p>Message ID : <span><?= $fetch_messages['id']; ?></span></p>
                    <p>Name : <span><?= $fetch_messages['name']; ?></span></p>
                    <p>Email : <span><?= $fetch_messages['email']; ?></span></p>
                    <p>Number : <span><?= $fetch_messages['number']; ?></span></p>
                    <p>Subject : <span><?= $fetch_messages['subject']; ?></span></p>
                    <p>Message : <span><?= $fetch_messages['message']; ?></span></p>
                <form action="" method="POST">
                    <input type="hidden" name="delete_id" value="<?= $fetch_messages['id']; ?>">
                    <input type="submit" value="delete message" onclick="return confirm('Delete this message?');" name="delete" class="btn">
               </form>
              </div>
            <?php
                   }
                }else{           
            ?>
        <div class="box" style="text-align:center;">
        <p>No messages avaible!</p>
    </div>
            <?php
                }
            ?>
</div>
            </section>
</body>
</html>