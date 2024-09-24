# Laravel FFmpeg API Application

This application provides an API for performing various operations on video files using the FFmpeg library in the Laravel 10 environment. With its help, you can get information about the video, create images, thumbnails, trailers, resize video, and track the status of task execution.

Built on top of [protonemedia/laravel-ffmpeg](https://github.com/protonemedia/laravel-FFmpeg)

The application is developed using Laravel Sail, which provides ease of installation and deployment, as well as compatibility with Docker containers for convenient development.

The laravelffmpeg Docker container has FFmpeg 6 installed.

Queues with the database driver are used for processing.

## Routes

### Get Video Information
- **Method:** POST
- **Path:** /api/specifications
- **Request Parameters:**
  - `src` (required): URL of the source video.
- **Description:** Get information about the video: width, height, and duration.
  **Example Response:**
```json
  {
    "width": 1920,
    "height": 1080,
    "duration": 120
  }
```

### Create Items

- **Method:** POST
- **Path:** /api/tasks/create/images
- **Request Parameters:**
  - `src` (required): URL of the source video.
  - `webhook_url` (required): URL to send notifications about task completion.
  - `start` (optional): Starting point in the video.
  - `count` (optional): Number of images to create.
  - `webhook_url` (optional): URL to send notifications about progress and completion of the task.
- **Description:** Creates images from the video and returns the task ID (`task_id`).

- **Method:** POST
- **Path:** /api/tasks/create/thumbnails
- **Request Parameters:**
  - `src` (required): URL of the source video.
  - `webhook_url` (optional): URL to send notifications about progress and completion of the task.
- **Description:** Creates thumbnails from the video and returns the task ID (`task_id`).

- **Method:** POST
- **Path:** /api/tasks/create/trailer
- **Request Parameters:**
  - `src` (required): URL of the source video.
  - `start` (optional): Starting point in the video.
  - `count` (required): Number of frames to create the trailer.
  - `duration` (required): Duration of the trailer.
  - `quality` (optional): Quality of the trailer.
  - `webhook_url` (optional): URL to send notifications about progress and completion of the task.
- **Description:** Creates a trailer from the video and returns the task ID (`task_id`).

- **Method:** POST
- **Path:** /api/tasks/create/resize
- **Request Parameters:**
  - `src` (required): URL of the source video.
  - `quality` (required): New video quality (height)
  - `webhook_url` (optional): URL to send notifications about progress and completion of the task.
- **Description:** Resizes the video by height (`quality`) and returns the task ID (`task_id`).

### Get Process Status
- **Method:** GET
- **Path:** /api/tasks/{task_id}
- **Description:** This route allows you to get the current status of the task process by its ID.

### Stop Process
- **Method:** POST
- **Path:** /api/tasks/{task_id}/stop
- **Description:** This route allows you to stop the execution of a task by its ID.
