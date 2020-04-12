<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title><?= TITLE ?></title>

<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/logo-nav.css" rel="stylesheet">
<link href="/css/custom.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/plugins/datatables.min.css"/>

<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/cleave.min.js"></script>
<script type="text/javascript" src="/plugins/datatables.min.js"></script>

<script type="text/javascript">
  function changeLocale(e)
  {
      var lang = e.target.lang;
      var path = window.location.pathname;
      var pos = path.search(/(en|ru|ua)/);
      if(pos === -1)
      {
        path = '/' + lang + path;
      }
      else if (pos === 1)
      {
        path = path.replace(/(en|ru|ua)/, lang);
      }
      window.location.replace(window.location.origin + path);
  }
</script>
