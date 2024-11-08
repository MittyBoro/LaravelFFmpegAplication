# Laravel FFmpeg API Приложение

[English](README.md)

Это приложение предоставляет API для выполнения различных операций с видеофайлами с использованием библиотеки FFmpeg в среде Laravel 10. С его помощью можно получить информацию о видео, создавать изображения, миниатюры, трейлеры, изменять размеры видео и отслеживать статус выполнения задач.

Построено на базе [protonemedia/laravel-ffmpeg](https://github.com/protonemedia/laravel-FFmpeg).

Приложение разработано с использованием Laravel Sail, который обеспечивает простоту установки и развертывания, а также совместимость с Docker-контейнерами для удобной разработки.

Docker-контейнер laravelffmpeg содержит установленный FFmpeg версии 6.

Для обработки задач используются очереди с драйвером базы данных.

## Маршруты

### Получение информации о видео
- **Метод:** POST
- **Путь:** /api/specifications
- **Параметры запроса:**
  - `src` (обязательный): URL исходного видео.
- **Описание:** Получение информации о видео: ширина, высота и продолжительность.
  **Пример ответа:**
```json
  {
    "width": 1920,
    "height": 1080,
    "duration": 120
  }
```

### Создание элементов

- **Метод:** POST
- **Путь:** /api/tasks/create/images
- **Параметры запроса:**
  - `src` (обязательный): URL исходного видео.
  - `webhook_url` (обязательный): URL для отправки уведомлений о завершении задачи.
  - `start` (необязательный): Начальная точка в видео.
  - `count` (необязательный): Количество изображений для создания.
  - `webhook_url` (необязательный): URL для отправки уведомлений о ходе выполнения и завершении задачи.
- **Описание:** Создает изображения из видео и возвращает ID задачи (`task_id`).

- **Метод:** POST
- **Путь:** /api/tasks/create/thumbnails
- **Параметры запроса:**
  - `src` (обязательный): URL исходного видео.
  - `webhook_url` (необязательный): URL для отправки уведомлений о ходе выполнения и завершении задачи.
- **Описание:** Создает миниатюры из видео и возвращает ID задачи (`task_id`).

- **Метод:** POST
- **Путь:** /api/tasks/create/trailer
- **Параметры запроса:**
  - `src` (обязательный): URL исходного видео.
  - `start` (необязательный): Начальная точка в видео.
  - `count` (обязательный): Количество кадров для создания трейлера.
  - `duration` (обязательный): Длительность трейлера.
  - `quality` (необязательный): Качество трейлера.
  - `webhook_url` (необязательный): URL для отправки уведомлений о ходе выполнения и завершении задачи.
- **Описание:** Создает трейлер из видео и возвращает ID задачи (`task_id`).

- **Метод:** POST
- **Путь:** /api/tasks/create/resize
- **Параметры запроса:**
  - `src` (обязательный): URL исходного видео.
  - `quality` (обязательный): Новое качество видео (высота).
  - `webhook_url` (необязательный): URL для отправки уведомлений о ходе выполнения и завершении задачи.
- **Описание:** Изменяет размер видео по высоте (`quality`) и возвращает ID задачи (`task_id`).

### Получение статуса задачи
- **Метод:** GET
- **Путь:** /api/tasks/{task_id}
- **Описание:** Этот маршрут позволяет получить текущий статус процесса выполнения задачи по её ID.

### Остановка задачи
- **Метод:** POST
- **Путь:** /api/tasks/{task_id}/stop
- **Описание:** Этот маршрут позволяет остановить выполнение задачи по её ID.
