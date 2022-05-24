<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\User;
use App\Notifications\RealTimeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        try {
            if ($this->data['path']) {
                $url = $this->data['path'];
                $info = pathinfo($url);
                $file_name = Str::random(5) . '_' . $info['basename'];
                $contents = file_get_contents($url);
                Storage::disk('public')->put($file_name, $contents);
            }

            Image::create([
                'user_id' => $this->data['user_id'],
                'path'    => $file_name,
            ]);

            $user = User::find($this->data['user_id']);
            // send notification to the user
            $user->notify(new RealTimeNotification('Image Uploaded Successfully.'));

        } catch (\Exception $e) {

        }
    }
}
