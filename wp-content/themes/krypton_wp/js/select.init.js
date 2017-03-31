(function() {
  "use strict";
  
  var init, setupWidgetCategoriesSelect, setupWidgetArchiveSelect, setupBottomWidgetCategoriesSelect, setupBottomWidgetArchiveSelect;

  init = function() {
    var i = 0;
    $('.sidebar .widget_categories select').each(function(index) {
      new Select({
        el: $('.sidebar .widget_categories select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.shop-bottom .widget_categories select').each(function(index) {
      new Select({
        el: $('.shop-bottom .widget_categories select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.sidebar .widget_archive select').each(function(index) {
      new Select({
        el: $('.sidebar .widget_archive select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.bottom_section .widget_categories select').each(function(index) {
      new Select({
        el: $('.bottom_section .widget_categories select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.bottom_section .widget_archive select').each(function(index) {
      new Select({
        el: $('.bottom_section .widget_archive select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.woocommerce .woocommerce-ordering select').each(function(index) {
      new Select({
        el: $('.woocommerce .woocommerce-ordering select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.woocommerce .shipping-calculator-form select[name="calc_shipping_country"]').each(function(index) {
      new Select({
        el: $('.woocommerce .shipping-calculator-form select[name="calc_shipping_country"]')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.woocommerce .shipping-calculator-form select[name="calc_shipping_state"]').each(function(index) {
      new Select({
        el: $('.woocommerce .shipping-calculator-form select[name="calc_shipping_state"]')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.sidebar .widget_product_categories select').each(function(index) {
      new Select({
        el: $('.sidebar .widget_product_categories select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.shop-bottom .widget_product_categories select').each(function(index) {
      new Select({
        el: $('.shop-bottom .widget_product_categories select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.woocommerce .shop-bottom .widget_layered_nav select#dropdown_layered_nav_ukuran').each(function(index) {
      new Select({
        el: $('.woocommerce .shop-bottom .widget_layered_nav select#dropdown_layered_nav_ukuran')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.woocommerce .sidebar .widget_layered_nav select#dropdown_layered_nav_ukuran').each(function(index) {
      new Select({
        el: $('.woocommerce .sidebar .widget_layered_nav select#dropdown_layered_nav_ukuran')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.woocommerce .bottom_section .widget_layered_nav select#dropdown_layered_nav_ukuran').each(function(index) {
      new Select({
        el: $('.woocommerce .bottom_section .widget_layered_nav select#dropdown_layered_nav_ukuran')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.shop-bottom .widget_archive select').each(function(index) {
      new Select({
        el: $('.shop-bottom .widget_archive select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

    var i = 0;
    $('.woocommerce .variations select').each(function(index) {
      new Select({
        el: $('.woocommerce .variations select')[i],
        alignToHighlighted: 'always'
      });
      i++;
    });

  };

  setupWidgetCategoriesSelect = function() {
    return new Select({
      el: $('.sidebar .widget_categories select')[0],
      alignToHighlighted: 'always'
    });
  };

  setupWidgetArchiveSelect = function() {
    return new Select({
      el: $('.sidebar .widget_archive select')[0],
      alignToHighlighted: 'always'
    });
  };

  setupBottomWidgetCategoriesSelect = function() {
    return new Select({
      el: $('.bottom_section .widget_categories select')[0],
      alignToHighlighted: 'always'
    });
  };

  setupBottomWidgetArchiveSelect = function() {
    return new Select({
      el: $('.bottom_section .widget_archive select')[0],
      alignToHighlighted: 'always'
    });
  };

  $(init);

}).call(this);
