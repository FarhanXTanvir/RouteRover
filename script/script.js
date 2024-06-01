// Dropdown list script
// Constants for key codes
const KEY_UP = 38;
const KEY_DOWN = 40;
const KEY_ENTER = 13;
// while typing if arrow key down then navigation doesn't work @bug fix: dropdown list script
// Get the input fields and unordered lists
const departureInput = $('input[name="departure"]');
const departureList = $("#departure");
const destinationInput = $('input[name="destination"]');
const destinationList = $("#destination");

// Timeout ID for hiding lists
let timeoutId;

// Add event listeners for input fields
addInputEventListeners(departureInput, departureList);
addInputEventListeners(destinationInput, destinationList);

// Add click event listeners to list items
addListItemClickListeners(departureList, departureInput);
addListItemClickListeners(destinationList, destinationInput);

// Add keydown event listeners for navigating lists
addListNavigationKeydownListeners(departureInput, departureList);
addListNavigationKeydownListeners(destinationInput, destinationList);

// Prevent form submission on Enter key press
preventFormSubmissionOnEnter();

// Functions

function showList(list) {
  list.show();
}

function scheduleHideList(list) {
  setTimeout(() => {
    list.hide();
  }, 100);
}

function addInputEventListeners(input, list) {
  input.on("focus", () => showList(list));

  input.on("blur", () => scheduleHideList(list));

  input.on("keydown", function (e) {
    if (e.keyCode === 8) {
      // 8 is the key code for the backspace key
      showList(list);
    }
  });

  input.on("input", () => filterListItems(input, list));
}

// Filter Function
function filterListItems(input, list) {
  const filter = input.val();
  const listItems = list.find("li");

  listItems.each(function () {
    const listItemText = $(this).text();
    $(this).css(
      "display",
      listItemText.substring(0, filter.length) === filter ? "" : "none"
    );
  });
}

function addListItemClickListeners(list, input) {
  const listItems = list.find("li");

  listItems.each(function () {
    $(this).on("click", function () {
      input.val($(this).text());
      clearTimeout(timeoutId);
      hideList(list);
    });
  });
}

function addListNavigationKeydownListeners(input, list) {
  input.on("keydown", (e) => navigateList(e, list, input));
}

function navigateList(e, list, input) {
  let visibleItems = list.find("li:visible");

  switch (e.keyCode) {
    case KEY_UP:
      navigateUp(visibleItems);
      break;
    case KEY_DOWN:
      navigateDown(visibleItems);
      break;
    case KEY_ENTER:
      selectActiveItem(e, visibleItems, input, list);
      break;
  }
}

function navigateUp(visibleItems) {
  let activeItem = visibleItems.filter(".active");
  if (activeItem.length) {
    let prevItem = activeItem.prevAll(":visible").first();
    if (prevItem.length) {
      activeItem.removeClass("active");
      prevItem.addClass("active");
    }
  } else {
    let lastItem = visibleItems.last();
    lastItem.addClass("active");
  }
}

function navigateDown(visibleItems) {
  let activeItem = visibleItems.filter(".active");
  if (activeItem.length) {
    let nextItem = activeItem.nextAll(":visible").first();
    if (nextItem.length) {
      activeItem.removeClass("active");
      nextItem.addClass("active");
    }
  } else {
    let firstItem = visibleItems.first();
    firstItem.addClass("active");
  }
}
function selectActiveItem(e, visibleItems, input, list) {
  let activeItem = visibleItems.filter(".active");
  if (activeItem.length) {
    input.val(activeItem.text());
    activeItem.removeClass("active");
    list.hide();
    e.preventDefault(); // Prevent form submission
    e.stopPropagation(); // Stop event from propagating
  }
}

function preventFormSubmissionOnEnter() {
  const form = $("form");

  form.on("keydown", (e) => {
    if (e.keyCode === KEY_ENTER) {
      if (departureInput.val() === "" || destinationInput.val() === "") {
        e.preventDefault();
      }
    }
  });
}

