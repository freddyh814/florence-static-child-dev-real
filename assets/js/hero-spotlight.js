(function () {
  var init = function () {
    if (window.matchMedia('(hover: none)').matches) {
      return;
    }

    var hero = document.querySelector('.front-hero');
    if (!hero) {
      return;
    }

    var setSpotlight = function (event) {
      var rect = hero.getBoundingClientRect();
      var x = ((event.clientX - rect.left) / rect.width) * 100;
      var y = ((event.clientY - rect.top) / rect.height) * 100;
      x = Math.min(100, Math.max(0, x));
      y = Math.min(100, Math.max(0, y));
      hero.style.setProperty('--spotlight-x', x + '%');
      hero.style.setProperty('--spotlight-y', y + '%');
      hero.style.setProperty('--spotlight-opacity', '1');
    };

    hero.addEventListener('pointermove', setSpotlight);
    hero.addEventListener('pointerenter', function (event) {
      setSpotlight(event);
      hero.style.setProperty('--spotlight-opacity', '1');
    });
    hero.addEventListener('pointerleave', function () {
      hero.style.setProperty('--spotlight-opacity', '0');
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
