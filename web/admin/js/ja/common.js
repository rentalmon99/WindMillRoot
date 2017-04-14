$(document).ready(function () {

    // Add smooth scrolling to all links in navbar + footer link
    $(" a ").on('click', function (event) {

        // Prevent default anchor click behavior
        event.preventDefault();

        // Store hash
        var hash = this.hash;

        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 900, function () {

            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
        });
    });

    // Slide in elements on scroll
    $(window).scroll(function () {
        $(".slideanim").each(function () {
            var pos = $(this).offset().top;

            var winTop = $(window).scrollTop();
            if (pos < winTop + 600) {
                $(this).addClass("slide");
            }
        });
    });
});
         $(document).scroll(function ()
      {
          if ($(document).scrollTop() < 500)
          {
              $(".goto-top-button").css("visibility","hidden");
          }
          else if ($(document).scrollTop() >= 501)
          {
              $(".goto-top-button").css("visibility","visible");
          }
      });

