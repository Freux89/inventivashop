<!-- bundle -->
<script src="{{ staticAsset('backend/assets/js/vendors/jquery-3.6.4.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/swiper-bundle.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/toastr.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/simplebar.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/footable.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/select2.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/feather.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/summernote-lite.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/flatpickr.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/apexcharts.min.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/vendors/apex-scripts.js') }}"></script>
<script src="{{ staticAsset('backend/assets/js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js"></script>
<!-- HoverIntent -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.hoverintent/1.9.0/jquery.hoverIntent.min.js"></script>

<!-- localizations & others -->
<script>
    'use strict';

    var TT = TT || {};
    TT.localize = {
        no_data_found: '{{ localize('No data found') }}',
        selected_file: '{{ localize('Selected File') }}',
        selected_files: '{{ localize('Selected Files') }}',
        file_added: '{{ localize('File added') }}',
        files_added: '{{ localize('Files added') }}',
        no_file_chosen: '{{ localize('No file chosen') }}',
    };
    TT.baseUrl = '{{ \Request::root() }}';

    // on click delete confirmation -- outside footable
    function confirmDelete(thisLink) {
        var url = $(thisLink).data("href");
        $("#delete-modal").modal("show");
        $("#delete-link").attr("href", url);
    }

    // feather icon refresh
    function initFeather() {
        feather.replace();
    }
    initFeather();
</script>

<!-- media-manager scripts -->
@include('backend.inc.media-manager.uppyScripts')

