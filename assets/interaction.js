// decalring the inputs
let goalKeeperInputs = document.getElementById("goalkeeper-only-inputs");
let playersInputs = document.getElementById("players-only-inputs");
let position = document.getElementById("player-position");
let addPlayerBtn = document.getElementById("addPlayerBtn");
let modal = document.getElementById("addModal");

//------------------ Start Functions Daclaration section------------------
function showingInputs(){
    if(position.value == "gk"){
      goalKeeperInputs.classList.remove("hidden");
      playersInputs.classList.add("hidden");

  }else if(position.value == "") {
      goalKeeperInputs.classList.add("hidden");
      playersInputs.classList.add("hidden");

  }else {
      goalKeeperInputs.classList.add("hidden");
      playersInputs.classList.remove("hidden");
  }  
  }

//------------------END Functions Daclaration section------------------



addPlayerBtn.addEventListener("click", function(){
modal.classList.remove("hidden");
})

showingInputs();

position.addEventListener('change',showingInputs);