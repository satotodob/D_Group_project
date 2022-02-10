$(document).ready(function() {
  
  for (var i=1; i<= countnum; i++) {
    $('#divno_'+ i).hide();
  }
 
  $('.re_pre').hide();
 
  $('input[name="item_check"]').change(function() {
  
    //チェックが入ったらループ処理
    $('input[name="item_check"]').each(function() {
        var choice_no = ($(this).val());
      if( $(this).prop("checked") != true ) {
        // チェックが入っていなかった場合
          $("#divno_"+ choice_no).hide();
          $(".form_"+ choice_no).prop('disabled', true);
          
        } else {
        // チェックが入っていた場合
          $("#divno_"+ choice_no).show();
          $(".form_"+ choice_no).prop('disabled', false);
        }
    });

    //checkついている数が1以上で送信ボタン表示
    if ($('input[name="item_check"]:checked').length > 0) {
      $('.re_pre').show();
    }else{
      $('.re_pre').hide();
    }
  });

});