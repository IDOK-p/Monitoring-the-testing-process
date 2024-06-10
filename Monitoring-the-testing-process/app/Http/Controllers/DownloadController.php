<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class DownloadController extends Controller
    {
        // Метод для скачивания APK-файла приложения
        public function downloadApp()
        {
            // Получаем путь к APK-файлу
            $file = public_path('apk/app-release.apk');

            // Устанавливаем заголовки для ответа
            $headers = ['Content-Type: application/vnd.android.package-archive'];

            // Возвращаем файл для скачивания пользователем с именем 'app-release.apk'
            return response()->download($file, 'app-release.apk', $headers);
        }
    }
