$(function () {
  'use strict'

  if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2({
      tags: true
    });
  }
  if ($(".js-example-basic-single-search").length) {
    $(".js-example-basic-single-search").select2();
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2();
  }
});