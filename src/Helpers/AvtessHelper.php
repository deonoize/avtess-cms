<?php

namespace Deonoize\AvtessCMS\Helpers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class AvtessHelper {
    /**
     * Get page view from current template.
     *
     * @param  string  $page
     * @param $data
     *
     * @return Factory|View
     */
    static public function getPageView(string $page, array $data) {
        return view(AvtessHelper::getTemplateViewPath().'pages.'.$page, $data);
    }

    /**
     * Get current template view path.
     *
     * @param  bool  $addDotOnEnd
     *
     * @return string
     */
    static public function getTemplateViewPath(bool $addDotOnEnd = true) {
        return 'templates.'.config('avtess_cms.template').($addDotOnEnd ? '.' : '');
    }

    /**
     * Get page view from current template.
     *
     * @param  string  $view
     * @param $data
     *
     * @return Factory|View
     */
    static public function getView(string $view, $data) {
        return view('templates.'.config('avtess_cms.template').$view, $data);
    }

    /**
     * Print message on screen like log message.
     *
     * @param  string  $message
     * @param  string|null  $category
     *
     * @return void
     */

    static public function logInScreen(string $message, string $category = null) {
        if (!is_scalar($message)) {
            $message = print_r($message, 1);
        }

        echo date('Y-m-d H:i:s')." [$category] ".$message."\n";
    }
}
