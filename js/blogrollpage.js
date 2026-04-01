/*global jsToolBar, dotclear */
'use strict';

dotclear.ready(() => {
  // HTML text editor
  if (typeof jsToolBar === 'function') {
    for (const elt of document.querySelectorAll('#blogrollpage textarea')) {
      dotclear.tbWidgetText = new jsToolBar(elt);
      dotclear.tbWidgetText.context = 'blogrollpage';
      dotclear.tbWidgetText.draw('xhtml');
    }
  }
});