/*
function addInputEventListeners(input, list) {
  input.on("focus", () => showList(list));
  input.on("blur", () => scheduleHideList(list));
  input.on("input", () => filterListItems(input, list));
}

function navigateList(e, list, input) {
  let activeItem = list.find("li.active");

  switch (e.keyCode) {
    case KEY_UP:
      navigateUp(activeItem, list);
      break;
    case KEY_DOWN:
      navigateDown(activeItem, list);
      break;
    case KEY_ENTER:
      selectActiveItem(e, activeItem, input, list);
      break;
  }
}

function navigateUp(activeItem, list) {
  if (activeItem.length) {
    const prevItem = activeItem.prev();
    if (prevItem.length) {
      activeItem.removeClass("active");
      prevItem.addClass("active");
      if (prevItem.position().top < 0) {
        list.scrollTop(list.scrollTop() + prevItem.position().top);
      }
    }
  } else {
    const lastItem = list.find("li").last();
    lastItem.addClass("active");
    list.scrollTop(list.prop("scrollHeight"));
  }
}

function navigateDown(activeItem, list) {
  if (activeItem.length) {
    const nextItem = activeItem.next();
    if (nextItem.length) {
      activeItem.removeClass("active");
      nextItem.addClass("active");
      if (
        nextItem.position().top + nextItem.outerHeight() >
        list.outerHeight()
      ) {
        list.scrollTop(
          list.scrollTop() +
            nextItem.position().top +
            nextItem.outerHeight() -
            list.outerHeight()
        );
      }
    }
  } else {
    const firstItem = list.find("li").first();
    firstItem.addClass("active");
    list.scrollTop(0);
  }
} 

function selectActiveItem(e, activeItem, input, list) {
  if (activeItem.length) {
    input.val(activeItem.text());
    activeItem.removeClass("active");
    list.hide();
    e.preventDefault(); // Prevent form submission
    e.stopPropagation(); // Stop event from propagating
  }
} 
*/

// ---------- End of Dropdown list script ----------

// route-finder form prevent default
$("#route-finder").on("submit", function (e) {
  e.preventDefault();
  const departureInput = $('input[name="departure"]');
  const departureList = $("#departure");
  const destinationInput = $('input[name="destination"]');
  const destinationList = $("#destination");
  const departure = departureInput.val();
  const destination = destinationInput.val();
  const routeFinder = $("#route-finder");

  // if departureInput parent has error message, remove it
  departureInput.css("border", "0.2rem solid orange");
  destinationInput.css("border", "0.2rem solid orange");
  if (routeFinder.find(".errorEach").length) {
    routeFinder.find(".errorEach").remove();
  }

  if (!destination || !departure) {
    if (!departure && !destination) {
      const error = `<p class="errorEach" >যাত্রাস্থান ও গন্তব্যস্থল পূরণ করুন</p>`;
      departureInput.css("border", "0.2rem solid red");
      destinationInput.css("border", "0.2rem solid red");
      // append error message after destination input
      destinationInput.parent().after(error);
      return;
    } else if (!departure) {
      const error = `<p class="errorEach" >যাত্রাস্থান পূরণ করুন</p>`;
      departureInput.css("border", "0.2rem solid red");
      // append error message after departure input
      destinationInput.parent().after(error);
      return;
    } else if (!destination) {
      const error = `<p class="errorEach" >গন্তব্যস্থল পূরণ করুন</p>`;
      destinationInput.css("border", "0.2rem solid red");
      // append error message after destination input
      destinationInput.parent().after(error);
      return;
    } else {
      alert("Route found!");
    }
  } else {
    if (departure === destination) {
      const error = `<p class="errorEach" >দুঃখিত! যাত্রাস্থল ও গন্তব্যস্থল একই হতে পারেনা।</p>`;
      departureInput.css("border", "0.2rem solid red");
      destinationInput.css("border", "0.2rem solid red");
      // append error message after destination input
      destinationInput.parent().after(error);
      return;
    } else {
      // check if departure and destination value in the lists
      const departureListItems = departureList.find("li");
      let departureFound = false;
      for (let i = 0; i < departureListItems.length; i++) {
        if (departureListItems[i].textContent === departure) {
          departureFound = true;
          break;
        }
      }
      const destinationListItems = destinationList.find("li");
      let destinationFound = false;
      for (let i = 0; i < destinationListItems.length; i++) {
        if (destinationListItems[i].textContent === destination) {
          destinationFound = true;
          break;
        }
      }
      if (!departureFound) {
        const error = `<p class="errorEach" >আপনার যাত্রাস্থান পায়া যায়নি!</p>`;
        departureInput.css("border", "0.2rem solid red");
        // append error message after departure input
        destinationInput.parent().after(error);
      }
      if (!destinationFound) {
        const error = `<p class="errorEach" >আপনার গন্তব্যস্থল পায়া যায়নি!</p>`;
        destinationInput.css("border", "0.2rem solid red");
        // append error message after destination input
        destinationInput.parent().after(error);
      }
      if (departureFound && destinationFound) {
        const searchData = {
          search: true,
          departure: departure,
          destination: destination,
        };
        $.ajax({
          url: "./search.php",
          method: "POST",
          data: {
            searchData: JSON.stringify(searchData), // Convert the allRoutes object to a JSON string
          },
          success: function (response) {
            // This function will be called when the request is successful
            console.log("Search Request Submitted Successfully:");
            // insert the response into the #searchResult div
            document.getElementById("searchResult").innerHTML = response;
          },
          error: function (jqXHR, textStatus, errorThrown) {
            // This function will be called if the request fails
            console.error(textStatus, errorThrown);
          },
        });
      }
    }
  }
});
