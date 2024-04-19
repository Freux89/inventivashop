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
                                <svg width="30" id="a98b8e6b-2cd5-4785-9817-dfa30666f423" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>Senza titolo-2</title><circle cx="40" cy="40" r="40" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="instagram">
                                <svg width="30" id="a98b8e6b-2cd5-4785-9817-dfa30666f423" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>Senza titolo-2</title><circle cx="40" cy="40" r="40" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="pintrest">
                                <svg width="30" id="a98b8e6b-2cd5-4785-9817-dfa30666f423" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>Senza titolo-2</title><circle cx="40" cy="40" r="40" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="X">
                                <svg width="30" id="a98b8e6b-2cd5-4785-9817-dfa30666f423" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>Senza titolo-2</title><circle cx="40" cy="40" r="40" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="youtube">
                                <svg width="30" id="a98b8e6b-2cd5-4785-9817-dfa30666f423" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>Senza titolo-2</title><circle cx="40" cy="40" r="40" style="fill:#fff"/></svg>
                            </a>
                        </li>
                    </ul>
                    <div class="title text-white mb-3 mt-4">{{ localize('Scrivici su') }}</div>
                    <ul class="footer-nav d-flex flex-row justify-content-center justify-content-sm-start">
                        
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="Whatsapp">
                                <svg width="30" id="a98b8e6b-2cd5-4785-9817-dfa30666f423" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>Senza titolo-2</title><circle cx="40" cy="40" r="40" style="fill:#fff"/></svg>
                            </a>
                        </li>
                        <li class="text-white pb-2 fs-xs me-3">
                            <a href="#" title="Messenger">
                                <svg width="30" id="a98b8e6b-2cd5-4785-9817-dfa30666f423" data-name="Livello 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><title>Senza titolo-2</title><circle cx="40" cy="40" r="40" style="fill:#fff"/></svg>
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
