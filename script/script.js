// Dropdown list script
// Constants for key codes
const KEY_UP = 38;
const KEY_DOWN = 40;
const KEY_ENTER = 13;
const KEY_BACKSPACE = 8;

const departureInput = $('input[name="departure"]');
const departureList = $("#departure");
const destinationInput = $('input[name="destination"]');
const destinationList = $("#destination");
const routeInput = $('input[name="routes"]');
const routeInputList = $("#routes");

// Timeout ID for hiding lists
let timeoutId;

// Add event listeners for input fields
addInputEventListeners(departureInput, departureList);
addInputEventListeners(destinationInput, destinationList);
addInputEventListeners(routeInput, routeInputList);

// Add click event listeners to list items
addListItemClickListeners(departureList, departureInput);
addListItemClickListeners(destinationList, destinationInput);
addListItemClickListeners(routeInputList, routeInput);

// Add keydown event listeners for navigating lists
addListNavigationKeydownListeners(departureInput, departureList);
addListNavigationKeydownListeners(destinationInput, destinationList);
addListNavigationKeydownListeners(routeInput, routeInputList);

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
    if (e.keyCode === KEY_BACKSPACE) {
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
  $("form").on("keydown", function (e) {
    if (e.keyCode === KEY_ENTER) {
      $(this)
        .find("input")
        .each(function () {
          if ($(this).val() === "") {
            e.preventDefault();
            return false;
          }
        });
    }
  });
}

// ---------- End of Dropdown list script ----------
$("form").on("submit", function (e) {
  e.preventDefault();
});
// route-finder form prevent default
$("#showFair").on("submit", function (e) {
  const departureInput = $('input[name="departure"]');
  const departureList = $("#departure");
  const departure = departureInput.val().trim();
  const departureInputFieldset = departureInput.parent();

  const destinationInput = $('input[name="destination"]');
  const destinationList = $("#destination");
  const destination = destinationInput.val().trim();
  const destinationInputFieldset = destinationInput.parent();

  const inputBinder = $(".input-binder");
  const formParent = $(this).parent();

  // if departureInput parent has error message, remove it
  departureInputFieldset.css("border", "0.2rem solid orange");
  destinationInputFieldset.css("border", "0.2rem solid orange");
  if (formParent.find(".errorEach").length) {
    formParent.find(".errorEach").remove();
  }

  if (!destination || !departure) {
    if (!departure && !destination) {
      const error = `<p class="errorEach" >যাত্রাস্থান ও গন্তব্যস্থল পূরণ করুন</p>`;
      departureInputFieldset.css("border", "0.2rem solid red");
      destinationInputFieldset.css("border", "0.2rem solid red");
      // append error message after destination input
      inputBinder.after(error);
      return;
    } else if (!departure) {
      const error = `<p class="errorEach" >যাত্রাস্থান পূরণ করুন</p>`;
      departureInputFieldset.css("border", "0.2rem solid red");
      // append error message after departure input
      inputBinder.after(error);
      return;
    } else if (!destination) {
      const error = `<p class="errorEach" >গন্তব্যস্থল পূরণ করুন</p>`;
      destinationInputFieldset.css("border", "0.2rem solid red");
      // append error message after destination input
      inputBinder.after(error);
      return;
    } else {
      alert("Route found!");
    }
  } else {
    if (departure === destination) {
      const error = `<p class="errorEach" >দুঃখিত! যাত্রাস্থল ও গন্তব্যস্থল একই হতে পারেনা।</p>`;
      departureInputFieldset.css("border", "0.2rem solid red");
      destinationInputFieldset.css("border", "0.2rem solid red");
      // append error message after destination input
      inputBinder.after(error);
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
        departureInputFieldset.css("border", "0.2rem solid red");
        // append error message after departure input
        inputBinder.after(error);
      }
      if (!destinationFound) {
        const error = `<p class="errorEach" >আপনার গন্তব্যস্থল পাওয়া যায়নি!</p>`;
        destinationInputFieldset.css("border", "0.2rem solid red");
        // append error message after destination input
        inputBinder.after(error);
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
            document.getElementById("showFairResult").innerHTML = response;
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
$("#route-finder #showRoute").on("submit", function (e) {
  const routeInput = $('input[name="routes"]');
  const routeInputList = $("#routes");
  const routeInputFieldset = routeInput.parent();
  const form = $("#route-finder #showRoute");
  const routeNo = routeInput.val().trim();
  const formParent = $(this).parent();

  // if departureInput parent has error message, remove it
  routeInputFieldset.css("border", "0.2rem solid orange");
  if (formParent.find(".errorEach").length) {
    formParent.find(".errorEach").remove();
  }

  if (!routeNo) {
    const error = `<p class="errorEach" >রুট নং পূরণ করুন</p>`;
    routeInputFieldset.css("border", "0.2rem solid red");
    // append error message after destination input
    form.append(error);
    return;
  } else {
    // check if departure and destination value in the lists
    const routeInputListItems = routeInputList.find("li");
    let routeFound = false;
    for (let i = 0; i < routeInputListItems.length; i++) {
      if (routeInputListItems[i].textContent === routeNo) {
        routeFound = true;
        break;
      }
    }
    if (!routeFound) {
      const error = `<p class="errorEach" >আপনার রুট পাওয়া যায়নি!</p>`;
      routeInputFieldset.css("border", "0.2rem solid red");
      // append error message after departure input
      form.append(error);
    }
    if (routeFound) {
      const searchRoute = {
        searchRoute: true,
        routeNo: routeNo,
      };
      $.ajax({
        url: "./search.php",
        method: "POST",
        data: {
          searchRoute: JSON.stringify(searchRoute), // Convert the allRoutes object to a JSON string
        },
        success: function (response) {
          // This function will be called when the request is successful
          console.log("Search Route Request Submitted Successfully:");
          // insert the response into the #searchResult div
          document.getElementById("showRouteResult").innerHTML = response;
        },
        error: function (jqXHR, textStatus, errorThrown) {
          // This function will be called if the request fails
          console.error(textStatus, errorThrown);
        },
      });
    }
  }
});

$("#contactForm").on("submit", function (e) {
  const emailInput = $('input[name="email"]');
  const email = emailInput.val().trim();
  const emailInputFieldset = emailInput.parent();
  const messageInput = $('textarea[name="message"]');
  const message = messageInput.val().trim();
  const messageInputFieldset = messageInput.parent();
  const form = $("#contactForm");
  const formParent = $(this).parent();

  // if departureInput parent has error message, remove it
  emailInputFieldset.css("border", "0.2rem solid orange");
  if (formParent.find(".errorEach").length) {
    formParent.find(".errorEach").remove();
  }

  if (!email) {
    const error = `<p class="errorEach" >ইমেইল প্রদান করুন</p>`;
    emailInputFieldset.css("border", "0.2rem solid red");
    // append error message after destination input
    emailInputFieldset.after(error);
  }
  if (!message) {
    const error = `<p class="errorEach" >মেসেজ প্রদান করুন</p>`;
    messageInputFieldset.css("border", "0.2rem solid red");
    // append error message after destination input
    messageInputFieldset.after(error);
  }
  if (email && message) {
    const sendMessage = {
      sendMessage: true,
      email: email,
      message: message,
    };
    $.ajax({
      url: "./contact.php",
      method: "POST",
      data: {
        sendMessage: JSON.stringify(sendMessage),
      },
      success: function (response) {
        // This function will be called when the request is successful
        console.log("Message Sent Successfully:");
        // insert the response into the #searchResult div
        form.append(response);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // This function will be called if the request fails
        console.error(textStatus, errorThrown);
      },
    });
  }
});
