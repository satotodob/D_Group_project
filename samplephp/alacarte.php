あらかるとぺーじ
<input type="button" value="串物ページ" onClick="location.href='kushimono.php'">
<input type="button" value="アラカルトページ" onClick="location.href='alacarte.php'">
<input type="button" value="ドリンクページ" onClick="location.href='drink.php'"><br>

<?php
$alacarte_menu = glob('image/アラカルトimg/*.jpg');

foreach ($alacarte_menu as $key => $value) {
    echo "キー「".$key."」は";// $keyにインデックスの文字が入っている
    echo "「".$value."」<br>"; // $valueにデータが入っている
}
?>

<?php
foreach ($alacarte_menu as $key => $value) {
echo "<img src='$value' alt='$value' />";
}
?>