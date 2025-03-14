<!-- スクール予約（全員）画面 -->

<x-sidebar>
<div class="pt-5 pb-5" style="background:#ECF1F6;">
  <div class="calender border w-75 m-auto pt-4 pb-4" style="border-radius:5px; background:#FFF;">
    <p class="text-center mb-2">{{ $calendar->getTitle() }}</p>
    <div class="calender_outline m-auto" style="border-radius:5px;">
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="adjust-table-btn text-right mt-4">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('deleteParts') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-reserve w-50 m-auto">
          <p>予約日：<span class="reserve-day"></span></p>
          <p>時間：<span class="reserve-part"></span></p>
          <p>上記の予約をキャンセルしてもよろしいですか？</p>
        </div>
        <!-- <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
        </div> -->
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-primary d-inline-block" href="">閉じる</a>
          <!-- 日付を送るためのinput -->
          <input type="hidden" class="cancel-modal-hidden-date" name="date" value="">
          <!-- 部を送るためのinput -->
          <input type="hidden" class="cancel-modal-hidden-part" name="part" value="">
          <input type="submit" class="btn btn-danger d-block" value="キャンセル">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>

</x-sidebar>
