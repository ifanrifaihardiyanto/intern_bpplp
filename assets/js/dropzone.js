$(function () {
  'use strict';

  Dropzone.autoDiscover = false;

  $("exampleDropzone").dropzone({
    uploadMultiple: true,
    autoProcessQueue: false,
  });
});