<script>
    "use strict"
    $(function() {

        // footable js
        $(function() {
            $("table.tt-footable").footable({
                on: {
                    "ready.ft.table": function(e, ft) {
                        initTooltip();
                        deleteConfirmation();
                        setPoints();
                        approveRefundConfirmation();
                        rejectRefundConfirmation();
                    },
                },
            });
            deleteConfirmation();
        });

        // approve Refund Confirmation 
        function approveRefundConfirmation() {
            $(".confirm-approval").click(function(e) {
                e.preventDefault();
                var url = $(this).data("href");
                $("#approval-modal").modal("show");
                $("#approval-link").attr("href", url);
            });
        }

        // reject Refund Confirmation 
        function rejectRefundConfirmation() {
            $(".confirm-rejection").click(function(e) {
                e.preventDefault();
                var url = $(this).data("href");
                $("#rejection-modal").modal("show");
                $(".rejection-form").attr("action", url);
            });
        }


        // set points
        function setPoints() {
            $('.points-input').on("focusout", function(e) {
                var points = $(this).val();
                var product_id = $(this).data('product');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: "{{ route('admin.rewards.storeEachProductPoints') }}",
                    type: 'POST',
                    data: {
                        points: points,
                        product_id: product_id
                    },
                    success: function() {}
                });

            });
        }


        //    tooltip
        function initTooltip() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
        initTooltip();

        // delete confirmation
        function deleteConfirmation() {
            $(".confirm-delete").click(function(e) {
                console.log('confirm-delete clicked');
        e.preventDefault();
        var url = $(this).data("href");
        console.log('URL:', url);
        $("#delete-modal").modal("show");
        $("#delete-link").attr("href", url);
        console.log('href set on #delete-link');
            });
        }

        //    select2 js
        $(".select2").select2();
        $(".select2Max3").select2({
            maximumSelectionLength: 3
        });

        // modal select2
        function modalSelect2(parent = '.modalParentSelect2') {
            $('.modalSelect2').select2({
                dropdownParent: $(parent)
            });
        }
        modalSelect2();

        //    flatpickr 
        $(".date-picker").each(function(el) {
            var $this = $(this);
            var options = {
                dateFormat: 'm/d/Y'
            };

            var date = $this.data("date");
            if (date) {
                options.defaultDate = date;
            }

            $this.flatpickr(options);
        });



        $(".date-range-picker").each(function(el) {
            var $this = $(this);
            var options = {
                mode: "range",
                showMonths: 2,
                dateFormat: 'm/d/Y'
            };

            var start = $this.data("startdate");
            var end = $this.data("enddate");

            if (start && end) {
                options.defaultDate = [start, end];
            }

            $this.flatpickr(options);
        });

        @php
            $sections = \App\Models\Section::all(['id', 'name']);
        @endphp

        var sections = @json($sections);

    $(".editor").each(function(el) {
    var $this = $(this);
    var buttons = $this.data("buttons");
    var minHeight = $this.data("min-height");
    var placeholder = $this.attr("placeholder");
    var format = $this.data("format");

    buttons = !buttons ? [
        ["font", ["bold", "underline", "italic", "clear"]],
        ['fontname', ['fontname']],
        ["para", ["ul", "ol", "paragraph"]],
        ["style", ["style"]],
        ['fontsize', ['fontsize']],
        ["color", ["color"]],
        ["insert", ["link", "insertSection"]],
        ["view", ["undo", "redo"]],
        ['codeview', ['codeview']],
    ] : buttons;

    placeholder = !placeholder ? "" : placeholder;
    minHeight = !minHeight ? 150 : minHeight;
    format = typeof format == "undefined" ? false : format;

    $.extend($.summernote.options.icons, {
        insertSection: '<i class="note-icon-plus"/>'
    });

    var lastRange = null;

    $this.summernote({
        toolbar: buttons,
        placeholder: placeholder,
        height: minHeight,
        codeviewFilter: false,
        codeviewIframeFilter: true,
        disableDragAndDrop: true,
        buttons: {
    insertSection: function() {
        var ui = $.summernote.ui;
        var button = ui.buttonGroup([
            ui.button({
                className: 'dropdown-toggle',
                contents: '<i class="note-icon-plus"/> Sezioni <span class="caret"></span>',
                tooltip: 'Inserisci Sezione',
                data: {
                    toggle: 'dropdown'
                }
            }),
            ui.dropdown({
                className: 'custom-dropdown-style dropdown-style',
                contents: function() {
                    var dropdown = `
                        <div class="note-section-search">
                            <input type="text" class="form-control section-search-input" placeholder="Cerca sezione...">
                        </div>
                        <ul class="note-dropdown-menu list-unstyled section-list">`;
                    sections.forEach(function(section) {
                        dropdown += `<li><a href="#" class="note-section" data-id="${section.id}" data-name="${section.name}">${section.name}</a></li>`;
                    });
                    dropdown += '</ul>';
                    return dropdown;
                }
            })
        ]);
        return button.render();
    }
},
        callbacks: {
            onInit: function() {
                var editor = $this;

                // Prevenire la chiusura del dropdown quando si clicca sul campo di ricerca o all'interno del dropdown
                $(document).on('click', '.section-search-input, .section-list li', function(e) {
                    e.stopPropagation();
                });

                // Salva il range corrente (posizione del cursore) ogni volta che clicchi o interagisci con l'editor specifico
                editor.on('summernote.keyup summernote.mouseup summernote.change', function() {
                    lastRange = editor.summernote('createRange');
                });

                // Assicurati che l'evento di click sia associato solo all'editor corrente
                $this.parent().on('click', '.note-section', function(e) {
                    e.preventDefault();
                    var sectionId = $(this).data('id');
                    var sectionName = $(this).data('name');
                    var shortcode = `[section id="${sectionId}" name="${sectionName}"]`;

                    // Ripristina il range salvato e inserisce lo shortcode nella posizione del cursore
                    if (lastRange) {
                        lastRange.select();
                        editor.summernote('editor.pasteHTML', shortcode);
                    } else {
                        // Se per qualche motivo il range non è stato salvato, inserisce alla fine del contenuto
                        editor.summernote('editor.pasteHTML', shortcode);
                    }
                });

                // Ascolta l'input nel campo di ricerca per filtrare le sezioni
                $(document).on('input', '.section-search-input', function() {
                    var searchText = $(this).val().toLowerCase();

                    // Filtra le sezioni in base al testo inserito
                    $('.section-list li').each(function() {
                        var sectionName = $(this).text().toLowerCase();
                        if (sectionName.includes(searchText)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            }
        }
    });

    var nativeHtmlBuilderFunc = $this.summernote("module", "videoDialog").createVideoNode;
    $this.summernote("module", "videoDialog").createVideoNode = function(url) {
        var wrap = $('<div class="embed-responsive embed-responsive-16by9"></div>');
        var html = nativeHtmlBuilderFunc(url);
        html = $(html).addClass("embed-responsive-item");
        return wrap.append(html)[0];
    };
});




















        // add more
        $('[data-toggle="add-more"]').each(function() {
            var $this = $(this);
            var content = $this.data("content");
            var target = $this.data("target");

            $this.on("click", function(e) {
                e.preventDefault();
                $(target).append(content);
                $('.select2').select2();
            });
        });

        // remove parent
        $(document).on(
            "click",
            '[data-toggle="remove-parent"]',
            function() {
                var $this = $(this);
                var parent = $this.data("parent");
                $this.closest(parent).remove();
            }
        );

        // language flag select2
        $(".country-flag-select").select2({
            templateResult: countryCodeFlag,
            templateSelection: countryCodeFlag,
            escapeMarkup: function(m) {
                return m;
            },
        });

        function countryCodeFlag(state) {
            var flagName = $(state.element).data("flag");
            if (!flagName) return state.text;
            return (
                "<div class='d-flex align-items-center'><img class='flag me-2' src='" + flagName +
                "' height='14' />" + state.text + "</div>"
            );
        }
    })
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const colorPickers = document.querySelectorAll('.color-picker-button');

        colorPickers.forEach(pickerElement => {
            const id = pickerElement.getAttribute('data-id');
            const inputElement = document.getElementById(id);

            const pickr = Pickr.create({
                el: pickerElement,
                theme: 'classic', // classic, monolith, nano
                default: inputElement.value,
                swatches: [
                    '#C9AC20', '#4E838E', '#289BB1', '#801854',
                    '#D4F3F9', '#EAEAEA', '#DADADA', '#FFF2CE',
                    '#98C0C6', '#9BA3A4', '#DAD0A6', '#9A7785', '#e7eeef',
                    '#580830', '#a18110', '#105862', '#007480',
                    '#404647', '#f4f8f8', '#ffffff', '#000000'
                ],
                components: {
                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        input: true,
                        save: true
                    }
                }
            });

            // Aggiorna il colore al cambiamento
            pickr.on('change', (color, source, instance) => {
                inputElement.value = color.toHEXA().toString();
                pickerElement.style.backgroundColor = color.toHEXA().toString();
            });

            // Chiudi la finestra di selezione del colore dopo aver cliccato su "Save"
            pickr.on('save', (color, instance) => {
                instance.hide(); // Chiude la finestra
            });
        });
    });
</script>
