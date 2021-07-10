$(".nav-link ").click(function() {             // when clicking any of these links
    $(".nav-link ").removeClass("active"); // remove highlight from all links
    $(this).addClass("active");          // add highlight to clicked link
})