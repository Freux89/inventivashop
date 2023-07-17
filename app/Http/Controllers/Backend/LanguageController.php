<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Localization;
use Illuminate\Http\Request;
use Cache;

class LanguageController extends Controller
{

    # construct
    public function __construct()
    {
        $this->middleware(['permission:language_settings'])->only('index');
        $this->middleware(['permission:add_languages'])->only('store');
        $this->middleware(['permission:edit_languages'])->only(['edit', 'update']);
        $this->middleware(['permission:translate_languages'])->only(['showLocalizations']);
        $this->middleware(['permission:publish_languages'])->only(['updateStatus']);
        $this->middleware(['permission:default_languages'])->only(['defaultLanguage']);
    }

    # change the language
    public function changeLanguage(Request $request)
    {
        $request->session()->put('locale', $request->locale);
        return true;
    }

    # language list
    public function index(Request $request)
    {
        $searchKey = null;
        $languages = Language::oldest();
        if ($request->search != null) {
            $languages = $languages->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        $languages = $languages->get();
        return view('backend.pages.systemSettings.language', compact('languages', 'searchKey'));
    }

    # store language
    public function store(Request $request)
    {
        if (Language::where('code', $request->code)->first()) {
            flash(localize('This code is already used for another language'))->error();
            return back();
        }

        $language = new Language;
        $language->name = $request->name;
        $language->flag = $request->flag;
        $language->code = $request->code;
        $language->is_rtl = $request->is_rtl;
        $language->save();

        Cache::forget('languages');

        flash(localize('Language has been inserted successfully'))->success();
        return back();
    }

    # edit language
    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('backend.pages.systemSettings.languageEdit', compact('language'));
    }

    # update language
    public function update(Request $request)
    {
        $checkLanguage = Language::where('code', $request->code)->first();
        $language = Language::findOrFail($request->id);

        if (
            $checkLanguage &&
            $checkLanguage->id != $language->id
        ) {
            flash(localize('This code is already used for another language'))->error();
            return back();
        }

        if ($language->id != 1) {
            $language->code = $request->code;
        }

        $language->name = $request->name;
        $language->flag = $request->flag;
        $language->is_rtl = $request->is_rtl;

        $language->save();

        Cache::forget('languages');
        flash(localize('Language has been updated successfully'))->success();
        return back();
    }

    # update status 
    public function updateStatus(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $activatedLanguages = Language::where('is_active', 1)->count();

        if (env('DEFAULT_LANGUAGE') == $language->code && $request->is_active == 0) {
            return [
                'status'    => false,
                'message'    => localize('Default language can not be disabled'),
            ];
        } elseif ($activatedLanguages <= 1 && $request->is_active == 0) {
            return [
                'status'    => false,
                'message'    => localize('Minimum 1 language need to be enabled'),
            ];
        }

        $language->is_active = $request->is_active;
        if ($language->save()) {
            return [
                'status'    => true,
                'message'    => localize('Status updated successfully'),
            ];
        }

        return [
            'status'    => false,
            'message'    => localize('Something went wrong'),
        ];
    }

    # update default language 
    public function defaultLanguage(Request $request)
    {
        $language = Language::where('code', $request->DEFAULT_LANGUAGE)->first();
        $language->is_active = 1;
        $language->save();

        writeToEnvFile('DEFAULT_LANGUAGE', $request->DEFAULT_LANGUAGE);
        return [
            'message' => localize('Default language updated successfully')
        ];
    }

    # localizations
    public function showLocalizations(Request $request, $id)
    {
        $searchKey = null;
        $language = Language::findOrFail($id);
        $localizations = Localization::where('lang_key', 'en');
        if ($request->has('search')) {
            $searchKey = $request->search;
            $localizations = $localizations->where('t_value', 'like', '%' . $searchKey . '%');
        }
        $localizations = $localizations->paginate(30);
        return view('backend.pages.systemSettings.languageLocalizations', compact('language', 'localizations', 'searchKey'));
    }

    # add localizations
    public function key_value_store(Request $request)
    {
        $language = Language::findOrFail($request->id);
        foreach ($request->values as $key => $value) {
            $localization = Localization::where('t_key', $key)->where('lang_key', $language->code)->latest()->first();
            if ($localization == null) {
                $localization = new Localization;
                $localization->lang_key = $language->code;
                $localization->t_key = $key;
                $localization->t_value = $value ? $value : $key;
                $localization->save();
            } else {
                $localization->t_value = $value ? $value : $key;;
                $localization->save();
            }
        }
        Cache::forget('localizations-' . $language->code);

        flash(localize('Localizations have been updated'))->success();
        return back();
    }
}
