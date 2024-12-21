<x-sidebar>
  <div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center;">
    <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="w-75 m-auto">
        <div class="w-100">
          <p>{!! $calendar->render() !!}</p>
        </div>
      </div>
    </div>
  </div>
</div>
</x-sidebar>
