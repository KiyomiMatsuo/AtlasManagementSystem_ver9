<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            //dd($getPart,$getDate);
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request){
        DB::beginTransaction();
        try{
            //dd($request);
            $deleteDate = $request->date;
            $deletePart = $request->part;
            //dd($deleteDate,$deletePart);
            //予約データの削除
            // $reserveDays = array_filter(delete($deleteDate, $deletePart));
            // foreach($reserveDays as $key => $value){
                if($deletePart == "リモ1部"){
                $deletePart = 1;
                  }else if($deletePart == "リモ2部"){
                $deletePart = 2;
                  }else if($deletePart == "リモ3部"){
                $deletePart = 3;
          }
                $delete_settings = ReserveSettings::where('setting_reserve', $deleteDate)->where('setting_part', $deletePart)->first();
                //dd($delete_settings);
                //予約枠の更新（予約可能の人数を増やす）
                $delete_settings->increment('limit_users');
                $delete_settings->users()->detach(Auth::id());
            // }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }


}
