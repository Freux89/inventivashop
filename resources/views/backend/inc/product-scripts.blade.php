<script>
    "use strict";

    // runs when the document is ready --> for media files
    $(document).ready(function() {
        getChosenFilesCount();
        showSelectedFilePreviewOnLoad();
    });

    // swith markup based on selection
    function isVariantProduct(el) {
        $(".hasVariation").hide();
       

        if ($(el).is(':checked')) {
            $(".hasVariation").show();
        } 
    }

    // add another variation
    function addAnotherVariation() {
        let formId = $('#product-form').length ? 'product-form' : 'template-variation-form';
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: $('#' + formId).serialize(),
            url: '{{ route('product.newVariation') }}',
            success: function(data) {
                if (data.count > 0) {
                    $('.chosen_variation_options').find('.variation-names').find('.select2').siblings(
                        '.dropdown-toggle').addClass("disabled");
                    $('.chosen_variation_options').append(data.view);
                    $('.select2').select2();
                    initFeather();
                }
            }
        });
    }

    // get values for selected variations
    function getVariationValues(e) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: "POST",
            data: {
                variation_id: $(e).val()
            },
            url: '{{ route('product.getVariationValues') }}',
            success: function(data) {
                $(e).closest('.row').find('.variationvalues').html(data);
                $('.select2').select2();
                initFeather();
            }
        });
    }

    // variation combinations
    function generateVariationCombinations() {
        let formId = $('#product-form').length ? 'product-form' : 'template-variation-form';

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{ route('product.generateVariationCombinations') }}',
            data: $('#' + formId).serialize(),
            success: function(data) {
                $('#variation_combination').html(data);

                $('.table').footable();
                initFeather();
                setTimeout(() => {
                    $('.select2').select2();
                }, 300);
            }
        });
    }
</script>
