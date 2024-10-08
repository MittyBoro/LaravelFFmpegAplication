<?php

return [
  'ffmpeg' => [
    'binaries' => env('FFMPEG_BINARIES', 'ffmpeg'),

    'threads' => env('FFMPEG_THREADS', 1), // set to false to disable the default 'threads' filter
  ],

  'ffprobe' => [
    'binaries' => env('FFPROBE_BINARIES', 'ffprobe'),
  ],

  'timeout' => 21600,

  'log_channel' => env('LOG_CHANNEL', 'stack'), // set to false to completely disable logging
  'log_channel' => false,

  'temporary_files_root' => env(
    'FFMPEG_TEMPORARY_FILES_ROOT',
    sys_get_temp_dir(),
  ),

  'temporary_files_encrypted_hls' => env(
    'FFMPEG_TEMPORARY_ENCRYPTED_HLS',
    env('FFMPEG_TEMPORARY_FILES_ROOT', sys_get_temp_dir()),
  ),
];
