<?php

namespace App\Jobs;

use App\Models\SongDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSongDetails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $records;
    /**
     * Create a new job instance.
     */
    public function __construct($records)
    {
        $this->records = $records;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $timestamp = now()->toDateTimeString();
        $insertData = [];

        foreach ($this->records as $record) {
            $insertData[] = [
                'user_id' => $record['user_id'],
                'song_id' => $record['song_id'],
                'r_date' => $record['r_date'],
                'sale_month' => $record['sale_month'],
                'store' => $record['store'],
                'quantity' => $record['quantity'],
                'country_of_sale' => $record['country_of_sale'],
                'earnings_usd' => $record['earnings_usd'],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }
        // Log::info('Handling ProcessSongDetails job', ['records' => $this->records]);

        // Log::info('Processing song details', ['records' => $this->records]);

        try {
            SongDetail::insert($insertData);
            
        } catch (\Exception $e) {
            Log::error('Error inserting records:', ['error' => $e->getMessage()]);
            // Handle or log any exceptions here
        }
    }
}
