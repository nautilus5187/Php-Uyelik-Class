<?php
/**
 * Created by PhpStorm.
 * User: batuhansaygili
 * Date: 27.05.2016
 * Time: 21:28
 */
require ('class.uye.php');
$uyelik = new uye();
$uyelik->kayit('batukan','123456','batuhansaygili@hotmail.com.tr','batuhan','saygılı');
$uyelik->kayit('batukan1','1234561','batuhansaygili@hotmail.com.tr','batuhan2','saygılı2');
$uyelik->listele();