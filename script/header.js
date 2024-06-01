// h1 || @section Menu item Active Mode |
document.addEventListener("DOMContentLoaded", () => {
  // Select all menu items
  const menuItems = document.querySelectorAll(".top-nav li a");
  let currentUrl = window.location.href;

  // If currentUrl ends with the following items, treat it as the home page
  const endings = [
    "index.php",
    "user",
    "admin",
    "user.php",
    "admin.php",
    "super",
    "super.php",
  ];

  endings.forEach((ending) => {
    if (currentUrl.endsWith(ending)) {
      currentUrl = currentUrl.replace(ending, "") + "index";
    } else if (currentUrl.endsWith(ending + "#")) {
      currentUrl = currentUrl.replace(ending + "#", "index");
    } else if (currentUrl.endsWith(ending + "#contact")) {
      currentUrl = currentUrl.replace(ending + "#contact", "index#contact");
    }
  });
  if (currentUrl.endsWith("/")) {
    currentUrl += "index";
  }

  // Remove 'active' class from all menu items
  menuItems.forEach((menuItem) => {
    menuItem.classList.remove("active");

    // If menuItem href matches current page URL, add 'active' class
    if (
      menuItem.href === currentUrl &&
      !currentUrl.endsWith("login") &&
      !currentUrl.endsWith("register")
    ) {
      menuItem.classList.add("active");
    }
  });
});

// h1 || @section Hamburger menu click event |
const hamburger = document.querySelector(".hamburger");
const topNav = document.querySelector(".top-nav");

if (hamburger) {
  hamburger.addEventListener("click", () => {
    // if classlist contains hidden then remove it
    if (topNav.classList.contains("hidden")) {
      topNav.classList.remove("hidden");
    } else {
      topNav.classList.add("hidden");
    }
  });
}

// top-nav visibility for mobile Screen
// If Doc loaded screen width <= 750px top-nav will be hidden
function toggleNav(matches) {
  if (matches) {
    topNav.classList.add("hidden");
    hamburger.classList.remove("hidden");
  } else {
    topNav.classList.remove("hidden");
    hamburger.classList.add("hidden");
  }
}

const mediaQuery = window.matchMedia("(max-width: 750px)");
mediaQuery.addEventListener("change", (e) => toggleNav(e.matches));
toggleNav(mediaQuery.matches);

/*
function toggleNav() {
  if (window.innerWidth <= 750) {
    topNav.classList.add("hidden");
    hamburger.classList.remove("hidden");
  } else {
    topNav.classList.remove("hidden");
    hamburger.classList.add("hidden");
  }
}

window.addEventListener("resize", function () {
  toggleNav();
});
document.addEventListener("DOMContentLoaded", () => {
  toggleNav();
}); */

// h1 || @section Window Scroll Event |
// Back to top button
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  const backToTopButton = document.querySelector(".back-to-top");
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    backToTopButton.style.display = "block";
  } else {
    backToTopButton.style.display = "none";
  }
}

// h1 || @section Close button|
// close button function for error message
document.querySelector("body").addEventListener("click", (event) => {
  if (event.target.classList.contains("close")) {
    event.target.parentElement.remove();
  }
});
