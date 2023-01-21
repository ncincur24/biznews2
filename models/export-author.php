<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=nemanja.doc");
$biography_string ="My name is Nemanja Ćinćur. I Web Developer and student, currently styding at ICT college. I am constantly trying to improve myself each day. I am skilled with HTML, CSS, BOOTSTRAP, JS, PHP and many more languages. Till now I had few projects but there are many more comming soon. You can view my works on this website. If you like them, you can contact my on my mail, or call me on my phone, whatever you prefer. I hope we will get in touch.";
echo $biography_string;