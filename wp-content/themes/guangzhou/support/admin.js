function show_background (item)
{
  var image = item.options[item.selectedIndex].value;
  
  $('head').style.background = 'url(/site/wp-content/themes/guangzhou/stripes/' + image + ') repeat-x 0 top';
}
