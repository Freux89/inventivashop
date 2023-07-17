<!-- 3rd party -->
<link rel="stylesheet" href="{{ staticAsset('frontend/common/css/toastr.css') }}">
<!-- 3rd party -->
@if ($localLang->is_rtl == 1)
    <link rel="stylesheet" href="{{ staticAsset('frontend/default/assets/css/main-rtl.css') }}">
@else
    <link rel="stylesheet" href="{{ staticAsset('frontend/default/assets/css/main.css') }}">
@endif

<link rel="stylesheet" href="{{ staticAsset('frontend/common/css/select2.css') }}">
<link rel="stylesheet" href="{{ staticAsset('frontend/common/css/custom.css') }}">
