var removedOptions1 = [];
var removedOptions2 = [];

document.querySelector("form").addEventListener("submit", function (event) {
  var input1 = document.querySelector('input[name="areas1"]');
  var input2 = document.querySelector('input[name="areas2"]');
  var list1 = document.querySelector("#areas1");
  var list2 = document.querySelector("#areas2");
  var options1 = Array.from(list1.options).map((option) => option.value);
  var options2 = Array.from(list2.options).map((option) => option.value);
  if (!options1.includes(input1.value) || !options2.includes(input2.value)) {
    event.preventDefault();
    alert("Please select a valid area.");
  }
});

document
  .querySelector('input[name="areas1"]')
  .addEventListener("input", function () {
    var selectedOption = this.value;
    var optionElement = document.querySelector(
      '#areas2 option[value="' + selectedOption + '"]'
    );
    if (optionElement) {
      removedOptions2.push(optionElement);
      optionElement.remove();
    }
    var removedOption = removedOptions1.find(
      (option) => option.value === this.value
    );
    if (removedOption) {
      document.querySelector("#areas1").append(removedOption);
      removedOptions1 = removedOptions1.filter(
        (option) => option !== removedOption
      );
    }
  });

document
  .querySelector('input[name="areas2"]')
  .addEventListener("input", function () {
    var selectedOption = this.value;
    var optionElement = document.querySelector(
      '#areas1 option[value="' + selectedOption + '"]'
    );
    if (optionElement) {
      removedOptions1.push(optionElement);
      optionElement.remove();
    }
    var removedOption = removedOptions2.find(
      (option) => option.value === this.value
    );
    if (removedOption) {
      document.querySelector("#areas2").append(removedOption);
      removedOptions2 = removedOptions2.filter(
        (option) => option !== removedOption
      );
    }
  });