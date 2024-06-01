// As contents dynamically change, we need to use event delegation to handle events
// This is done by using the .on() method in jQuery

// @section Document Ready
$(document).ready(function () {
  // Dynamically add routes
  let forms = $(".allRoutes").find("form");
  // for each form find formm data-route attribute
  let routeNumbers = [];
  forms.each(function () {
    let routeNo = $(this).data("route");
    if (routeNo !== undefined) {
      routeNumbers.push(routeNo);
    }
  });

  // Defne a global array object which will contain all information about the routes, the removed locations and the new locations
  let allRoutes = {};

  routeNumbers.forEach((routeNo) => {
    allRoutes[routeNo] = {
      routeNo: routeNo,
      modifiedLocations: [],
      newLocations: [],
      removedLocations: [],
    };
  });

  console.log(allRoutes);
  // Get all initials
  $(".location").each(function () {
    $(this).data("initialValue", $(this).val());
  });

  // ---------- Collapsable Groups ------------- @section Collapsable Groups

  // On document load, close or open content based on the icon class
  function openCloseContent(parent) {
    let selector = $(parent).find(".header");
    $(selector).each(function () {
      let icon = $(this).find("i");
      if (icon.hasClass("openable")) {
        $(this).next(".content").hide();
      } else if (icon.hasClass("closable")) {
        $(this).next(".content").show();
      }
    });
    $(".fareBlock").find(".content").hide();
  }
  openCloseContent(document);

  // Toggle the visibility of the parent group's content when the header is clicked
  function toggleContent(selector) {
    $(document).on("click", selector, function () {
      let content = $(this).parent().find("> .content");
      let icon = $(this).find("i");

      // If the icon has the openable and fa-plus classes, replace them with closable and fa-minus
      // and display the content
      if (icon.hasClass("openable") && icon.hasClass("fa-plus")) {
        icon.removeClass("openable fa-plus").addClass("closable fa-minus");
        content.slideDown();
      }
      // If the icon has the closable and fa-minus classes, replace them with openable and fa-plus
      // and hide the content
      else if (icon.hasClass("closable") && icon.hasClass("fa-minus")) {
        icon.removeClass("closable fa-minus").addClass("openable fa-plus");
        content.slideUp();
      }
    });
  }
  toggleContent(".header");

  // -------- Input Field Width Adjustment -------- @section Input Field Width Adjustment
  // Initially set the width of the input fields
  let inputFields = $(".open .content").find(".location, .newRoute");
  inputFields.each(function () {
    let inputLength = $(this).val().length;
    $(this).css("width", inputLength + 2 + "ch"); // Adjust the multiplier as needed
  });

  // Set the width of the input fields as the user types
  $(document).on("input", ".location, .newRoute", function () {
    let inputLength = $(this).val().length;
    if (inputLength === 0) {
      let placeholder = $(this).attr("placeholder");
      if (placeholder) {
        inputLength = placeholder.length - 3;
      }
    }
    let newWidth = Math.max(inputLength + 3, 10) + "ch"; // Set a minimum width of 10ch
    $(this).css("width", newWidth);
  });

  // ----------Ends Collapsable Groups -------------

  // ---------- Add Location ------------- @section Add Location
  $(document).on("click", ".addLocation", function () {
    // add input field before the addLocation button
    $(this).parent().find(".input-field").last().after(`
      <span class="input-field" tabindex="0">
      <input type="text" name='location' class="location" area-label="location" placeholder="Enter a valid Location">
    </span>`);

    // if submitLocation does not exist then add it
    if ($('form input[name="submitLocation"]').length === 0) {
      $("form").append(
        '<div class="break"></div><input class="submitLocation" type="submit" name ="submitLocation" value="Submit">'
      );
    }
  });
  // -------------- Ends Add Location -------------

  // --------------- Focusout Location ------------- @section Focusout Location

  $(document).on("focusout", ".input-field", function () {
    let self = $(this);

    let location = self.find(".location");
    let locationValue = location.val();
    if (locationValue === "") {
      location.css("border", "0.3rem solid red");
    } else {
      // removed error if it exists
      if (self.find(".errorEach").length !== 0) {
        self.find(".errorEach").remove();
      }
    }
    if (locationValue === location.data("initialValue")) {
      setTimeout(function () {
        location.css("border", "#ccc 0.25rem solid");
        self.find(".deleteLocation").remove();
        self.find(".checkLocation, .doubleCheckLocation").remove();
        return;
      }, 500); // Delay of 500 milliseconds
    }
  });

  // --------- Delete Loation ---------------- @section Delete Location
  $(document).on("click", ".deleteLocation", function () {
    // Get the route number
    let routeNo =
      $(this).closest("form").data("route") ||
      $(this).closest("form").find(".newRoute").val();
    if (routeNo !== undefined) {
      let locationInput = $(this).parent().find(".location");
      let locationValue = locationInput.val();

      if (locationValue !== "") {
        allRoutes[routeNo].removedLocations.push(locationValue);
      }

      // if submitLocation does not exist then add it
      if ($("form .submitLocation").length === 0) {
        $("form").append(
          '<div class="break"></div><input class="submitLocation" type="submit" name ="submitLocation" value="Submit">'
        );
      }
      console.log("Location Deleted");
      console.log(allRoutes[routeNo]);
    }
    // Remove the location
    $(this).parent().remove();
  });

  // --------------- Click/Focus Location ------------- @section Click/Focus Location
  let selectCount = 0;
  $(document).on("click", ".location", function () {
    // Find closest form of .location and add a submit button if it doesn't already exist
    const form = $(this).closest("form");
    if (form.find('input[name="submitLocation"]').length === 0) {
      form.append(
        '<div class="break"></div><input type="submit" class="submitLocation" name ="submitLocation" value="Submit">'
      );
    }
    // form.find(".location").each(function () {
    let inputField = $(this).parent();
    // Only append a delete button if one doesn't already exist
    if (inputField.find(".deleteLocation").length === 0) {
      inputField.append(`
        <i class="fa-regular fa-trash deleteLocation" title="Delete Location"></i>`);
    }
    // if location clicked add a check button after it if it doesn't already exist
    let checkButton = inputField.find(".checkLocation");
    let doubleCheckButton = inputField.find(".doubleCheckLocation");
    if (checkButton.length === 0 && doubleCheckButton.length === 0) {
      $(this).after(
        '<i class="fa-regular fa-check checkLocation" title="Check Location"></i>'
      );
    } else if (checkButton.length === 0 && doubleCheckButton.length === 1) {
      doubleCheckButton.replaceWith(
        '<i class="fa-regular fa-check checkLocation" title="Check Location"></i>'
      );
      // border turns back to normal
      $(this).css("border", "#ccc 0.25rem solid");
    }
  });

  // --------------- Check Location ------------- @section Check Location
  $(document).on("click", ".checkLocation", function () {
    // remove eachError if parent class .input-field has it
    let inputField = $(this).parent();
    if (inputField.find(".errorEach").length !== 0) {
      inputField.find(".errorEach").remove();
    }
    let locationInput = $(this).parent().find(".location");

    let form = locationInput.closest("form");
    let routeNo = form.data("route") || form.find(".newRoute").val();
    if (
      routeNo === undefined ||
      routeNo === "" ||
      allRoutes[routeNo] === undefined
    ) {
      // Undefined RouteNo means the route is new, to store information route number must be defined first
      let newRoute = form.find(".newRoute");
      // when checkRoute is clicked make the newRoute readonly
      newRoute.css("border", "0.3rem solid red");
      // insert the error after the newRoute
      newRoute.after(
        '<p class = "errorEach">Please check the route number first</p>'
      );
      // console.log("Please check the route number first");
      return;
    } else {
      // RouteNo is defined, now process the location
      let locationValue = locationInput.val();

      // No need to process if the locationValue is empty
      if (locationValue === "") {
        // insert the error before the end of inputField
        inputField.append(
          '<p class = "errorEach">Please enter a valid location</p>'
        );
        locationInput.css("border", "0.3rem solid red");
        return;
      } else {
        // Undefined initialValue means the location is new
        if (locationInput.data("initialValue") === undefined) {
          console.log("New Location Checked");

          allRoutes[routeNo].newLocations.push(locationValue);
          // set its initial value
          locationInput.data("initialValue", locationValue);

          // replace the check button with a double check button
          $(this).replaceWith(
            '<i class="fa-regular fa-check-double doubleCheckLocation" title="Saved Location"></i>'
          );
          // border turns back to normal
          locationInput.css("border", "#ccc 0.25rem solid");
          // remove error if it exists
          if (inputField.find(".errorEach").length !== 0) {
            inputField.find(".errorEach").remove();
          }
          console.log("New Location Saved");
          console.log(allRoutes[routeNo]);
          console.log("\n");
        }
        // Locations already exists, so it is modified
        else {
          console.log("Modified Location Checked");
          // Compare the initial value with the current value
          let initialValue = locationInput.data("initialValue");
          if (initialValue === locationValue) {
            console.log("No changes made to the location");
            // if stored in modifiedLocations, remove it
            let modifiedLocations = allRoutes[routeNo].modifiedLocations;
            for (let i = 0; i < modifiedLocations.length; i++) {
              if (modifiedLocations[i].initial === locationValue) {
                modifiedLocations.splice(i, 1);
                break;
              }
            }
            console.log("Modified Location Removed as changes reverted");
            console.log(allRoutes[routeNo]);

            // remove the check button and delete button
            $(this).parent().find(".deleteLocation").remove();
            $(this).remove();
            return;
          } else {
            allRoutes[routeNo].modifiedLocations.push({
              initial: initialValue,
              modified: locationValue,
            });
            $(this)
              .parent()
              .find(".location, .newRoute")
              .css("border", "#ccc 0.25rem solid");
            // replace the check button with a double check button
            $(this).replaceWith(
              '<i class="fa-regular fa-check-double doubleCheckLocation" title="Saved Location"></i>'
            );
            console.log("Modified Location Saved");
            console.log(allRoutes[routeNo]);
            console.log("\n");
          }
        }
      }
    }
  });

  // --------------- Add Route ------------- @section Add Route
  $(document).on("click", ".addRoute", function () {
    // this.parent() is the parent of the addRoute button
    addRouteParent = $(this).parent();
    addRouteParent.before(`
      <div class="group">
        <div class="header">New Route <i class="closable fa-solid fa-minus"></i> </div>
        <div class="content">
        <i class="fa-solid fa-trash-alt deleteRoute" title="Delete Route"></i>
          <form method="post">
          <input class="newRoute" name="route" type="text" placeholder="New Route No."><div class="break"></div>
            <span class="input-field newRouteLocations" tabindex="0">
              <input type="text" name="location" class="location" area-label="location" placeholder="Enter a valid Location">
            </span>
            <i class="fa-regular fa-square-plus addLocation" title="Add Location"></i>
            <div class="break"></div><input class="submitLocation" type="submit" name ="submitLocation" value="Submit">
          </form>
        </div>
      </div>`);
  });

  // --------------- Click/Focus Route ------------- @section Click/Focus Route
  $(document).on("click", ".newRoute", function () {
    // find next button if check or double check button exists
    let nextElement = $(this).next();
    if (
      !nextElement.hasClass("checkRoute") &&
      !nextElement.hasClass("doubleCheckRoute")
    ) {
      $(this).after(`
        <i class="fa-regular fa-check checkRoute" title="Save Route"></i>
      `);
    }
  });
  /*
  $(document).on("input", ".newRoute", function () {
    let typedValue = $(this).val();
    console.log(typedValue);
  });
*/
  // --------------- Focusout Route ------------- @section Focusout Route
  $(document).on("focusout", ".newRoute", function () {
    let self = $(this);

    if (self.val() === "") {
      self.css("border", "0.3rem solid red");

      setTimeout(function () {
        self.parent().find(".checkRoute").remove();
      }, 500); // Delay of 500 milliseconds
    }
  });

  // --------------- Check Route ------------- @section Check Route
  $(document).on("click", ".checkRoute", function () {
    let routeInput = $(this).parent().find(".newRoute");
    if (routeInput.val() !== "") {
      let routeNo = routeInput.val();
      allRoutes[routeNo] = {
        routeNo: routeNo,
        modifiedLocations: [],
        newLocations: [],
        removedLocations: [],
      };
      $(this).replaceWith(
        '<i class="fa-regular fa-check-double doubleCheckRoute" title="Saved Route"></i>'
      );
      routeInput.css("border", "0.3rem solid blue");
      // check if next element is .errorEach and remove it
      if (routeInput.next().hasClass("errorEach")) {
        routeInput.next().remove();
      }

      // add property newRoute to allRoutes
      if (allRoutes.newRoutes === undefined) {
        allRoutes.newRoutes = [];
      }
      allRoutes.newRoutes.push(routeNo);
      // .newRoute becomes readonly
      routeInput.prop("readonly", true);
      console.log("New Route Saved\n");
      console.log(allRoutes);
    } else {
      routeInput.css("border", "0.3rem solid red");
    }
  });

  // --------- Delete Route ----------------  @section Delete Route
  $(document).on("click", ".deleteRoute", function () {
    let routeNo =
      $(this).parent().find("form").data("route") ||
      $(this).parent().find(".newRoute").val();

    $(this).closest(".group").remove();

    if (routeNo === undefined || routeNo === "") {
      return;
    } else if (allRoutes[routeNo] !== undefined) {
      if (allRoutes.removedRoutes === undefined) {
        allRoutes.removedRoutes = [];
      }
      allRoutes.removedRoutes.push(routeNo);
      // delete the routenNo
      delete allRoutes[routeNo];
      console.log(allRoutes);
    }

    console.log("Route Deleted");
  });

  // --------------- Ends Removes Location -------------

  // ------------------------ Bug Less till here ------------------------
  // --------------- submits Locations of a route ------------- @section Submit Locations
  $(document).on("submit", "form", function (e) {
    e.preventDefault();

    let form = $(this);
    let error = false;
    form.find(".errorEach").each(function () {
      $(this).remove();
    });
    let routeNo = form.data("route") || form.find(".newRoute").val();
    if (routeNo === undefined || allRoutes[routeNo] === undefined) {
      error = true;
      // insert the error before the submit button
      form
        .find(".submitLocation")
        .before(
          '<p class = "errorEach" style="text-align: center; margin-top: 1.2rem">Please check the route number first</p>'
        );
      return;
    }

    let checkLocation = form.find(".checkLocation");
    if (checkLocation.length !== 0) {
      error = true;
      // insert the error before the submit button
      form
        .find(".submitLocation")
        .before(
          '<p class = "errorEach" style="text-align: center; margin-top: 1.2rem">Please check all the new/modified locations </p>'
        );
    } else {
      form.find(".location").each(function () {
        let locationValue = $(this).val();
        if (locationValue === "") {
          error = true;
          // insert error before the submit button
          form
            .find(".submitLocation")
            .before(
              '<p class = "errorEach">Please check all the new/modified locations </p>'
            );
          return;
        }
      });
      if (error) {
        return;
      }
    }
    if (error === false) {
      let route = allRoutes[routeNo];
      // ajax call to update.php
      $.ajax({
        url: "./adminP/update.php",
        method: "POST",
        data: {
          route: JSON.stringify(route), // Convert the specific route object to a JSON string
        },
        success: function (response) {
          // This function will be called when the request is successful
          console.log("Route " + routeNo + " submitted successfully");
          console.log(response);

          // Insert response after allRoutes
          $(".allRoutes").after(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          // This function will be called if the request fails
          console.error(jqXHR, textStatus, errorThrown);

          // Insert error message after allRoutes
          $(".allRoutes").after(
            '<p class="error">An error occurred while submitting the route</p>'
          );
        },
      });
      // Get all initials again after submit
      $(".location").each(function () {
        $(this).data("initialValue", $(this).val());
      });
    }
  });

  // --------------- submits Routes ------------- @section Submit Routes
  $(document).on("click", ".submitRoute", function () {
    let error = false;
    $(".location, .newRoute").each(function () {
      if ($(this).val() == "") {
        // insert the error before the submit button
        $(".submitRoute").before(
          '<p class = "errorEach" style="text-align: center; margin-top: 1.2rem">Please fill all the fields</p>'
        );
        error = true;
        return;
      }
    });
    if (error) {
      return;
    }
    // ajax call to update.php
    $.ajax({
      url: "./adminP/update.php",
      method: "POST",
      data: {
        allRoutes: JSON.stringify(allRoutes), // Convert the allRoutes object to a JSON string
      },
      success: function (response) {
        // This function will be called when the request is successful
        console.log("All Routes Submitted Successfully:");
        console.log(response);
        // Insert response after allRoutes
        $(".allRoutes").after(response);
        // Refresh the page
        // location.reload();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // This function will be called if the request fails
        console.error(textStatus, errorThrown);
        // Insert error message after allRoutes
        $(".allRoutes").after(
          '<p class="error">An error occurred while submitting the routes</p>'
        );
      },
    });
    // Get all initials again after submit
    $(".location").each(function () {
      $(this).data("initialValue", $(this).val());
    });
    console.log("All Routes Submitted: \n");
    console.log(allRoutes);
  });

  $(document).on("click", ".updateDb", function () {
    // ajax call to update.php
    $.ajax({
      url: "./adminP/update.php",
      method: "POST",
      data: {
        updateDb: true, // Convert the allRoutes object to a JSON string
      },
      success: function (response) {
        // This function will be called when the request is successful
        console.log("Database Connected...");
        console.log(response);
        // Insert response after allRoutes
        // $(".allRoutes").after(response);
        // Refresh the page
        // location.reload();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // This function will be called if the request fails
        console.error(textStatus, errorThrown);
        // Insert error message after allRoutes
        $(".allRoutes").after(
          '<p class="error">An error occurred while submitting the routes</p>'
        );
      },
    });
  });

  function updateFare(fareBlock, fareBlockContent, routeNo, fareValues) {
    console.log("Fares Update Request for " + routeNo);
    // ajax call to update.php
    $.ajax({
      url: "./adminP/update.php",
      method: "POST",
      data: {
        submitFare: routeNo, // Convert the allRoutes object to a JSON string
        fareValues: fareValues,
      },
      success: function (response) {
        console.log("Fares Updated Successfully");
        fareBlockContent.remove();
        fareBlock.append(response);
        fareBlockContent = fareBlock.find(".fareBlockContent");

        // hide all classes .contents of class .fareBlockContent
        fareBlockContent.find(".content").each(function () {
          $(this).hide();
        });
        savedFareValues[routeNo] = saveFareValues(fareBlockContent);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
        $(".allRoutes").after(
          '<p class="error">An error occurred while submitting the routes</p>'
        );
      },
    });
  }

  $(document).on("click", ".submitFare", function () {
    const fareBlockContent = $(this).parent();
    const fareBlock = fareBlockContent.closest(".fareBlock");
    const routeNo = fareBlock.parent().find("form").data("route");

    let fareValues = saveFareValues(fareBlockContent);

    // Compare the fareValues with the savedFareValues and when there is a change, update the savedFareValues for both departure and destination and vice versa, then send the changed fareValues as updatedFares to the server
    let updatedFares = {};
    for (let departure in fareValues) {
      for (let destination in fareValues[departure]) {
        if (
          savedFareValues[routeNo][departure] === undefined ||
          savedFareValues[routeNo][departure][destination] === undefined ||
          savedFareValues[routeNo][departure][destination] !==
            fareValues[departure][destination]
        ) {
          if (updatedFares[departure] === undefined) {
            updatedFares[departure] = {};
          }
          updatedFares[departure][destination] =
            fareValues[departure][destination];
        }
      }
    }
    console.log(updatedFares);

    // console.log(fareValues);
    console.log("Fare update Request for " + routeNo);

    // ajax call to update.php
    updateFare(fareBlock, fareBlockContent, routeNo, updatedFares);
  });

  let savedFareValues = {};
  function saveFareValues(fareBlockContent) {
    let fareValues = {};
    fareBlockContent.find(".farePair").each(function () {
      let farePair = $(this);
      let departure = farePair.data("departure");
      let destination = farePair.data("destination");
      let fare = farePair.find(".fare").val() || "০";
      if (fareValues[departure] === undefined) {
        fareValues[departure] = {};
      }
      fareValues[departure][destination] = fare;

      // fareValues[destination] = {};
      // fareValues[destination][departure] = fare;
    });
    return fareValues;
  }
  function showFare(fareBlock, routeNo) {
    console.log("Fare Information Request for " + routeNo);
    // ajax call to update.php
    $.ajax({
      url: "./adminP/update.php",
      method: "POST",
      data: { showFare: routeNo },
      success: function (response) {
        console.log("Fare Information Received");
        fareBlock.append(response);
        // hide all classes .contents of class .fareBlockContent
        $(".fareBlockContent")
          .find(".content")
          .each(function () {
            $(this).hide();
          });
        // access all the farePairs and get the data of departure and destination and assign it to fareValues object as value = fare
        fareBlockContent = fareBlock.find(".fareBlockContent");
        savedFareValues[routeNo] = saveFareValues(fareBlockContent);
        console.log("Saved Fare Values: ");
        console.log(savedFareValues);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
        $(".allRoutes").after(
          '<p class="error">An error occurred while submitting the routes</p>'
        );
      },
    });
  }

  $(document).on("click", ".fareBlockHeader", function () {
    const fareBlock = $(this).parent();
    const routeNo = fareBlock.parent().find("form").data("route");

    // If fareBlock has content, just toggle it
    if (fareBlock.find("> .content").length !== 0) {
      fareBlock.find("> .content").slideToggle();
      // fareBlock.find("> .content > .group > .content").slideUp();
    } else {
      // If fareBlock has no content, request it and then slide it down
      showFare(fareBlock, routeNo);
    }
  });

  $(document).on("click", ".generateRandomValues", function () {
    let routeList = [];
    $(".allRoutes form").each(function () {
      routeList.push($(this).data("route"));
    });
    // ajax call to update.php
    $.ajax({
      url: "./adminP/update.php",
      method: "POST",
      data: { generateRandomValues: routeList },
      success: function (response) {
        console.log("Random Values Generated: ");
        console.log(response);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
        $(".allRoutes").after(
          '<p class="error">An error occurred while submitting the routes</p>'
        );
      },
    });
  });
  // ------------------------ End of Document Ready ------------------------
});

/*
    let location = $(this);
    let formParent = form.parent();
    let selected = form.find(".selected");
    // check if the location has readonly attribute
    if (location.prop("readonly") === true) {
      selectCount = selected.length;
      if (selectCount < 2) {
        // @bug Update Fare
        location.css("background", "white");
        location.css("color", "black");

        // add class selected to the location
        location.addClass("selected");
        // remove class location from the location
        location.removeClass("location");

        // add the selected location to the form named fareForm
        // formParent.find(".fareBlock .submitFare").before(location);
      } else if (selectCount === 2) {
        // if two locations are selected, remove the click event from all locations of the form
        form.find(".location").each(function () {
          $(this).off("click");
        });
      }
    }
    if (selectCount === 2) {
      // add the selected location after the beginning of the the form named fareForm
      // add the two selected locations to the form named fareForm binding them with a span tag
      formParent.find(".fareBlock .fareInput").append(
        `<div class="fare-field" tabindex="0">
          <input class="fareInput" type="text" name="fare" placeholder="Enter Fare">
        </div>`
      );
      formParent.find(".fareBlock .fareInput .fare-field").prepend(selected);
      return;
    }
    if (location.prop("readonly") === true) {
      return;
    }
    */
