<?php

namespace App\Traits;

use Inertia\Inertia;

trait InertiaResponseTrait
{
    
    public function generateInertiaResponse($success, $message='', $data = [], $view = 'Dashboard', $statusCode = 200)
    {
        if ($success) {
            return Inertia::render($view, [
                'success' => $success,
                'message' => __($message),
                'data' => $data,
            ]);
        }

        return redirect()->back()->with([
            'success' => $success,
            'message' => __($message),
            'data' => $data,
        ])->setStatusCode($statusCode);
    }
}
