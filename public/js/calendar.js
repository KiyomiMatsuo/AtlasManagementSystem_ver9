$(function () {
  //部数を押した時に発火
  $('.cancel-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    //キャンセルボタンの値をJavaScriptで受け取って変数に入れている
    var value = $(this).attr('value');
    var reserve_part = $(this).attr('reserve_part');
    //その変数をモーダル側のclass=""にテキスト属性として送っている
    $('.reserve-day').text(value);
    $('.reserve-part').text(reserve_part);

    //cancel-modal-hidden-dateというクラスに変数valueを送っている
    $('.cancel-modal-hidden-date').val(value);
    //cancel-modal-hidden-partというクラスに変数reserve_partを送っている
    $('.cancel-modal-hidden-part').val(reserve_part);
    return false;
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });
});
