(function () {
    tinymce.PluginManager.add('accordion_bi', function (editor) {
        editor.addButton('accordion_bi', {
            text: 'Accordion',
            tooltip: 'Inserisci accordion Bootstrap Italia',
            icon: false,
            onclick: function () {
                var id = 'acc-' + Math.random().toString(36).substr(2, 6);
                var html =
                    '<div class="accordion" id="' + id + '">\n' +
                    '  <div class="accordion-item">\n' +
                    '    <h3 class="accordion-header" id="h-' + id + '-1">\n' +
                    '      <button class="accordion-button" type="button"' +
                    ' data-bs-toggle="collapse" data-bs-target="#c-' + id + '-1"' +
                    ' aria-expanded="true" aria-controls="c-' + id + '-1">' +
                    'Titolo voce 1' +
                    '</button>\n' +
                    '    </h3>\n' +
                    '    <div id="c-' + id + '-1" class="accordion-collapse collapse show"' +
                    ' aria-labelledby="h-' + id + '-1">\n' +
                    '      <div class="accordion-body">Contenuto voce 1</div>\n' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '  <div class="accordion-item">\n' +
                    '    <h3 class="accordion-header" id="h-' + id + '-2">\n' +
                    '      <button class="accordion-button collapsed" type="button"' +
                    ' data-bs-toggle="collapse" data-bs-target="#c-' + id + '-2"' +
                    ' aria-expanded="false" aria-controls="c-' + id + '-2">' +
                    'Titolo voce 2' +
                    '</button>\n' +
                    '    </h3>\n' +
                    '    <div id="c-' + id + '-2" class="accordion-collapse collapse"' +
                    ' aria-labelledby="h-' + id + '-2">\n' +
                    '      <div class="accordion-body">Contenuto voce 2</div>\n' +
                    '    </div>\n' +
                    '  </div>\n' +
                    '</div>';
                editor.insertContent(html);
            }
        });
    });
})();
