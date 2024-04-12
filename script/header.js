// Select all menu items
const menuItems = document.querySelectorAll(".top-nav li a");

document.addEventListener("DOMContentLoaded", (event) => {
  let currentUrl = window.location.href;

  // If currentUrl is the root directory, treat it as the home page
  if (currentUrl.endsWith("/")) {
    currentUrl += "index";
  }

  // Remove 'active' class from all menu items
  menuItems.forEach((menuItem) => {
    menuItem.classList.remove("active");

    // If menuItem href matches current page URL, add 'active' class
    if (menuItem.href === currentUrl) {
      menuItem.classList.add("active");
    }
  });
});
