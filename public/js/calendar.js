$(function () {

  $('.cancel-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    var value = $(this).attr('value');
    var reserve_part = $(this).attr('reserve_part');

    $('.reserve-day').text(value);
    $('.reserve-part').text(reserve_part);
    $('.cancel-modal-hidden').val(cancel_id);
    return false;
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });
});
