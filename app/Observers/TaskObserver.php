<?php

namespace App\Observers;

use App\Jobs\ProcessVideoJob;
use App\Models\Task;
use App\Services\FFmpeg\StorageService;
use Illuminate\Support\Facades\Http;

class TaskObserver
{
  /**
   * Handle the Task "created" event.
   */
  public function created(Task $task): void
  {
    ProcessVideoJob::dispatch($task->id)->onQueue($task->getQueue());
  }

  /**
   * Handle the Task "updated" event.
   */
  public function updated(Task $task): void
  {
    if ($task->wasChanged('status') && $task->status === Task::STATUS_CLEANED) {
      StorageService::init($task->id)->delete();
    }

    if ($task->webhook_url && $task->status !== Task::STATUS_CLEANED) {
      try {
        $response = Http::retry(2, 200, throw: false)->post(
          $task->webhook_url,
          $task,
        );
        $status = $response->status();
      } catch (\Throwable $exception) {
        return;
      }

      if (
        (int) $status >= 400 &&
        $status < 500 &&
        $task->wasChanged('status')
      ) {
        $task->fail($response->body(), false);
      }
    }
  }

  /**
   * Handle the Task "deleted" event.
   */
  public function deleted(Task $task): void
  {
    StorageService::init($task->id)->delete();
  }
}
