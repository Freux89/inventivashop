@extends('backend.layouts.master')

@section('title')
    {{ localize('Update Campaign') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Update Campaign') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.campaigns.update') }}" method="POST" class="pb-650">
                        @csrf
                        <input type="hidden" name="id" value="{{ $campaign->id }}">
                        <!--basic information start-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <div class="">
                                            <label for="title" class="form-label">{{ localize('Title') }}</label>
                                            <input class="form-control" type="text" id="title"
                                                placeholder="{{ localize('Type campaign title') }}" name="title" required
                                                value="{{ $campaign->title }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">

                                        @php
                                            $start_date = date('m/d/Y', $campaign->start_date);
                                            $end_date = date('m/d/Y', $campaign->end_date);
                                        @endphp

                                        <div class="">
                                            <label class="form-label">{{ localize('Date Range') }}</label>
                                            <div class="input-group">
                                                <input class="form-control date-range-picker date-range" type="text"
                                                    placeholder="{{ localize('Start date - End date') }}" name="date_range"
                                                    data-startdate="'{{ $start_date }}'"
                                                    data-enddate="'{{ $end_date }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">{{ localize('Banner') }}</label>
                                    <div class="tt-image-drop rounded">
                                        <span class="fw-semibold">{{ localize('Choose Campaign Banner') }}</span>
                                        <!-- choose media -->
                                        <div class="tt-product-thumb show-selected-files mt-3">
                                            <div class="avatar avatar-xl cursor-pointer choose-media"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                                onclick="showMediaManager(this)" data-selection="single">
                                                <input type="hidden" name="banner" value="{{ $campaign->banner }}">
                                                <div class="no-avatar rounded-circle">
                                                    <span><i data-feather="plus"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- choose media -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--basic information end-->


                        <!-- products -->
                        <div class="card mb-4" id="section-2">
                            <div class="card-body">
                                <h5 class="">{{ localize('Products') }}</h5>
                                <div class="mb-4">
                                    <select class="form-control select2" class="w-100" data-toggle="select2"
                                        data-placeholder="{{ localize('Select Products') }}" name="product_ids[]" multiple
                                        id="campaign_products">
                                        @foreach ($products as $product)
                                            @php
                                                $campaign_product = \App\Models\CampaignProduct::where('campaign_id', $campaign->id)
                                                    ->where('product_id', $product->id)
                                                    ->first();
                                            @endphp
                                            <option value="{{ $product->id }}" <?php if ($campaign_product != null) {
                                                echo 'selected';
                                            } ?>>
                                                {{ $product->collectLocalization('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="">
                                    <div class="d-none">
                                        <h3 class="badge badge-info-lighten font-14">
                                            {{ localize('If any product exists in another campaign or has discount, that will be replaced by this date & discount configuration.') }}
                                        </h3>
                                    </div>

                                    <div id="campaign_product_discount">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- products -->

                        <!-- submit button -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Changes') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- submit button end -->
                    </form>
                </div>

                <!--right sidebar-->
                <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                    <div class="card tt-sticky-sidebar d-none d-xl-block">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Campaign Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
                                    </li>
                                    <li>
                                        <a href="#section-2">{{ localize('Products') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            //for media files
            getChosenFilesCount();
            showSelectedFilePreviewOnLoad();

            getOfferDiscount();

            $('#campaign_products').on('change', function() {
                getOfferDiscount();
            });

            function getOfferDiscount() {
                var product_ids = $('#campaign_products').val();
                if (product_ids.length > 0) {
                    $.post('{{ route('admin.campaigns.productDiscountEdit') }}', {
                        _token: '{{ csrf_token() }}',
                        product_ids: product_ids,
                        campaign_id: {{ $campaign->id }}
                    }, function(data) {
                        $('#campaign_product_discount').html(data);
                        $('.tt-footable').footable({
                            on: {
                                "ready.ft.table": function(e, ft) {
                                    $('.select2').select2();
                                },
                            },
                        });
                    });
                } else {
                    $('#campaign_product_discount').html(null);
                }
            }
        });
    </script>
@endsection
