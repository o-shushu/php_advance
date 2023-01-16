$(function() {

    $(".delete").click(function() {
    if(!confirm("削除を実行しますか？")) {
      return false;
    } else {
      return $flag = 1;
    }
  });

});