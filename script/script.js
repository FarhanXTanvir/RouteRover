var removedOptions1 = [];
var removedOptions2 = [];

document.querySelector("form").addEventListener("submit", function (event) {
  var input1 = document.querySelector('input[name="loc1"]');
  var input2 = document.querySelector('input[name="loc2"]');
  var list1 = document.querySelector("#loc1");
  var list2 = document.querySelector("#loc2");
  var options1 = Array.from(list1.options).map((option) => option.value);
  var options2 = Array.from(list2.options).map((option) => option.value);
  if (!options1.includes(input1.value) || !options2.includes(input2.value)) {
    event.preventDefault();
    alert("Please select a valid area.");
  }
});
