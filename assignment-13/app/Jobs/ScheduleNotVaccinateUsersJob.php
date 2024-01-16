<?php

namespace App\Jobs;

use App\Constants\Status;
use App\Mail\VaccinationScheduled;
use App\Models\User;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ScheduleNotVaccinateUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $allCenter = VaccineCenter::all();

        foreach ($allCenter as $center) {
            $dailyLimit = $center->daily_limit;

            $notVaccinatedUsers = User::with('vaccinated_center')
                ->where('vaccine_center_id', $center->id)
                ->where('status', Status::NOT_VACCINATED)
                ->orderBy('id')
                ->limit($dailyLimit)
                ->get();

            foreach ($notVaccinatedUsers as $user) {
                // Check if the user has a vaccinated center
                if ($user->vaccinated_center !== null) {
                    $email = $user->email;

                    // Check if the user's vaccinated center has a name
                    $vaccineCenterName = $user->vaccinated_center->name ?? 'Unknown Center';

                    User::where('email', $email)->update([
                        'status' => Status::SCHEDULED,
                        'scheduled_date' => now()
                    ]);

                    $mail = new VaccinationScheduled($user->name, $vaccineCenterName);

                    Mail::to($email)->send($mail);
                }
            }

        }

    }
}
