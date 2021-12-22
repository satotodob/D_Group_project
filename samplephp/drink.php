drinkページ
<input type="button" value="串物ページ" onClick="location.href='kushimono.php'">
<input type="button" value="アラカルトページ" onClick="location.href='alacarte.php'">
<input type="button" value="ドリンクページ" onClick="location.href='drink.php'"><br>

<?php
$drink_menu = glob('image/ドリンクimg/*.jpg');

foreach ($drink_menu as $key => $value) {
    echo "キー「".$key."」は";
    echo "「".$value."」<br>";
}
?>
<?php
foreach ($drink_menu as $key => $value) {
echo "<img src='$value' alt='$value' />";
}
?>

