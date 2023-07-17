<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MediaManager;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class ProductsPageController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:product_page'])->only('index');
        $this->middleware(['permission:product_details_page'])->only(['details', 'edit']);
    }

    # Products Page configuration
    public function index()
    {
        $categories = Category::latest()->get();
        return view('backend.pages.appearance.products.index', compact('categories'));
    }

    # get the widgets
    private function getWidgets()
    {
        $widgets = [];

        if (getSetting('product_page_widgets') != null) {
            $widgets = json_decode(getSetting('product_page_widgets'));
        }
        return $widgets;
    }

    # Products details Page configuration
    public function details()
    {
        $widgets = $this->getWidgets();
        return view('backend.pages.appearance.products.details', compact('widgets'));
    }

    # store widget
    public function storeWidget(Request $request)
    {
        $productPageWidget = SystemSetting::where('entity', 'product_page_widgets')->first();
        if (!is_null($productPageWidget)) {
            if (!is_null($productPageWidget->value) && $productPageWidget->value != '') {
                $widgets            = json_decode($productPageWidget->value);
                $newWidget          = new MediaManager; //temp obj
                $newWidget->id      = rand(100000, 999999);
                $newWidget->sub_title   = $request->sub_title ? $request->sub_title : '';
                $newWidget->title       = $request->title ? $request->title : '';
                $newWidget->image       = $request->image ? $request->image : '';

                array_push($widgets, $newWidget);
                $productPageWidget->value = json_encode($widgets);
                $productPageWidget->save();
            } else {
                $value                  = [];
                $newWidget              = new MediaManager; //temp obj
                $newWidget->id          = rand(100000, 999999);
                $newWidget->sub_title   = $request->sub_title ? $request->sub_title : '';
                $newWidget->title       = $request->title ? $request->title : '';
                $newWidget->image       = $request->image ? $request->image : '';

                array_push($value, $newWidget);
                $productPageWidget->value = json_encode($value);
                $productPageWidget->save();
            }
        } else {
            $productPageWidget = new SystemSetting;
            $productPageWidget->entity = 'product_page_widgets';

            $value              = [];
            $newWidget          = new MediaManager; //temp obj
            $newWidget->id      = rand(100000, 999999);
            $newWidget->sub_title   = $request->sub_title ? $request->sub_title : '';
            $newWidget->title       = $request->title ? $request->title : '';
            $newWidget->image       = $request->image ? $request->image : '';

            array_push($value, $newWidget);
            $productPageWidget->value = json_encode($value);
            $productPageWidget->save();
        }
        cacheClear();
        flash(localize('Widget added successfully'))->success();
        return back();
    }

    # store widget
    public function edit($id)
    {
        $widgets = $this->getWidgets();
        return view('backend.pages.appearance.products.detailsEdit', compact('widgets', 'id'));
    }

    # store widget
    public function update(Request $request)
    {
        $widget = SystemSetting::where('entity', 'product_page_widgets')->first();

        $widgets = $this->getWidgets();
        $tempWidgets = [];

        foreach ($widgets as $eachWidget) {
            if ($eachWidget->id == $request->id) {
                $eachWidget->sub_title   = $request->sub_title ? $request->sub_title : '';
                $eachWidget->title       = $request->title ? $request->title : '';
                $eachWidget->image       = $request->image ? $request->image : '';
                array_push($tempWidgets, $eachWidget);
            } else {
                array_push($tempWidgets, $eachWidget);
            }
        }

        $widget->value = json_encode($tempWidgets);
        $widget->save();
        cacheClear();
        flash(localize('Widget updated successfully'))->success();
        return redirect()->route('admin.appearance.products.details');
    }

    # store widget
    public function delete($id)
    {
        $widget = SystemSetting::where('entity', 'product_page_widgets')->first();

        $widgets = $this->getWidgets();
        $tempWidgets = [];

        foreach ($widgets as $eachWidget) {
            if ($eachWidget->id != $id) {
                array_push($tempWidgets, $eachWidget);
            }
        }

        $widget->value = json_encode($tempWidgets);
        $widget->save();

        cacheClear();
        flash(localize('Widget deleted successfully'))->success();
        return redirect()->route('admin.appearance.products.details');
    }
}
