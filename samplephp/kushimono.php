くしものぺーじ<input type="button" value="串物ページ" onClick="location.href='kushimono.php'">
<input type="button" value="アラカルトページ" onClick="location.href='alacarte.php'">
<input type="button" value="ドリンクページ" onClick="location.href='drink.php'">
<br>

<?php
$kusi_menu = glob('image/*.jpg');

foreach ($kusi_menu as $key => $value) {
    echo "キー「".$key."」は";// $keyにインデックスの文字が入っている
    echo "「".$value."」<br>"; // $valueにデータが入っている
}
?>
<?php
foreach ($kusi_menu as $key => $value) {
echo "<img src='$value' alt='$value' />";
}
?>

