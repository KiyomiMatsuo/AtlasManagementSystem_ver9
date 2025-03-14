<!-- 予約詳細確認画面 -->

<x-sidebar>
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="border p-2 reserve_detail_area">
      <table class="border w-100 m-auto">
        <tr class="text-center list">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        @foreach($reservePersons as $reservePerson)<!-- 予約枠の情報を取得している -->
        @foreach($reservePerson->users as $user)<!-- 予約枠一つ一つのユーザーの情報を取得している -->
        <tr class="text-center border reserve-row">
          <td class="w-25">{{$user->id}}</td>
          <td class="w-25">{{$user->over_name}} {{$user->under_name}}</td>
          <td class="w-25">リモート</td>
        </tr>
        @endforeach
        @endforeach

      </table>
    </div>
  </div>
</div>
</x-sidebar>
