<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> About | RouteRover </title>

  <!-- Style Sheet -->
  <link rel="stylesheet" href="css/about.css">
  <?php include 'src/inc.php'; ?>

  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png">
  <link rel="manifest" href="favicon_io/site.webmanifest">
</head>

<body>
  <?php include 'src/inc/header.php'; ?>
  <section id="#about">
    <h2 class="abt-h2">আমাদের উদ্দেশ্য ও কাজ</h2>
    <div class="about">
      <div class="content">
        <p>আমরা চট্টগ্রাম শহরে যাতায়াত ব্যবস্থায় সহায়তাকারী একটি সেবা প্রতিষ্ঠান। মূলত এই সেবা প্রদানকারী ওয়েবসাইটটি
          আমাদের বিশ্ববিদ্যালয়ের প্রাতিষ্ঠানিক একটি প্রজেক্টের অংশ। আমরা চট্টগ্রাম শহরে যাতায়াতে যানবাহন ব্যবহার করার
          কাজটাকে আরো সহজ করতে প্রজেক্টটির উদ্দ্যোগ নিয়েছি।
          আমাদের প্রজেক্টের মূল উদ্দেশ্য হল চট্টগ্রাম শহরে যাতায়াতে যানবাহন ব্যবহার করার সময় সঠিক ও সহজ রাস্তা প্রদর্শন
          করা এবং যাতায়াতয়া খরচ সম্পর্কে যথাযথ তথ্য পাওয়া। </p><br>
        <p>এই প্রজেক্ট নিয়ে কাজ করছে চট্টগ্রাম প্রকৌশল ও প্রযুক্তি বিশ্ববিদ্যালয়ের ইলেকট্রনিক্স ও টেলিকমিউনিকেশন বিভাগের
          দুইজন শিক্ষার্থী ফারহান তানভীর(ID: 2008060) ও তানভীর আহমেদ সিফাত(ID: 2008018)। </p>
      </div>
    </div>
  </section>
  <!-- ----------------- Footer Section --------------- -->
  <?php include 'src/inc/footer.php'; ?>
</body>

</html>