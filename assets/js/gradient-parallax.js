(function () {
  var init = function () {
    if (!document.body.classList.contains('home')) {
      return;
    }

    var root = document.documentElement;
    var maxScroll = 0;
    var ticking = false;

    var recalc = function () {
      maxScroll = Math.max(
        0,
        root.scrollHeight - window.innerHeight
      );
      updateAngle();
    };

    var updateAngle = function () {
      var progress = maxScroll > 0 ? window.scrollY / maxScroll : 0;
      var angle = 120 + progress * 35;
      root.style.setProperty('--page-gradient-angle', angle + 'deg');
      ticking = false;
    };

    var onScroll = function () {
      if (!ticking) {
        ticking = true;
        requestAnimationFrame(updateAngle);
      }
    };

    recalc();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', function () {
      recalc();
      onScroll();
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
