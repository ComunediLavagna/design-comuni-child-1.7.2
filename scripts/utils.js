/* STS 2024 */

function mySwapTag(originTag, destTag) {
  while($(originTag).length) {
    $(originTag).replaceWith (function () {
      var attributes = $(this).prop("attributes");
      var $newEl = $(`<${destTag}>`)
      $.each(attributes, function() {
        $newEl.attr(this.name, this.value);
      });  
      return $newEl.html($(this).html())
    })
  }
}

