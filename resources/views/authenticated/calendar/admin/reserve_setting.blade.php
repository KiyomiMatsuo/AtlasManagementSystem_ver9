<!-- スクール枠登録画面 -->

<x-sidebar>
<div class="pt-5 pb-5" style="background:#ECF1F6;">
  <div class="w-100 d-flex" style="align-items:center; justify-content:center;">
    <div class="calender border w-75 m-auto pt-4 pb-4" style="border-radius:5px; background:#FFF;">
      <p class="text-center mb-2">{{ $calendar->getTitle() }}</p>
      <div class="w-100 vh-auto">

        {!! $calendar->render() !!}
        <div class="adjust-table-btn m-auto text-right">
          <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
        </div>
      </div>
    </div>
  </div>
</div>
</x-sidebar>
