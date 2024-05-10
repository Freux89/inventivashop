@extends('backend.layouts.master')

@section('title')
{{ localize('Crea') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">{{ localize('Crea') }}</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            
            <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.items.store',['sectionId' => $section->id]) }}" method="POST" class="pb-650" id="material-form">
                    @csrf
                    <input type="hidden" name="type" value="{{$type}}">
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            @if($section->type == 'columns')
                                @include('backend.pages.sections.items.partials.columns')
                            @elseif($section->type == 'carousel')    
                                @include('backend.pages.sections.items.partials.carousel')
                            @elseif($section->type == 'filtergrid')        
                                @include('backend.pages.sections.items.partials.filtergrid')
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> {{ localize('Salva') }}
                                </button>
                            </div>
                        </div>
                    </div>
           

                </form>
            </div>

   

        </div>
    </div>
</section>

@endsection

