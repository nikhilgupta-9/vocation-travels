<!-- Anti-Flicker & Dark/Light Theme Initializer (Must run before render) -->
<script>
  (function() {
    try {
      var saved = localStorage.getItem('vt_theme');
      var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
      if (saved === 'dark' || (!saved && prefersDark)) {
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-theme', 'dark');
      } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-theme', 'light');
      }
    } catch(e) {}
  })();
</script>

<!-- Standard favicon -->
<link rel="shortcut icon" type="image/x-icon" href="<?= $site ?>assets/images/logo.png">

<!-- Local Tailwind CSS (Full Offline & Online Support) -->
<script src="<?= $site ?>assets/js/tailwind.min.js"></script>
<script>
  if (typeof tailwind !== 'undefined') {
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: '#1ec700',
            brandDark: '#159c00',
            brandRose: '#e11d48'
          }
        }
      }
    };
  }
</script>

<!-- Local Vendor Icons (Offline & Online) -->
<link rel="stylesheet" href="<?= $site ?>assets/vendor/fontawesome/css/all.min.css">
<link rel="stylesheet" href="<?= $site ?>assets/vendor/material-icons/material-icons.css">

<!-- Custom Stylesheet with Dark & Light Theme System -->
<link href="<?= $site ?>assets/css/styles.css" rel="stylesheet">