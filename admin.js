/**
 * Tab navigation
 */
(function($){

  const setActiveTab = (index) => {
    $('.nav-tab-wrapper .nav-tab-active').removeClass('nav-tab-active');
    $('.wrap').find('section:visible').hide();

    $('.wrap').find('section').eq(index).show();
    $('.nav-tab-wrapper').find('a').eq(index).addClass('nav-tab-active')
  }

  // Create sections.
  $('.wrap').find('h2').each(function() {
    $(this).nextUntil('h2, p').andSelf().wrapAll('<section/>');
  });

  // Create tab nav
  $navTabWrap = $('<nav class="nav-tab-wrapper" />')

  $('.wrap section').each(function(){
    var $tab = $('<a href="#" class="nav-tab" />');
    $tab.html($(this).find('h2').text());
    $tab.on('click', function(){
      setActiveTab($(this).index());
      $(this).blur();
    });
    $navTabWrap.append($tab);
  });

  $navTabWrap.insertAfter('.wrap h1')

  setActiveTab(0);

})(jQuery);
/**
 * Editor field
 *
 * @link https://www.tiny.cloud/docs/configure/editor-appearance/
 */
(function($){

  $('.wrap .my-plugin-editor').each(function(){
    var $field = $(this);

    var init = {
      id: $field.attr('id'),
      selector: '#' + $field.attr('id'),
      branding: false,
      height: 300,
      plugins: 'link lists',
      // toolbar: 'undo redo | bold italic | link | numlist bullist | styleformats'
    };

    tinymce.init( init );

  });

})(jQuery);
