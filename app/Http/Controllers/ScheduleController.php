<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\SocialMedia\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function manage()
    {
        $week = Schedule::getWeekDays();
        $socialMedias = SocialMedia::all();
        $schedules = Auth::user()->schedules;
        $socialMedias = $socialMedias->map(function($socialMedia) use ($schedules){
            $socialMedia->schedule = $schedules->where('social_media_id', $socialMedia->id)->first();
            return $socialMedia;
        });
        return view('schedule', ['week' => $week, 'socialMedias' => $socialMedias]);
    }

    /**
     * both insert or update
     */
    public function save(Request $request)
    {
        $userId = Auth::user()->id;
        $schedules = $request->get('data');
        foreach($schedules as $socialMediaId => $data) {
            if(is_null($data['weekday']) || is_null($data['time'])){
                return redirect()->back()->with('fail', 'Todos os campos são obrigatórios');
            }
        }
        foreach($schedules as $socialMediaId => $data) {
            $schedule = Schedule::where('user_id', $userId)
                    ->where('social_media_id', $socialMediaId)
                    ->first() ?? new Schedule();
            $schedule->fill($data);
            $schedule->user_id = $userId;
            $schedule->save();
        }

        return redirect()->back()->with('success', 'Cronograma salvo com sucesso');
    }
}
