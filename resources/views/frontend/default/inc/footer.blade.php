<footer class="gshop-footer position-relative pt-8 bg-dark z-1 overflow-hidden">
    
    <div class="content-wrapper">
    {{--
        <div class="row justify-content-center ">
            <div class="col-xl-5 col-lg-6">
                 <div class="gshop_subscribe_form text-center">
                    <h4 class="text-white gshop-title">{{ localize('Subscribe to our newsletter') }}</h4>
                    <form class="mt-5 d-flex align-items-center bg-white rounded subscribe_form"
                        action="{{ route('subscribe.store') }}" method="POST">
                        @csrf
                        <input type="email" class="form-control" placeholder="{{ localize('Enter Email Address') }}"
                            type="email" name="email" required>
                        <button type="submit"
                            class="btn btn-primary flex-shrink-0">{{ localize('Subscribe Now') }}</button>
                    </form>
                </div>
            </div>
        </div>
        --}}
        <div class="row g-5 pt-6 text-center text-sm-start">
            <div class="col-md-2 col-sm-12">
            <svg width="110" id="ebec4a24-4876-4412-aaa2-cd44e733869d" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 491.93 485.65"><title>icon-white</title><path d="M472.39,225.64,277.5,30.75c-12.57-12.57-37.72-23.57-55-23.57H37c-18.86,0-33,14.14-33,33V459.82c0,17.29,14.15,33,33,33H99.91V103.05h99V459.82c0,17.29,14.15,33,33,33H463L228.78,258.64V114.05l177.6,179.17,66,66C485,371.8,496,367.09,496,349.8V282.22C494.39,263.36,485,238.21,472.39,225.64Z" transform="translate(-4.03 -7.18)" style="fill:#fff"/></svg>
            </div>
            {{--
                <div class="col-md-4 col-sm-6">
                <div class="footer-widget">
                    <div class="text-white mb-4">{{ localize('Utili') }}</div>
                    @php
                        $quick_links = getSetting('quick_links') != null ? json_decode(getSetting('quick_links')) : [];
                        $pages = \App\Models\Page::whereIn('id', $quick_links)->get();
                    @endphp
                    <ul class="footer-nav">
                        @foreach ($pages as $page)
                            <li><a
                                    href="{{ route('home.pages.show', $page->slug) }}">{{ $page->collectLocalization('title') }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
                --}}
                <div class="col-md-2 col-sm-12">
                <div class="footer-widget">
                    <div class="title text-white mb-4">{{ localize('Utili') }}</div>
                    <ul class="footer-nav">
                        <li><a href="#">{{ localize('FAQ') }}</a></li>
                        <li><a href="#">{{ localize('Installazioni') }}</a></li>
                        <li><a href="#">{{ localize('Blog') }}</a></li>
                        <li><a href="#">{{ localize('Nuovi prodotti') }}</a></li>
                        <li><a href="#">{{ localize('Più popolare') }}</a></li>
                        <li><a href="#">{{ localize('Tendenze') }}</a></li>
                        <li><a href="#">{{ localize('Mappa del sito') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <div class="footer-widget">
                    <div class="title text-white mb-4">{{ localize('Informazioni') }}</div>
                    <ul class="footer-nav">
                    <li><a href="#">{{ localize('Contatti') }}</a></li>
                        <li><a href="#">{{ localize('Assistenza') }}</a></li>
                        <li><a href="#">{{ localize('Lavora con noi') }}</a></li>
                        <li><a href="#">{{ localize('Diventa rivenditore') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="footer-widget">
                    <div class="title text-white mb-4">{{ localize('Legale') }}</div>
                    <ul class="footer-nav">
                    <li><a href="#">{{ localize('Termine e condizioni') }}</a></li>
                        <li><a href="#">{{ localize('Accordo di licenza') }}</a></li>
                        <li><a href="#">{{ localize('Informativa sulla privacy') }}</a></li>
                        <li><a href="#">{{ localize('Informazione sul Copyright') }}</a></li>
                        <li><a href="#">{{ localize('Politica dei cookie') }}</a></li>
                        <li><a href="#">{{ localize('Gestisci le preferenze') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-12">
                <div class="footer-widget">
                    <div class="title text-white mb-3">{{ localize('Social') }}</div>
                    <ul class="footer-nav d-flex flex-row justify-content-center justify-content-sm-start">
                        
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="facebook">
                                <svg width="30" id="e0a73bfb-774d-4331-849a-157928f1793f" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 79.79"><title>facebook</title><path d="M40,.11a40,40,0,0,0-6.57,79.47V51.28H23.3V40.72H33.58c0-1.12,0-2,0-2.86.09-3.34,0-6.7.33-10A12.52,12.52,0,0,1,44.56,16a56.59,56.59,0,0,1,11,.33,1.53,1.53,0,0,1,1,1.09c.09,3.17,0,6.35,0,9.78-2.83,0-5.41-.08-8,0s-4.21,1.27-4.37,3.59c-.24,3.22-.06,6.47-.06,10h12c-.5,3-1.05,5.81-1.37,8.6-.18,1.52-.76,2-2.25,1.93-2.79-.11-5.58,0-8.4,0V79.89A40,40,0,0,0,40,.11" transform="translate(0 -0.11)" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="instagram">
                                <svg width="30" id="a7f83115-9e4a-4800-98a7-8b9c2c4661db" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>instagram</title><path d="M40,30.67A9.33,9.33,0,1,0,49.32,40,9.33,9.33,0,0,0,40,30.67" transform="translate(0 0)" style="fill:#fff"/><path d="M50.35,19.48H29.65A10.19,10.19,0,0,0,19.48,29.65v20.7A10.18,10.18,0,0,0,29.65,60.52h20.7A10.19,10.19,0,0,0,60.52,50.35V29.65A10.19,10.19,0,0,0,50.35,19.48M40,52.46A12.46,12.46,0,1,1,52.46,40,12.46,12.46,0,0,1,40,52.46M53.32,29.63a2.94,2.94,0,1,1,2.93-2.93,2.94,2.94,0,0,1-2.93,2.93" transform="translate(0 0)" style="fill:#fff"/><path d="M40,0A40,40,0,1,0,80,40,40,40,0,0,0,40,0M63.67,50.35A13.34,13.34,0,0,1,50.36,63.66H29.67A13.33,13.33,0,0,1,16.36,50.35V29.65a13.32,13.32,0,0,1,13.31-13.3H50.36a13.32,13.32,0,0,1,13.31,13.3Z" transform="translate(0 0)" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="pintrest">
                                <svg width="30" id="a6980dad-f826-4fa0-8534-57c902587ff7" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80.01"><title>pintrest</title><path d="M40,0A40,40,0,0,0,25.52,77.3c1.52-8.37,3.26-17.64,4.61-26,.51-3.12.16-6.39.64-9.53a26.25,26.25,0,0,1,2.52-9,5.89,5.89,0,0,1,5.54-1.56,6.09,6.09,0,0,1,3,4.95c-.27,3.71-2,7.31-2.33,11-.23,2.19.24,5.63,1.65,6.53a8.75,8.75,0,0,0,7.35.18c6-3,9.17-15.74,6.23-23-2.46-6-9.79-9.28-17.34-7.64a16.59,16.59,0,0,0-13.65,17A53.09,53.09,0,0,0,25.31,46c.38,2,.42,4.11.67,6.72a10,10,0,0,1-8.61-9.1,27.56,27.56,0,0,1,.76-11.14c2.73-9.1,11.44-14.87,22-15.35,10.27-.47,18.64,4,22.35,12.06A26.48,26.48,0,0,1,57.78,56c-5.82,6.13-13.07,6.9-20.54,2.43-2.47,5.69-4.92,11.44-7.48,17.14a12.79,12.79,0,0,1-2.1,2.54l.43.14a40.79,40.79,0,0,0,5.35,1.27A40,40,0,1,0,40,0" transform="translate(0 0.01)" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="X">
                                <svg width="30" id="bbc428f6-3224-46ac-910a-616ec5840d96" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 79.98 80"><title>x</title><polygon points="40.66 37.08 30.28 22.03 24.88 22.03 37.62 40.66 39.26 43.06 49.46 57.98 55.08 57.98 42.32 39.45 40.66 37.08" style="fill:#fff"/><path d="M40,0A40,40,0,1,0,79.76,35.73,40,40,0,0,0,40,0m8.1,60.58L37.53,45.11,24.38,60.58H20.67L35.9,42.7,20,19.42h11.7L42.44,35l13.29-15.6h3.65l-15.3,18,16,23.18Z" transform="translate(-0.01)" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="youtube">
                                <svg width="30" id="b8ee6e9a-cea2-4e73-8479-6e21977087db" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>youtube</title><path d="M40,0a40,40,0,0,0,0,80h0A40,40,0,0,0,40,0M64,51a6.64,6.64,0,0,1-6.64,6.64H24a8,8,0,0,1-8-8V30.28a8,8,0,0,1,8-8H56a8,8,0,0,1,8,8Z" transform="translate(0 0)" style="fill:#fff"/><path d="M44.64,39.12l-9.22-5.33a1,1,0,0,0-1.4.37,1.06,1.06,0,0,0-.13.52V45.33a1,1,0,0,0,1.53.88l9.22-5.33A1,1,0,0,0,45,39.49a1,1,0,0,0-.38-.37" transform="translate(0 0)" style="fill:#fff"/></svg>
                            </a>
                        </li>
                    </ul>
                    <div class="title text-white mb-3 mt-4">{{ localize('Scrivici su') }}</div>
                    <ul class="footer-nav d-flex flex-row justify-content-center justify-content-sm-start">
                        
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="Whatsapp">
                                <svg width="30" id="a8bbae7c-0374-4a37-9441-e5c2cbbdf31a" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80.01"><title>whatsapp</title><path d="M33.43,79.45A40,40,0,1,0,0,40,40,40,0,0,0,33.43,79.45M17.18,26.6a25.08,25.08,0,0,1,24-12.91A27.12,27.12,0,0,1,67.87,38.34a24.33,24.33,0,0,1-7.21,18.75,25.91,25.91,0,0,1-18.27,7.46c-.61,0-1.22,0-1.84-.07a35.09,35.09,0,0,1-7.71-1.71c-1.19-.36-2.41-.73-3.59-1a4.7,4.7,0,0,0-1.74-.21c-1.87.43-3.76,1-5.76,1.53l-2.55.7-2.42.67L17.37,62c.19-.81.39-1.58.57-2.33.45-1.8.88-3.5,1.19-5.17a2,2,0,0,0-.22-1.24c-6.1-8.9-6.69-17.88-1.73-26.65" transform="translate(0 0)" style="fill:#fff"/><path d="M22.05,55c-.32,1.7-.74,3.4-1.19,5.18l.09,0c2-.57,3.94-1.11,5.88-1.56a4.58,4.58,0,0,1,1-.11,9.72,9.72,0,0,1,2.15.33c1.27.31,2.53.69,3.75,1a32.23,32.23,0,0,0,7.06,1.59A23,23,0,0,0,58.57,55a21.41,21.41,0,0,0,6.34-16.46A24.14,24.14,0,0,0,41.06,16.64c-9.72-.26-16.88,3.58-21.3,11.41S16,43.67,21.36,51.56A4.92,4.92,0,0,1,22,55m4.77-24a5.86,5.86,0,0,1,3.85-5.31,6.12,6.12,0,0,1,.93-.35,2.09,2.09,0,0,1,2.28.41,8.16,8.16,0,0,1,2.74,4.14A5.57,5.57,0,0,1,37,32.27a1.15,1.15,0,0,1-.53,1l-1.52,1.17a3.87,3.87,0,0,1-.52.47A1.37,1.37,0,0,0,34,36.71,19.8,19.8,0,0,0,35.44,39a27.8,27.8,0,0,0,6.35,6.18,12.89,12.89,0,0,0,1.81.93.82.82,0,0,0,.93-.29c.82-.87,1.58-1.75,2.34-2.63a1.53,1.53,0,0,1,1.86-.52A17.31,17.31,0,0,1,54,45.28c1,.75,1.11,1,.88,2.27a6.79,6.79,0,0,1-5.08,5.13,13.24,13.24,0,0,1-2.27.35,14.34,14.34,0,0,1-4.73-1.16A26.32,26.32,0,0,1,27.62,36.18,12.94,12.94,0,0,1,26.81,31" transform="translate(0 0)" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="Messenger">
                                <svg width="30" id="f9ccb996-b86d-4adf-9b34-3824d5bbf0b2" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>messenger</title><path d="M33.45,79.46A40,40,0,1,0,0,40,40.38,40.38,0,0,0,33.45,79.46M14.7,31.61A24.3,24.3,0,0,1,34.42,14,26.37,26.37,0,0,1,65.34,31.17,24.36,24.36,0,0,1,48.61,61.28,25.35,25.35,0,0,1,45.5,62a70.56,70.56,0,0,1-11.72,0,5.68,5.68,0,0,0-2.48.37c-2.51,1.26-4.94,2.68-7.82,4.27,0-3,.08-5.5-.05-8a3.51,3.51,0,0,0-1-2.24C15,49.58,11.93,41.31,14.7,31.6" transform="translate(0 0)" style="fill:#fff"/><polyline points="35.95 40.39 42.82 47.35 55.85 33.52 55.54 33.16 44.03 39.49 37.12 32.59 24.21 46.3 24.47 46.67 35.94 40.39" style="fill:#fff"/></svg>
                            </a>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright pt-120 pb-3">
        <span class="gradient-spacer d-block mb-3"></span>
        <div class="content-wrapper">
            <div class="row align-items-center g-3">
                <div class="col-12">
                    <div class="copyright-text text-light">
                        {!! getSetting('copyright_text') !!}
                    </div>
                </div>
              
            
            </div>
        </div>
    </div>
</footer>
