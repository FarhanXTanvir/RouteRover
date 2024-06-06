// Dropdown list script
// Constants for key codes
const KEY_UP = 38;
const KEY_DOWN = 40;
const KEY_ENTER = 13;

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

function showList(list) {
  list.show();
}
function hideList(list) {
  list.hide();
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
// This function filters the list items based on the input value. It shows the items that start with the input values on top of the list and if any part of the list item matches the input value they will also be shown but after the items that start with the input value also highlight(span class=highlight) the exact matching part of the list with input value, don't need to convert to lowercase.
function filterListItems(input, list) {
  const filter = input.val();
  const listItems = list.find("li");

  let startsWithFilter = [];
  let includesFilter = [];

  listItems.each(function () {
    const listItemText = $(this).text();

    // Check if the list item starts with the input value or contains the input value
    if (listItemText.startsWith(filter)) {
      startsWithFilter.push(this);
    } else if (listItemText.includes(filter)) {
      includesFilter.push(this);
    }

    // Highlight the part of the list item that matches the input value
    const highlightedText = listItemText.replace(
      new RegExp(filter.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"), "g"),
      `<span class='highlight'>${filter}</span>`
    );
    $(this).html(highlightedText);
  });

  // Sort the arrays
  startsWithFilter.sort((a, b) => $(a).text().localeCompare($(b).text()));
  includesFilter.sort((a, b) => $(a).text().localeCompare($(b).text()));

  // Combine the arrays
  const filteredListItems = [...startsWithFilter, ...includesFilter];

  // Hide all list items
  listItems.css("display", "none");

  // Show the filtered and sorted list items
  $(filteredListItems).css("display", "");
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
      prevItem[0].scrollIntoView({ behavior: "smooth", block: "nearest" });
    }
  } else {
    let lastItem = visibleItems.last();
    lastItem.addClass("active");
    lastItem[0].scrollIntoView({ behavior: "smooth", block: "nearest" });
  }
}

function navigateDown(visibleItems) {
  let activeItem = visibleItems.filter(".active");
  if (activeItem.length) {
    let nextItem = activeItem.nextAll(":visible").first();
    if (nextItem.length) {
      activeItem.removeClass("active");
      nextItem.addClass("active");
      nextItem[0].scrollIntoView({ behavior: "smooth", block: "nearest" });
    }
  } else {
    let firstItem = visibleItems.first();
    firstItem.addClass("active");
    firstItem[0].scrollIntoView({ behavior: "smooth", block: "nearest" });
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
        const error = `<p class="errorEach" >আপনার যাত্রাস্থান পাওয়া যায়নি!</p>`;
        departureInput.css("border", "0.2rem solid red");
        // append error message after departure input
        destinationInput.parent().after(error);
      }
      if (!destinationFound) {
        const error = `<p class="errorEach" >আপনার গন্তব্যস্থল পাওয়া যায়নি!</p>`;
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
