$(function () {
  //.search_conditionsをクリックすると
  $('.search_conditions').click(function () {
    //.search_conditions_innerが変更される
    $('.search_conditions_inner').slideToggle();

    $('.search_conditions').toggleClass("open", 300);
  });

  //.subject_edit_btnをクリックすると
  $('.subject_edit_btn').click(function () {
    //.subject_innerが変更される
    $('.subject_inner').slideToggle();

    $('.subject_edit_btn').toggleClass("open", 300);
  });
});
