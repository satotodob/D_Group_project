<!DOCTYPE html>
<html>
    <head>
        <title>ドリンクメニュー</title>
        <meta charset="utf-8">

         <!-- Bootstrap CSS -->
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
         <link rel="stylesheet" href="drink.css">

    </head>
    <body>
        <h1 name="drink">飲み物</h1>

        <div id="main" class="site-width"><!-- メイン画面 -->
            <div class="container-area"><!-- 画像選択 -->
                <div class="drink-area">
                    <div class="drink-form-container">
                        <div id="drink_img">
                            <?php
                                $num = 0;
                                $images = glob('drinkimg\*.jpg');
                                foreach($images as $image)
                                {
                                    $num = $num + 1;
                                    print ('<form method="post">');
                                    print ('<img src="'.$image.'" style="width:294px">');
                                    print ('<input class=drink_img type="button" name="$num" data-toggle="modal" data-target="#modal1" style="height:195px">');
                                    print ('</form>');
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="table">
            <table border="1">
                <tr>
                    <th>商品画像</th>
                    <td>商品名</td>
                    <td>
                        <select>
                            <option>注文数</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </td>
                    <td>
                        <input type="button" name="order_list" value="注文取消">
                    </td>
                </tr>
            </table>
        </div>

        <input type="button" name="back" value="戻る">
        <input type="button" name="history" value="履歴">
        <input type="button" name="confirm" value="確定">



            <div class="modal fade" data-backdrop="true" id="modal1" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="label1"><?php print $num; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <a href="#" role="button" class="btn btn-secondary popover-test" title="Popover title" data-content="Popover body content is set in this attribute.">1</a>
                            <a href="#" role="button" class="btn btn-secondary popover-test" title="Popover title" data-content="Popover body content is set in this attribute.">2</a>
                            <a href="#" role="button" class="btn btn-secondary popover-test" title="Popover title" data-content="Popover body content is set in this attribute.">3</a>
                            <a href="#" role="button" class="btn btn-secondary popover-test" title="Popover title" data-content="Popover body content is set in this attribute.">4</a>
                            <a href="#" role="button" class="btn btn-secondary popover-test" title="Popover title" data-content="Popover body content is set in this attribute.">5</a>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
                                <button type="button" class="btn btn-primary">確定</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>