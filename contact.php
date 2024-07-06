<?php
session_start();

// Membatasi Halaman sebelum Login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('LOGIN First !!!');
            document.location.href = 'login.php';
          </script>";
    exit;
}

$title = 'About Me';
include 'layout/header.php';
?>

<div class="container">
    <div class="header">
        <h1>About Me</h1>
    </div><!-- end header-->
    <div class="image">
        <img src="assets/other-img/Pas_Foto.jpg" width="15%">
    </div><!-- end image-->
    <div class="intro column">
        <h2>Introduction</h2>
        <p>
            I am a 26 year old, and still learning about web developer. I love to spend my free time playing game, reading a book and watching a movie. I love scifi and fantasy literature and
            series.
        </p>
    </div><!-- end intro-->
    <div class="skills column">
        <h3>My Skills</h3>
        <ul id="skill-list">
            <li>Junior Web Development</li>
            <li>Junior IT Support</li>
            <li>Teamwork</li>
            <li>Analytical skills</li>
        </ul><!--end skill-list-->
    </div><!-- end skills-->
    <div class="main-text">
        <h3>More About Me</h3>
        <p>
            I'm highly energetic and motivated person and I love to work as a member or a leader of a team. I especially enjoy working with changing projects and taking them forward with rapid pace but high precision. I am talkative and sociable but also known for getting "in the zone" while concentrating on detailed work like programming or designing.
        </p>
    </div><!-- end main-text-->
</div><!--end container-->

<?php
include 'layout/footer.php';
?>