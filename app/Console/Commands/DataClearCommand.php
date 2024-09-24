<?php

namespace App\Console\Commands;

use App\Models\Media;
use App\Models\Task;
use Illuminate\Console\Command;
use Storage;

class DataClearCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'data:clear';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Stop tasks and delete media files';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    Media::cursor()->each(function (Media $media) {
      $media->delete();
    });

    Task::cursor()->each(function ($task) {
      $task->status = Task::STATUS_CLEANED;
      $task->save();
    });

    Storage::deleteDirectory('/files');
    Storage::deleteDirectory('/video');

    \Log::info('Data cleared');
  }
}
