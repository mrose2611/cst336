function loadPets(pets) {
    $("#petsArea").html("");
    $("#petsArea").append("<hr>")
    for(var i = 0; i < pets.length; i++) {
        if(pets[i].SpecialNeeds == 1) {specialNeeds = "Yes";}
        else {specialNeeds = "No";}
        $("#petsArea").append(`
            <div class='Pet' id='Pet " + pets[i].idPets + "'>
                <h1 class='text-center'>` + pets[i].Name + `</h3>
                <h3 class='text-center'><img class='petimg' src='img/` + pets[i].Picture + `'/></h3>
                <h4 class='text-center'><strong>ID#:</strong> ` + pets[i].idPets + `</h4>
                <h4 class='text-center'><strong>D.O.B.:</strong> ` + pets[i].DOB + `</h4>
                <h4 class='text-center'><strong>Species: </strong> ` + pets[i].Breed + `</h4>
                <h4 class='text-center'><strong>Special Care Required: </strong> ` + specialNeeds + `</h4>
                <div class='text-center'><strong>Description: </strong> ` + pets[i].Description + `</div><br>
                <div class='text-center'><strong>Adoption Fee: </strong> $` + pets[i].Price + `</div>
                <form method='post'>
                <input type='hidden' name='idPets' value=` + pets[i].idPets + `>
                <input type='hidden' name='Name' value=` + pets[i].Name + `>
                <input type='hidden' name='Picture' value=` + pets[i].Picture + `>
                <input type='hidden' name='Price' value=` + pets[i].Price + `>
                <div class='text-center'><button class='btn adopt' id="`+ pets[i].idPets +`">Adopt!</button></div>
                </form>
            </div>
            <hr>`
        );
    }
}

function filterPets() {
    var species = new Array();
    var age = new Array();
    var specialCare;
    $(".speciesBox").each(function(index) {
        if(this.checked) {species.push("'" + this.value + "'");}
    })

    $(".ageBox").each(function(index) {
        if(this.checked) {age.push("'" + this.value + "'");}
    })
    
    specialCare = $("#specialCare").val();
    if(specialCare == "Yes") {specialCare = 1;}
    else if(specialCare == "No") {specialCare = 0;}

    if(species.length > 0 && age.length > 0) {
       $.ajax({
            type : "post",
            url  : "getPets.php",
            data : {"species" : species, "age" : age, "specialCare" : specialCare},
            success : function(data){
                var pets;
                pets = JSON.parse(data);
                loadPets(pets);
            },
            complete: function(data,status) { //optional, used for debugging purposes
                console.log(data);
            }
        });
    } else {
        alert("You must select at least one filter option!");
    }
}

function selectAll (btnClass) {
    $(btnClass).each(function(index) {
        this.checked = true;
    })
}

function unselectAll (btnClass) {
    $(btnClass).each(function(index) {
        this.checked = false;
    })
}