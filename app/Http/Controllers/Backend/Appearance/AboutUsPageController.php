<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\MediaManager;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class AboutUsPageController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:about_us_page'])->only(['index', 'popularBrands', 'features', 'edit', 'delete', 'whyChooseUs', 'deleteWhyChooseUs']);
    }

    # about us intro section
    public function index()
    {
        return view('backend.pages.appearance.aboutUs.intro');
    }

    # about us popular brands section
    public function popularBrands()
    {
        $brands = Brand::isActive()->get();
        return view('backend.pages.appearance.aboutUs.popularBrands', compact('brands'));
    }

    # get the features
    private function getFeatures()
    {
        $features = [];

        if (getSetting('about_us_features') != null) {
            $features = json_decode(getSetting('about_us_features'));
        }
        return $features;
    }

    # features section
    public function features()
    {
        $features = $this->getFeatures();
        return view('backend.pages.appearance.aboutUs.features', compact('features'));
    }

    # store features
    public function storeFeatures(Request $request)
    {
        $aboutUsFeatures = SystemSetting::where('entity', 'about_us_features')->first();
        if (!is_null($aboutUsFeatures)) {
            if (!is_null($aboutUsFeatures->value) && $aboutUsFeatures->value != '') {
                $features            = json_decode($aboutUsFeatures->value);
                $newFeature          = new MediaManager; //temp obj
                $newFeature->id      = rand(100000, 999999);
                $newFeature->title       = $request->title ? $request->title : '';
                $newFeature->text        = $request->text ? $request->text : '';
                $newFeature->image       = $request->image ? $request->image : '';

                array_push($features, $newFeature);
                $aboutUsFeatures->value = json_encode($features);
                $aboutUsFeatures->save();
            } else {
                $value                  = [];
                $newFeature              = new MediaManager; //temp obj
                $newFeature->id          = rand(100000, 999999);
                $newFeature->title       = $request->title ? $request->title : '';
                $newFeature->text        = $request->text ? $request->text : '';
                $newFeature->image       = $request->image ? $request->image : '';
                array_push($value, $newFeature);
                $aboutUsFeatures->value = json_encode($value);
                $aboutUsFeatures->save();
            }
        } else {
            $aboutUsFeatures = new SystemSetting;
            $aboutUsFeatures->entity = 'about_us_features';

            $value              = [];
            $newFeature          = new MediaManager; //temp obj
            $newFeature->id      = rand(100000, 999999);
            $newFeature->title       = $request->title ? $request->title : '';
            $newFeature->text        = $request->text ? $request->text : '';
            $newFeature->image       = $request->image ? $request->image : '';

            array_push($value, $newFeature);
            $aboutUsFeatures->value = json_encode($value);
            $aboutUsFeatures->save();
        }
        cacheClear();
        flash(localize('Feature added successfully'))->success();
        return back();
    }

    # edit feature
    public function edit($id)
    {
        $features = $this->getFeatures();
        return view('backend.pages.appearance.aboutUs.featureEdit', compact('features', 'id'));
    }

    # update feature
    public function update(Request $request)
    {
        $aboutUsFeatures = SystemSetting::where('entity', 'about_us_features')->first();

        $features = $this->getFeatures();
        $tempFeatures = [];

        foreach ($features as $feature) {
            if ($feature->id == $request->id) {
                $feature->title      = $request->title;
                $feature->text       = $request->text;
                $feature->image      = $request->image;
                array_push($tempFeatures, $feature);
            } else {
                array_push($tempFeatures, $feature);
            }
        }

        $aboutUsFeatures->value = json_encode($tempFeatures);
        $aboutUsFeatures->save();
        cacheClear();
        flash(localize('Feature updated successfully'))->success();
        return redirect()->route('admin.appearance.about-us.features');
    }

    # delete feature
    public function delete($id)
    {
        $aboutUsFeatures = SystemSetting::where('entity', 'about_us_features')->first();

        $features = $this->getFeatures();
        $tempFeatures = [];

        foreach ($features as $feature) {
            if ($feature->id != $id) {
                array_push($tempFeatures, $feature);
            }
        }

        $aboutUsFeatures->value = json_encode($tempFeatures);
        $aboutUsFeatures->save();

        cacheClear();
        flash(localize('Feature deleted successfully'))->success();
        return redirect()->route('admin.appearance.about-us.features');
    }

    # get the why choose us widgets
    private function getWhyChooseUs()
    {
        $why_choose_us = [];

        if (getSetting('about_us_why_choose_us') != null) {
            $why_choose_us = json_decode(getSetting('about_us_why_choose_us'));
        }
        return $why_choose_us;
    }

    # why choose us section
    public function whyChooseUs()
    {
        $why_choose_us = $this->getWhyChooseUs();
        return view('backend.pages.appearance.aboutUs.whyChooseUs', compact('why_choose_us'));
    }

    # store why_choose_us
    public function storeWhyChooseUs(Request $request)
    {
        $whyChooseUs = SystemSetting::where('entity', 'about_us_why_choose_us')->first();
        if (!is_null($whyChooseUs)) {
            if (!is_null($whyChooseUs->value) && $whyChooseUs->value != '') {
                $why_choose_us       = json_decode($whyChooseUs->value);
                $newWhyChooseUs          = new MediaManager; //temp obj
                $newWhyChooseUs->id      = rand(100000, 999999);
                $newWhyChooseUs->title       = $request->title ? $request->title : '';
                $newWhyChooseUs->text        = $request->text ? $request->text : '';
                $newWhyChooseUs->image       = $request->image ? $request->image : '';

                array_push($why_choose_us, $newWhyChooseUs);
                $whyChooseUs->value = json_encode($why_choose_us);
                $whyChooseUs->save();
            } else {
                $value                  = [];
                $newWhyChooseUs              = new MediaManager; //temp obj
                $newWhyChooseUs->id          = rand(100000, 999999);
                $newWhyChooseUs->title       = $request->title ? $request->title : '';
                $newWhyChooseUs->text        = $request->text ? $request->text : '';
                $newWhyChooseUs->image       = $request->image ? $request->image : '';
                array_push($value, $newWhyChooseUs);
                $whyChooseUs->value = json_encode($value);
                $whyChooseUs->save();
            }
        } else {
            $whyChooseUs = new SystemSetting;
            $whyChooseUs->entity = 'about_us_why_choose_us';

            $value              = [];
            $newWhyChooseUs          = new MediaManager; //temp obj
            $newWhyChooseUs->id      = rand(100000, 999999);
            $newWhyChooseUs->title       = $request->title ? $request->title : '';
            $newWhyChooseUs->text        = $request->text ? $request->text : '';
            $newWhyChooseUs->image       = $request->image ? $request->image : '';

            array_push($value, $newWhyChooseUs);
            $whyChooseUs->value = json_encode($value);
            $whyChooseUs->save();
        }
        cacheClear();
        flash(localize('Widget added successfully'))->success();
        return back();
    }

    # edit feature
    public function editWhyChooseUs($id)
    {
        $why_choose_us = $this->getWhyChooseUs();
        return view('backend.pages.appearance.aboutUs.whyChooseUsEdit', compact('why_choose_us', 'id'));
    }

    # update feature
    public function updateWhyChooseUs(Request $request)
    {
        $whyChooseUs = SystemSetting::where('entity', 'about_us_why_choose_us')->first();

        $why_choose_us = $this->getWhyChooseUs();
        $tempWhyChooseUs = [];

        foreach ($why_choose_us as $each_why_choose_us) {
            if ($each_why_choose_us->id == $request->id) {
                $each_why_choose_us->title      = $request->title;
                $each_why_choose_us->text       = $request->text;
                $each_why_choose_us->image      = $request->image;
                array_push($tempWhyChooseUs, $each_why_choose_us);
            } else {
                array_push($tempWhyChooseUs, $each_why_choose_us);
            }
        }

        $whyChooseUs->value = json_encode($tempWhyChooseUs);
        $whyChooseUs->save();
        cacheClear();
        flash(localize('Widget updated successfully'))->success();
        return redirect()->route('admin.appearance.about-us.whyChooseUs');
    }

    # delete feature
    public function deleteWhyChooseUs($id)
    {
        $whyChooseUs = SystemSetting::where('entity', 'about_us_why_choose_us')->first();

        $why_choose_us = $this->getWhyChooseUs();
        $tempWhyChooseUs = [];

        foreach ($why_choose_us as $each_why_choose_us) {
            if ($each_why_choose_us->id != $id) {
                array_push($tempWhyChooseUs, $each_why_choose_us);
            }
        }

        $whyChooseUs->value = json_encode($tempWhyChooseUs);
        $whyChooseUs->save();

        cacheClear();
        flash(localize('Widget deleted successfully'))->success();
        return redirect()->route('admin.appearance.about-us.whyChooseUs');
    }
}
