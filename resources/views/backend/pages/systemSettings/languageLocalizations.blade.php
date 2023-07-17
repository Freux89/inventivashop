@extends('backend.layouts.master')

@section('title')
    {{ localize('Localizations') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ $language->name }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">
                        <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">
                                    <div class="col-auto flex-grow-1">
                                        <div class="tt-search-box">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                        data-feather="search"></i></span>
                                                <input class="form-control rounded-start w-100" type="text"
                                                    id="search" name="search" placeholder="{{ localize('Search') }}"
                                                    @isset($searchKey)
                                        value="{{ $searchKey }}"
                                        @endisset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">
                                            <i data-feather="search" width="18"></i>
                                            {{ localize('Search') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form class="form-horizontal" action="{{ route('admin.languages.key_value_store') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $language->id }}">
                            <table class="table tt-footable table-hover border-top" data-use-parent-width="true"
                                id="localization-table">
                                <thead class="py-3">
                                    <tr>
                                        <th class="text-center py-3" width="5%">{{ localize('S/L') }}
                                        </th>
                                        <th width="40%" class="py-3">{{ localize('Lang Key') }}</th>
                                        <th data-breakpoints="xs sm" class="py-3">{{ localize('Localizations') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($localizations as $key => $localization)
                                        <tr>
                                            <td class="text-center align-middle">
                                                {{ $key + 1 + ($localizations->currentPage() - 1) * $localizations->perPage() }}
                                            </td>

                                            <td class="align-middle">
                                                <a class="d-flex align-items-center">
                                                    <h6 class="fs-sm mb-0 key">{{ $localization->t_value }}</h6>
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                <input type="text" class="form-control value w-100"
                                                    name="values[{{ $localization->t_key }}]"
                                                    placeholder="{{ localize('Type localization here') }}"
                                                    @if (($localization_lang = \App\Models\Localization::where('lang_key', $language->code)->where('t_key', $localization->t_key)->latest()->first()) != null) value="{{ $localization_lang->t_value }}" @endif>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <!--pagination start-->
                            <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                                <nav>
                                    {{ $localizations->appends(request()->input())->links() }}
                                </nav>
                                <div>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="copyLocalizations()">{{ localize('Copy Localizations') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ localize('Save') }}</button>
                                </div>
                            </div>
                            <!--pagination end-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        "use strict";

        //localize in one click
        function copyLocalizations() {
            $('#localization-table > tbody  > tr').each(function(index, tr) {
                $(tr).find('.value').val($(tr).find('.key').text());
            });
        }
    </script>
@endsection
