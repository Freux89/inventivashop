$(".at-pricing-range").each(function () {
    var priceInput = $(this).find(".price-input");

    var min_price = $(this).find(".min_price");
    var max_price = $(this).find(".max_price");

    priceInput.on("change", function () {
        var min_price = $(this).parents(".at-pricing-range").find(".min_price");
        var max_price = $(this).parents(".at-pricing-range").find(".max_price");

        var min_price_range = parseInt(min_price.val());

        var max_price_range = parseInt(max_price.val());

        if (min_price_range > max_price_range) {
            max_price.val(min_price_range);
        }

        var price_filter_range = $(this)
            .parents(".at-pricing-range")
            .find(".price-filter-range");

        price_filter_range.slider({
            values: [min_price_range, max_price_range],
        });
    });

    priceInput.on("paste keyup", function () {
        var min_price = $(this).parents(".at-pricing-range").find(".min_price");
        var max_price = $(this).parents(".at-pricing-range").find(".max_price");

        var min_price_range = parseInt(min_price.val());

        var max_price_range = parseInt(max_price.val());

        var price_filter_range = $(this)
            .parents(".at-pricing-range")
            .find(".price-filter-range");

        price_filter_range.slider({
            values: [min_price_range, max_price_range],
        });
    });

    var price_filter_range = $(this).find(".price-filter-range");

    var minRange = $(".price-input-min").data("min-range");
    var maxRange = $(".price-input-max").data("max-range");

    price_filter_range.slider({
        range: true,
        orientation: "horizontal",
        min: minRange,
        max: maxRange,
        values: [minRange, maxRange],
        step: 1,
        slide: function (event, ui) {
            if (ui.values[0] == ui.values[1]) {
                return false;
            }

            min_price.val(ui.values[0]);
            max_price.val(ui.values[1]);
        },
    });

    var min = parseInt($(".price-input-min").data("value"));
    var max = parseInt($(".price-input-max").data("value"));

    min_price.val(min);
    max_price.val(max);

    var price_filter_range2 = price_filter_range
        .parents(".at-pricing-range")
        .find(".price-filter-range");

    price_filter_range2.slider({
        values: [min, max],
    });
});
