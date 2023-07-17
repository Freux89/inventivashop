@extends('backend.layouts.master')

@section('title')
    {{ localize('Add Stock') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Add Stock') }}</h2>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">

                <!--left sidebar-->
                <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.stocks.store') }}" method="POST" class="pb-650">
                        @csrf
                        <!--basic information start-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-3">{{ localize('Basic Information') }}</h5>

                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ localize('Location') }}</label>
                                    <select class="select2 form-control" name="location_id" required>
                                        <option value="">{{ localize('Select location') }}</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">
                                                {{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ localize('Select Product') }}</label>
                                    <select class="select2 form-control" name="product_id" required disabled>
                                        <option value="">{{ localize('Select product') }}</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->collectLocalization('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="add-stock-input">
                                    <!--dom will be appended via ajax-->

                                </div>
                            </div>
                        </div>
                        <!--basic information end-->

                        <!-- submit button -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i data-feather="save" class="me-1"></i> {{ localize('Save Stock') }}
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
                            <h5 class="mb-3">{{ localize('Stock Information') }}</h5>
                            <div class="tt-vertical-step">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#section-1" class="active">{{ localize('Stock Information') }}</a>
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
    <script>
        "use strict";

        $(document).on('change', '[name=location_id]', function() {
            var location_id = $(this).val();
            $('.add-stock-input').empty();
            if (location_id != '') {
                $('[name=product_id]').prop('disabled', false);
                $('[name=product_id]').val('');
                $('.select2').select2();
            } else {
                $('[name=product_id]').prop('disabled', true);
                $('[name=product_id]').val('');
                $('.select2').select2();
            }
        });

        // get getVariationStocks 
        $(document).on('change', '[name=product_id]', function() {
            $('.add-stock-input').empty();
            var product_id = $(this).val();
            var location_id = $('[name=location_id]').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "POST",
                data: {
                    product_id: product_id,
                    location_id: location_id,
                },
                url: '{{ route('admin.stocks.getVariationStocks') }}',
                success: function(data) {
                    $('.add-stock-input').append(data.variation_stocks)
                }
            });
        });
    </script>
@endsection
