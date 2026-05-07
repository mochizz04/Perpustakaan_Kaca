<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireBookingCommand extends Command
{
    protected $signature = 'booking:expire';

    public function handle()
    {
        DB::table('tr_booking')
            ->where('status_booking', 'Aktif')
            ->where('expired_at', '<', now())
            ->update([
                'status_booking' => 'Expired',
                'updated_at' => now(),
            ]);
            $this->info('Booking expired berhasil diupdate');
    }
}
