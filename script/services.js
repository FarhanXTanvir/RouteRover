flatpickr("#date", {
  dateFormat: "d-m-Y",
  allowInput: true,
  minDate: "today",
});

flatpickr("#time", {
  enableTime: true,
  noCalendar: true,
  dateFormat: "h:i K",
  allowInput: true,
});

$(document).on("submit", "form", function (e) {
  e.preventDefault();
});

// route-finder form prevent default
$("#showTickets").on("submit", function (e) {
  const departureInput = $('input[name="departure"]');
  const departureList = $("#departure");
  const departure = departureInput.val().trim();
  const departureInputFieldset = departureInput.parent();

  const destinationInput = $('input[name="destination"]');
  const destinationList = $("#destination");
  const destination = destinationInput.val().trim();
  const destinationInputFieldset = destinationInput.parent();

  const inputBinder = departureInputFieldset.parent();
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
