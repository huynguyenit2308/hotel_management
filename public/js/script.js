(function ($) {
  "use strict";

  var initPreloader = function () {
    $(document).ready(function () {
      var Body = $('body');
      Body.addClass('preloader-site');
    });
    $(window).on('load', function () {
      $('.preloader').fadeOut();
      $('body').removeClass('preloader-site');
    });
  }

  // init Chocolat light box
  var initChocolat = function () {
    Chocolat(document.querySelectorAll('.image-link'), {
      imageSize: 'contain',
      loop: true,
    })
  }

  $(document).ready(function () {
    // Isotope Initialization
    var $container = $('.isotope-container').isotope({
      itemSelector: '.item',
      layoutMode: 'masonry',
    });

    // Filter items on button click
    $('.filter-button').click(function () {
      var filterValue = $(this).attr('data-filter');
      if (filterValue === '*') {
        $container.isotope({ filter: '*' });
      } else {
        $container.isotope({ filter: filterValue });
      }
      $('.filter-button').removeClass('active');
      $(this).addClass('active');
    });

    // Video Modal
    var $videoSrc;
    $('.play-btn').click(function () {
      $videoSrc = $(this).data("src");
    });

    $('#myModal').on('shown.bs.modal', function (e) {
      $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
    })

    $('#myModal').on('hide.bs.modal', function (e) {
      $("#video").attr('src', $videoSrc);
    })

    // Swiper Initialization
    var sliderSwiper = new Swiper(".slider", {
      effect: "fade",
    });

    var roomSwiper = new Swiper(".room-swiper", {
      slidesPerView: 3,
      spaceBetween: 20,
      pagination: {
        el: ".room-pagination",
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        1024: {
          slidesPerView: 2,
        },
        1280: {
          slidesPerView: 3,
        },
      },
    });

    var gallerySwiper = new Swiper(".gallery-swiper", {
      effect: "fade",
      navigation: {
        nextEl: ".main-slider-button-next",
        prevEl: ".main-slider-button-prev",
      },
    });

    var thumbSlider = new Swiper(".product-thumbnail-slider", {
      autoplay: true,
      loop: true,
      spaceBetween: 8,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });

    var largeSlider = new Swiper(".product-large-slider", {
      autoplay: true,
      loop: true,
      spaceBetween: 10,
      effect: 'fade',
      thumbs: {
        swiper: thumbSlider,
      },
    });

    // Preloader
    initPreloader();

    // Chocolat
    initChocolat();

    // Animate on Scroll
    AOS.init({
      duration: 1000,
      once: true,
    });

    // DateTimePicker
    new DateTimePickerComponent.DatePicker('select-arrival-date');
    new DateTimePickerComponent.DatePicker('select-departure-date');
  });
})(jQuery);

setTimeout(() => {
  const alert = document.getElementById('error-alert');
  if (alert) {
    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-10px)';
    setTimeout(() => alert.remove(), 500);
  }
}, 3000);

document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('search-input');
  const suggestionsBox = document.getElementById('search-suggestions');
  const form = input.closest('form');

  input.addEventListener('input', function () {
    const keyword = this.value.trim();

    if (keyword.length < 2) {
      suggestionsBox.classList.add('d-none');
      suggestionsBox.innerHTML = '';
      return;
    }

    fetch(`/autoCompleteService?keyword=${encodeURIComponent(keyword)}`)
      .then(res => res.json())
      .then(data => {
        if (data.length === 0) {
          suggestionsBox.innerHTML = '<div class="p-2 text-muted">Không có kết quả</div>';
        } else {
          suggestionsBox.innerHTML = data.map(item =>
            `<div class="list-group-item list-group-item-action suggestion-item">${item}</div>`
          ).join('');
        }
        suggestionsBox.classList.remove('d-none');

        document.querySelectorAll('.suggestion-item').forEach(el => {
          el.addEventListener('click', function () {
            input.value = this.textContent;
            form.submit();
          });
        });
      });
  });

  document.addEventListener('click', function (e) {
    if (!input.contains(e.target) && !suggestionsBox.contains(e.target)) {
      suggestionsBox.classList.add('d-none');
    }
  });
});
function addImage(event) {
  const input = event.target;
  const preview = document.getElementById('image-preview');

  if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.classList.remove('d-none');
    };

    reader.readAsDataURL(input.files[0]);
  }
}
function updateImage(event) {
  const file = event.target.files[0];
  const update = document.getElementById('update');

  if (file && update) {
    const reader = new FileReader();
    reader.onload = function (e) {
      update.src = e.target.result;
      update.style.display = 'inline-block';
    }
    reader.readAsDataURL(file);
  }
}
document.addEventListener('DOMContentLoaded', function () {
  const checkboxes = document.querySelectorAll('input[name="invoice_ids[]"]');
  const selectAll = document.getElementById('selectAll');
  const summary = document.getElementById('selectedSummary');

  function updateSummary() {
    let checked = 0;
    let total = 0;
    checkboxes.forEach(cb => {
      if (cb.checked) {
        checked++;
        const price = parseFloat(cb.dataset.price);
        total += price;
      }
    });

    if (checked > 0) {
      summary.innerHTML = `Đã chọn ${checked} hóa đơn - Tổng: <strong>${total.toLocaleString('vi-VN')} VND</strong>`;
    } else {
      summary.textContent = '';
    }
  }

  selectAll.addEventListener('change', function () {
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateSummary();
  });

  checkboxes.forEach(cb => cb.addEventListener('change', updateSummary));
  updateSummary();
});
