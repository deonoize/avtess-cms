<?php

namespace Deonoize\AvtessCMS\Controllers;

use Deonoize\AvtessCMS\Classes\Models\DynamicPage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class SiteController
 * Opening page.
 * @package App\Http\Controllers\Admin
 */
class SiteController
    extends Controller
{
    /**
     * Page Index.
     *
     * @param  Request  $request
     *
     * @return Renderable|Factory|View
     */
    public function pageIndex(Request $request)
    {
        return $this->page($request, config('avtess_cms.site_page_index'));
    }

    /**
     * Page.
     *
     * @param  Request  $request
     * @param $page_name
     *
     * @return Renderable|Factory|View
     */
    public function page(Request $request, $page_name)
    {
        $page = $this->searchPage($page_name);
        $data = [
            'page' => $page
        ];
        $page->increment('views');
        $page->save();
        if ($page instanceof DynamicPage) {
            $class_name = 'App\\Http\\Controllers\\Site\\Pages\\'.ucfirst($page->controller).'Controller';
        } else {
            $class_name = 'App\\Http\\Controllers\\Site\\Pages\\'.ucfirst(basename(get_class($page))).'Controller';
        }
        return (new $class_name())->index($request, $data);
    }

    /**
     * Ajax Index
     *
     * @param  Request  $request
     * @return Renderable|Factory|View
     */
    public function ajaxIndex(Request $request)
    {
        return $this->ajax($request, config('avtess_cms.site_page_index'));
    }

    /**
     * Ajax
     *
     * @param  Request  $request
     * @param $page_name
     *
     * @return Renderable|Factory|View|void
     */
    public function ajax(Request $request, $page_name)
    {
        $page = $this->searchPage($page_name);
        $data = [
            'page' => $page
        ];
        if ($page instanceof DynamicPage) {
            $class_name = 'App\\Http\\Controllers\\Site\\Pages\\'.ucfirst($page->controller).'Controller';
        } else {
            $class_name = 'App\\Http\\Controllers\\Site\\Pages\\'.ucfirst(basename(get_class($page))).'Controller';
        }
        $pageController = (new $class_name());
        if (method_exists($pageController, 'ajax')) {
            return $pageController->ajax($request, $data);
        }
        abort(404);
    }

    /**
     * Searching page by name in page models.
     * @param  String  $page_name
     * @return array|void
     */
    private function searchPage(String $page_name)
    {
        $page_models = config('avtess_cms.site_page_models');
        foreach ($page_models as $class) {
            try {
                return $class::whereRoute($page_name)->firstOrFail();
            } catch (ModelNotFoundException $e) {
            }
        }
        abort(404);
    }
}
