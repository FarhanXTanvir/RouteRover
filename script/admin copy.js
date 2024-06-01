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
  $(document).on("click", ".header", function () {
    let parent = $(this).parent();
    let content = parent.find("> .content");
    let inputFields = content.find(".location, .newRoute");
    content.first().slideToggle();

    // Toggle the plus and minus icons
    let icon = $(this).find("i");
    if (icon.hasClass("closable") && icon.hasClass("fa-minus")) {
      icon.removeClass("closable fa-minus").addClass("openable fa-plus");
    } else if (icon.hasClass("openable") && icon.hasClass("fa-plus")) {
      icon.removeClass("openable fa-plus").addClass("closable fa-minus");
    }

    inputFields.each(function () {
      let inputLength = $(this).val().length;
      $(this).css("width", inputLength + 2 + "ch"); // Adjust the multiplier as needed
    });
  });

  $(document).on("input", ".location, .newRoute", function () {
    let inputLength = $(this).val().length;
    if (inputLength === 0) {
      inputLength = $(this).attr("placeholder").length - 3;
    }
    let newWidth = Math.max(inputLength + 3, 10) + "ch"; // Set a minimum width of 10ch
    $(this).css("width", newWidth);
  });

  // Close all child groups on page load
  $(".open .group .content").hide();

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

    // if submitRoute does not exist then add it
    if ($(".submitRoute").length === 0) {
      $(".allRoutes > .group > .content").append(
        '<input class="submitRoute" type="submit" name="submitRoute" value="Submit">'
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
      if ($(".submitRoute").length === 0) {
        $(".allRoutes > .group > .content").append(
          '<input class="submitRoute" type="submit" name="submitRoute" value="Submit">'
        );
      }
      console.log("Location Deleted");
      console.log(allRoutes[routeNo]);
    }
    // Remove the location
    $(this).parent().remove();
  });
  // @warn start
  // let globalCurrentValue = {};

  // --------------- Click/Focus Location ------------- @section Click/Focus Location
  $(document).on("click", ".location", function () {
    // Find closest form of .location and add a submit button if it doesn't already exist
    const form = $(this).closest("form");
    if (form.find('input[name="submitLocation"]').length === 0) {
      form.append(
        '<div class="break"></div><input type="submit" class="submitLocation" name ="submitLocation" value="Submit">'
      );
    }
    if ($(".submitRoute").length === 0) {
      $(".allRoutes > .group > .content").append(
        '<input class="submitRoute" type="submit" name="submitRoute" value="Submit">'
      );
    }

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

    // currentValue = $(this).val();
    // let routeNo = $(this).closest("form").data("route");
    // if (routeNo !== undefined) {
    //   if (globalCurrentValue[routeNo] === undefined) {
    //     globalCurrentValue[routeNo] = {};
    //   }
    //   globalCurrentValue[routeNo][currentValue] = currentValue;
    // }
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
      // when checkRoute is clicked make the @warn newRoute readonly
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

          // replace the check button with a double check button
          $(this).replaceWith(
            '<i class="fa-regular fa-check-double doubleCheckLocation" title="Saved Location"></i>'
          );
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
            // remove the check button and delete button
            $(this).parent().find(".deleteLocation").remove();
            $(this).remove();
            return;
          } else {
            allRoutes[routeNo].modifiedLocations.push({
              initial: initialValue,
              modified: locationValue,
            });

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
  // @warn End

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
    if ($(".submitRoute").length === 0) {
      $(".allRoutes > .group > .content").append(
        '<input class="submitRoute" type="submit" name="submitRoute" value="Submit">'
      );
    }
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

    if ($(".submitRoute").length === 0) {
      $(".allRoutes > .group > .content").append(
        '<input class="submitRoute" type="submit" name="submitRoute" value="Submit">'
      );
    }
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
          console.error(textStatus, errorThrown);

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

  // ------------------------ End of Document Ready ------------------------
});

// ------------------------ End of Script ------------------------
/*
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
    // Fetch the updated data from the JSON file
    $.getJSON("script/routes.json", function (data) {
      // Clear the content div
      $(".allRoutes> .open > .content").empty();
      // Add the updated locations to the content div
      data.forEach(function (route, locations) {
        let group = $('<div class="group"></div>');
        group.append(
          '<div class="header">রুট' +
            route +
            ' <i class="openable fa-solid fa-plus"></i></div>'
        );
        let content = $('<div class="content"></div>');
        content.append(
          '<i class="fa-solid fa-trash-alt deleteRoute" title="Delete Route"></i>'
        );
        content.append('<div class="break"></div>');
        let form = $('<form method="post" data-route="' + route + '"></form>');
        locations.forEach(function (location) {
          form.append(
            '<span class="input-field" tabindex="0"><input type="text" name="location" class="location" value="' +
              location +
              '" area-label="location" title="Click to Edit"></span>'
          );
        });
        form.append(
          '<i class="fa-regular fa-square-plus addLocation" title="Add Location"></i>'
        );
        content.append(form);
        group.append(content);
        $(".content").append(group);
      });
      $(".content").append(
        '<div class="group"><div class="header addRoute"><i class="fa-solid fa-square-plus"></i></div></div>'
      );
    });
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
*/
