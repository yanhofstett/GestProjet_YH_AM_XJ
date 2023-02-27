const fetchData = () => {

    document.getElementById("dataList").innerHTML="";

    var element = document.getElementById("autocompletionForm");
    var user_input = element.value;

    if (user_input.length<2){
      return 0;
    }

    url = "https://swiss-state-npa-location.herokuapp.com/localite-autocompletion/"+user_input;
    axios.get(url)
    .then(response => {
      allLocations = response.data;

      for (var i=0; i<allLocations.length; i++){
        console.log("test");
        document.getElementById("dataList").appendChild(document.createElement("option")).setAttribute("value", allLocations[i].location + ", " + allLocations[i].canton);
      }
    })
    .catch(error => console.error(error));
  }