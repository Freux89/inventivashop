<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Mail\EmailManager;
use App\Models\Currency;
use Artisan;
use Mail;

class SettingsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:general_settings'])->only('index');
        $this->middleware(['permission:smtp_settings'])->only('smtpSettings');
        $this->middleware(['permission:payment_settings'])->only(['paymentMethods', 'updatePaymentMethods']);
    }

    # admin general settings
    public function index()
    {
        return view('backend.pages.systemSettings.general');
    }


    # smtp settings
    public function smtpSettings()
    {
        return view('backend.pages.systemSettings.smtp');
    }

    # update env values
    public function envKeyUpdate(Request $request)
    {
        foreach ($request->types as $key => $type) {
            writeToEnvFile($type, $request[$type]);
        }
        flash(localize("Settings updated successfully"))->success();
        return back();
    }

    # test email
    public function testEmail(Request $request)
    {
        $array['view'] = 'emails.bulkEmail';
        $array['subject'] = "SMTP Test";
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = "This is a test email.";
        try {
            Mail::to($request->email)->queue(new EmailManager($array));
        } catch (\Exception $e) {
            dd($e);
        }

        flash(localize('An email has been sent.'))->success();
        return back();
    }

    # update settings
    public function update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            // for currency rate
            if ($type == 'DEFAULT_CURRENCY') {
                $currency = Currency::where('code', $request[$type])->first();
                writeToEnvFile('DEFAULT_CURRENCY', $currency->code);
                writeToEnvFile('DEFAULT_CURRENCY_RATE', $currency->rate);
                writeToEnvFile('DEFAULT_CURRENCY_SYMBOL', $currency->symbol);
                writeToEnvFile('DEFAULT_CURRENCY_SYMBOL_ALIGNMENT', $currency->alignment);
            }

            # web maintenance mode
            if ($type == 'enable_maintenance_mode') {
                # maintenance
                if (env('DEMO_MODE') != 'On') {
                    if ($request[$type] == "1") {
                        Artisan::call('down');
                    } else {
                        Artisan::call('up');
                    }
                }
            }

            # timezone
            if ($type == 'timezone') {
                writeToEnvFile('APP_TIMEZONE', $request[$type]);
            } else if ($type == "GOOGLE_CLIENT_ID" || $type == "GOOGLE_CLIENT_SECRET" || $type == "FACEBOOK_APP_ID" || $type == "FACEBOOK_APP_SECRET" || $type == "RECAPTCHA_SITE_KEY" || $type == "RECAPTCHA_SECRET_KEY") {
                writeToEnvFile($type, $request[$type]);
            } else {
                $value = $request[$type];

                if ($type == 'system_title') {
                    writeToEnvFile('APP_NAME', $value);
                }

                $settings = SystemSetting::where('entity', $type)->first();
                if ($settings != null) {
                    if (gettype($value) == 'array') {
                        $settings->value = json_encode($value);
                    } else {
                        $settings->value = $value;
                    }
                } else {
                    $settings = new SystemSetting;
                    $settings->entity = $type;
                    if (gettype($value) == 'array') {
                        $settings->value = json_encode($value);
                    } else {
                        $settings->value = $value;
                    }
                }
                $settings->save();
            }
        }

        cacheClear();
        flash(localize("Settings updated successfully"))->success();
        return back();
    }

    # social login
    public function socialLogin()
    {
        return view('backend.pages.systemSettings.socialLogin');
    }

    # activation
    public function updateActivation(Request $request)
    {
        $setting = SystemSetting::where('entity', $request->entity)->first();
        if ($setting != null) {
            $setting->value = $request->value;
            $setting->save();
        } else {
            $setting = new SystemSetting;
            $setting->entity = $request->entity;
            $setting->value = $request->value;
            $setting->save();
        }
        cacheClear();
        return 1;
    }

    # admin payment Methods settings
    public function paymentMethods()
    {
        return view('backend.pages.systemSettings.paymentMethods');
    }

    # update payment methods
    public function updatePaymentMethods(Request $request)
    {
        foreach ($request->types as $type) {
            writeToEnvFile($type, $request[$type]);
        }

        foreach ($request->payment_methods as $payment_method) {
            if ($request->has(['enable_' . $payment_method])) {
                $activationSetting = SystemSetting::where('entity', 'enable_' . $payment_method)->first();
                $value = $request['enable_' . $payment_method];

                if ($activationSetting != null) {
                    $activationSetting->value = $value;
                    $activationSetting->save();
                } else {
                    $activationSetting = new SystemSetting;
                    $activationSetting->entity = 'enable_' . $payment_method;
                    $activationSetting->value = $value;
                    $activationSetting->save();
                }
            }

            if ($request->has($payment_method . '_sandbox')) {
                $setting = SystemSetting::where('entity', $payment_method . '_sandbox')->first();
                $value = $request[$payment_method . '_sandbox'];

                if ($setting != null) {
                    $setting->value = $value;
                    $setting->save();
                } else {
                    $setting = new SystemSetting;
                    $setting->entity = $payment_method . '_sandbox';
                    $setting->value = $value;
                    $setting->save();
                }
            }
        }

        cacheClear();
        flash(localize("Payment settings updated successfully"))->success();
        return back();
    }

    # auth  settings
    public function authSettings()
    {
        return view('backend.pages.systemSettings.authSettings');
    }

    # otp  settings
    public function otpSettings()
    {
        return view('backend.pages.systemSettings.otpSettings');
    }
}
