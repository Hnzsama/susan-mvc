<?php
// app/core/App.php - Application Bootstrap & Router Dispatcher

class App {
    public function __construct() {
        // Eksekusi routing deklaratif dari routes/web.php
        Route::dispatch();
    }
}
