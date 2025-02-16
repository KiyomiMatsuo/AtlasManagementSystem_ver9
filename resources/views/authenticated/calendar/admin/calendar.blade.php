<!-- スクール予約確認(教師) -->

<x-sidebar>
<div class="pt-5 pb-5" style="background:#ECF1F6;">
  <div class="w-100 d-flex" style="align-items:center; justify-content:center;">
    <div class="calender border w-75 m-auto pt-4 pb-4" style="border-radius:5px; background:#FFF;">
      <p class="text-center mb-2">{{ $calendar->getTitle() }}</p>
      <div class="calender_outline m-auto">
        <div class="w-100">
          <p>{!! $calendar->render() !!}</p>
        </div>
      </div>
    </div>
  </div>
</div>
</x-sidebar>
